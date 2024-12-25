<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

interface ProductService
{
    function getAll(): JsonResponse;
    function getById(int $id): ProductResource;
    function create(array $data, $image = null): ProductResource;
    function update(int $id, array $data, $image = null): ProductResource;
    function delete(int $id): void;
}