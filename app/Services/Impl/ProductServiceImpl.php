<?php

namespace App\Services\Impl;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductServiceImpl implements ProductService
{
    function getAll(): JsonResponse
    {
        $products = Product::all();
        return ProductResource::collection($products)->response();
    }
    function getById(int $id): ProductResource
    {
        $product = Product::find($id);
        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                     'product' => 'Product not found'
                     ]
                ], 404));
        }
        return new ProductResource($product);
    }
    function create(array $data, $image = null): ProductResource
    {
        if (!Category::where('id', $data['category_id'])->exists()) 
        {
            throw new HttpResponseException(response()->json([
                'erros' => [
                     'category' => 'Category not found'
                     ]
                ], 404));
        }

        if ($image) 
        {
            $data['image'] = $image->store('images', 'public');
        }

        $product = Product::create($data);
        return new ProductResource($product);
    }
    function update(int $id, array $data, $image = null): ProductResource
    {
        $product = Product::find($id);
        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                     'product' => 'Product not found'
                     ]
                ], 404));
        }

        $data['category_id'] = $data['category_id'] ?? $product->category_id;
        $data['name'] = $data['name'] ?? $product->name;
        $data['price'] = $data['price'] ?? $product->price;

        if ($image) {
            $data['image'] = $image->store('images', 'public');
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        $product->update($data);
        return new ProductResource($product);
    }
    function delete(int $id): void
    {
        $product = Product::find($id);
        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                     'product' => 'Product not found'
                     ]
                ], 404));
        }

        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
    }
}