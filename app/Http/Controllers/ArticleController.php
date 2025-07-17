<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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
        $article = Article::find($id);

        // discretion_image is a json array, so we need to decode it
        if ($article && $article->description_image) {
            $article->description_image = json_decode($article->description_image, true);
        }

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
        $article = Article::where('id', $id)->where('is_public', true)->first();

        // discretion_image is a json array, so we need to decode it
        if ($article && $article->description_image) {
            $article->description_image = json_decode($article->description_image, true);
        }

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

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/articles'), $imageName);
                $createArticle['image'] = 'images/article/' . $imageName;
            } else {
                $createArticle['image'] = null;
            }

            $article = Article::create($createArticle);

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

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        // Update article
        $article->update($updateArticle);
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

        // Delete article
        $article->delete();
        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}
