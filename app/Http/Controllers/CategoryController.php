<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     private CategoryService $categoryService;

     public function __construct(CategoryService $categoryService)
     {
          $this->categoryService = $categoryService;
     }
     /**
     * @OA\Get(
     *     path="/api/category-products",
     *     summary="View all category and their product",
     *     tags={"Category"},
     *     security={{"BearerToken": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="furniture"),
     *                  @OA\Property(
     *                      property="product",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="category_id", type="integer", example=1),
     *                          @OA\Property(property="name", type="string", example="kursi"),
     *                          @OA\Property(property="price", type="integer", example=100000),
     *                          @OA\Property(property="image", type="string", example="IMG-0001")
     *                          )
     *                      )
     *                  )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */
     public function get(): JsonResponse 
     {
          return $this->categoryService->getAll();
     }

     /**
     * @OA\Get(
     *     path="/api/category-products/{id}",
     *     summary="View category and their product by id",
     *     tags={"Category"},
     *     security={{"BearerToken": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data",type="object", 
     *                       @OA\Property(property="id", type="integer", example=1),
     *                       @OA\Property(property="name", type="string", example="furniture"),
     *                       @OA\Property(
     *                             property="product",
     *                             type="array",
     *                                @OA\Items(
     *                                    type="object",
     *                                    @OA\Property(property="category_id", type="integer", example=1),
     *                                    @OA\Property(property="name", type="string", example="kursi"),
     *                                    @OA\Property(property="price", type="integer", example=100000),
     *                                    @OA\Property(property="image", type="string", example="IMG-0001")
     *                                )
     *                             )
     *                       )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */

     public function getById(Request $request): CategoryResource 
     {
          return $this->categoryService->getById($request->id);
     }

      /**
     * @OA\Post(
     *     path="/api/category-products",
     *     summary="Make a new category Product",
     *     tags={"Category"},
     *     security={{"BearerToken": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               @OA\Property(property="name", type="string", example="furniture"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="data",type="object",
          *             @OA\Property(property="id", type="string", example="1"),
          *             @OA\Property(property="name", type="string", example="furniture"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */

     public function create(CategoryRequest $request): JsonResponse
     {
          $data = $request->validated();

          return $this->categoryService->create($data)->response()->setStatusCode(201);
     }

     /**
     * @OA\Patch(
     *     path="/api/category-products/{id}",
     *     summary="Update a category Product",
     *     tags={"Category"},
     *     security={{"BearerToken": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               @OA\Property(property="name", type="string", example="equipment"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data",type="object",
     *                   @OA\Property(property="id", type="string", example="1"),
     *                   @OA\Property(property="name", type="string", example="equipment"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *     )
     * )
     */

     public function update(CategoryRequest $request): CategoryResource 
     {
          $data = $request->validated();
          return $this->categoryService->update($request->id, $data);
     }

     /**
     * @OA\Delete(
     *     path="/api/category-products/{id}",
     *     summary="Delete a category Product",
     *     tags={"Category"},
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

     public function delete(Request $request) {
          $this->categoryService->delete($request->id);
          return response()->json(null, 204);
     }
}
