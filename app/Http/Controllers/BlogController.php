<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(9);

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Blog list retrieved successfully',
            ],
            'data' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::with(['category', 'tags'])->where('slug', $slug)->first();

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
        $blogs = Blog::with('category')
            ->where('category_id', $categoryId)
            ->latest()
            ->paginate(9);

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Blogs retrieved by category successfully',
            ],
            'data' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }
}
