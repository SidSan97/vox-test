<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Repository\CategoriesRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(
        CategoriesRepository $categoriesRepository,
    )
    {
        $this->categoryRepository = $categoriesRepository;
    }

    public function show(int $id)
    {
        $data = $this->categoryRepository->showCategories($id);

        return $data;
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        $result = $this->categoryRepository->storeCategory($data);

        return $result;
    }
}
