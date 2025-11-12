<?php

namespace App\Services;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getCategoriesByType(string $type): Collection {
        return $this->categoryRepository->getByType($type);
    }

}
