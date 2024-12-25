<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

interface CategoryService
{
    function getAll(): JsonResponse;
    function getById(int $id): CategoryResource;
    function create(array $data): CategoryResource;
    function update(int $id,array $data): CategoryResource;
    function delete(int $id): void;
}