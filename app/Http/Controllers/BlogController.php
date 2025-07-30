<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->get();

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Blog list retrieved successfully',
            ],
            'data' => $blogs,
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::with('category')->where('slug', $slug)->first();

        if (!$blog) {
            return response()->json([
                'meta' => [
                    'status' => 'error',
                    'message' => 'Blog not found',
                ],
                'data' => null,
            ], 404);
        }

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Blog details retrieved successfully',
            ],
            'data' => $blog,
        ]);
    }

    public function byCategory($categoryId)
    {
        $blogs = Blog::with('category')->where('category_id', $categoryId)->latest()->get();

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Blogs retrieved by category successfully',
            ],
            'data' => $blogs,
        ]);
    }
}
