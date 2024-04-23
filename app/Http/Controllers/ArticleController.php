<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Get all articles
    public function getAllArticles()
    {
        $articles = Article::all();
        $articlesCount = $articles->count();

        return response()->json([
            'message' => 'Articles retrieved successfully',
            'articlesCount' => $articlesCount,
            'articles' => $articles
        ]);
    }

    // Get article by id
    public function getArticleById($id)
    {
        $article = Article::find($id);

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

    // Create article
    public function createArticle(Request $request)
    {
        $article = Article::create($request->all());

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article
        ]);
    }

    // Update article
    public function updateArticle(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        // Only update the fields that are present in the request body and ignore the rest
        $article->fill($request->all());
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

        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}

