<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\DescriptionImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Get all articles
    public function getAllArticles()
    {
        $articles = Article::all();
        $articlesCount = $articles->count();

        // if prams count=true then return only count of articles
        if (request()->count) {
            return response()->json([
                'message' => 'Articles count retrieved successfully',
                'articlesCount' => $articlesCount
            ]);
        }

        return response()->json([
            'message' => 'Articles retrieved successfully',
            'articlesCount' => $articlesCount,
            'articles' => $articles
        ]);
    }

    // Get all public articles
    public function getAllPublicArticles()
    {
        $articles = Article::where('is_public', true)->get();
        $articlesCount = $articles->count();

        return response()->json([
            'message' => 'Public articles retrieved successfully',
            'articlesCount' => $articlesCount,
            'articles' => $articles
        ]);
    }

    // Get article by id
    public function getArticleById($id)
    {
        // Find article by id with description image relationship
        $article = Article::with('descriptionImages')->find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Article retrieved successfully',
            'article' => $article
        ]);
    }

    // Get article by public id
    public function getArticleByPublicId($id)
    {
        $article = Article::with('descriptionImages')->where('id', $id)->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Article retrieved successfully',
            'article' => $article
        ]);
    }

    // Get articles by category
    public function getArticlesByCategory($category)
    {
        $articles = Article::where('category', $category)->get();
        $articlesCount = $articles->count();

        return response()->json([
            'message' => 'Articles retrieved successfully',
            'articlesCount' => $articlesCount,
            'articles' => $articles
        ]);
    }

    // Create article
    public function createArticle(Request $request)
    {
        try {
            $createArticle = $request->all();

            $description_images = $createArticle['description_images'];
            unset($createArticle['description_images']);

            // Handle single image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/articles'), $imageName);
                $createArticle['image'] = 'images/articles/' . $imageName;
            }

            $article = Article::create($createArticle);

            // add article id to each description image
            foreach ($description_images as $key => $description_image) {
                $description_images[$key]['article_id'] = $article->id;
            }

            $article = DescriptionImage::create([
                'image' => "images/description_images/$imageName",
                'article_id' => $article->id
            ]);

            return response()->json([
                'message' => 'Article created successfully',
                'article' => $article
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Article creation failed',
                'error' => $e->getMessage()
            ], 409);
        }
    }

    // Update article
    public function updateArticle(Request $request, $id)
    {
        $updateArticle = $request->all();
        $article = Article::find($id);

        // if article has an image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/article'), $imageName);
            $updateArticle['image'] = 'images/article/' . $imageName;
        }

        // and delete the old image
        if (file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        // Only update the fields that are present in the request body and ignore the rest
        $article->fill($updateArticle);
        $article->save();

        return response()->json([
            'message' => 'Article updated successfully',
            'article' => $article
        ]);
    }

    // Delete article
    public function deleteArticle($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        // delete the image
        if (file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }

        // delete the description images
        foreach ($article->descriptionImages as $descriptionImage) {
            if (file_exists(public_path($descriptionImage->image))) {
                unlink(public_path($descriptionImage->image));
            }
            $descriptionImage->delete();
        }

        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}
