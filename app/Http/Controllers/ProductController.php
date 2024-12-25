<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="View all product",
     *     tags={"Product"},
     *     security={{"BearerToken": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                  @OA\Property(property="category_id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="kursi"),
     *                  @OA\Property(property="price", type="integer", example=10000),
     *                  @OA\Property(property="image", type="string", example="IMG-0007")
     *             ),
     *             @OA\Items(
     *                  @OA\Property(property="category_id", type="integer", example=2),
     *                  @OA\Property(property="name", type="string", example="meja"),
     *                  @OA\Property(property="price", type="integer", example=10000),
     *                  @OA\Property(property="image", type="string", example="IMG-0008")
     *             )
     *         )
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized"
     *     )
     * )
     */

    public function get(): JsonResponse 
    {
        return $this->productService->getAll();
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="View product by id",
     *     tags={"Product"},
     *     security={{"BearerToken": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="kursi"),
     *                 @OA\Property(property="price", type="integer", example=10000),
     *                 @OA\Property(property="image", type="string", example="IMG-0007"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */

    public function getById(Request $request): ProductResource 
    {
        return $this->productService->getById($request->id);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     tags={"Product"},
     *     security={{"BearerToken": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               @OA\Property(property="category_id", type="string", example="1"),
     *               @OA\Property(property="name", type="string", example="kursi"),
     *               @OA\Property(property="price", type="string", example="10000"),
     *               @OA\Property(property="image", type="string", example="IMG-0007"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="object", 
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="kursi"),
     *                 @OA\Property(property="price", type="integer", example=10000),
     *                 @OA\Property(property="image", type="string", example="IMG-0007"),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */

    public function create(CreateProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $image = $request->hasFile('image') ? $request->file('image') : null;
        return $this->productService->create($data, $image)->response()->setStatusCode(201);
    }

    /**
     * @OA\Post(
     *     path="/api/products/{id}",
     *     summary="Update a product",
     *     tags={"Product"},
     *     security={{"BearerToken": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               @OA\Property(property="category_id", type="integer", example=1),
     *               @OA\Property(property="name", type="string", example="meja"),
     *               @OA\Property(property="price", type="integer", example=10000),
     *               @OA\Property(property="image", type="string", example="IMG-0008"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *                 @OA\Property(property="data", type="object", 
     *                      @OA\Property(property="category_id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="kursi"),
     *                      @OA\Property(property="price", type="integer", example=10000),
     *                      @OA\Property(property="image", type="string", example="IMG-0007"),
     *                 ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */
    public function update(UpdateProductRequest $request): ProductResource
    {
        $data = $request->validated();
        $image = $request->hasFile('image') ? $request->file('image') : null;
        return $this->productService->update($request->id, $data, $image);
    }
    
    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product",
     *     tags={"Product"},
     *     security={{"BearerToken": {}}},
     *     @OA\Response(
     *         response=204,
     *         description="No Content",
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */

    public function delete(Request $request): JsonResponse 
    {
        $this->productService->delete($request->id);
        return response()->json(null, 204);
    }
}
