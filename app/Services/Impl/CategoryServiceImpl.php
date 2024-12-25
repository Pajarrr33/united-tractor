<?php

namespace App\Services\Impl;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CategoryServiceImpl implements CategoryService
{
    function getAll(): JsonResponse
    {
        $categories = Category::with('products')->get();
        return CategoryResource::collection($categories)->response();
    }
    function getById(int $id): CategoryResource
    {
        $category = Category::with('products')->find($id);
        if (!$category) {
            throw new HttpResponseException(response()->json([
                'erros' => [
                     'category' => 'Category not found'
                     ]
                ], 404));
        }
        return new CategoryResource($category);
    }
    function create(array $data): CategoryResource
    {
        $category = Category::create($data);
        return new CategoryResource($category);
    }
    function update(int $id,array $data): CategoryResource
    {
        $category = Category::find($id);
        if (!$category) {
            throw new HttpResponseException(response()->json([
                'erros' => [
                     'category' => 'Category not found'
                     ]
                ], 404));
        }
        $category->update($data);
        return new CategoryResource($category);
    }
    function delete(int $id): void
    {
        $category = Category::find($id);
        if (!$category) {
            throw new HttpResponseException(response()->json([
                'erros' => [
                     'category' => 'Category not found'
                     ]
                ], 404));
        }
        $category->delete();
    }
}