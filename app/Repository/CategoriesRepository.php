<?php

namespace App\Repository;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoriesRepository {

    protected $categoryRepository;
    protected $boardRepositoryClass;

    public function __construct(
        Category $categoryRepository,
        BoardRepository $boardRepositoryClass,
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->boardRepositoryClass = $boardRepositoryClass;
    }

    public function showCategories(int $id)
    {
        try {
            $exists = $this->boardRepositoryClass->checkIfBoardExits($id);

            if(!$exists) {
                return response()->json(['redirect' => route('desktop')]);
            }

            $categories = $this->categoryRepository::with(['tasks' => function ($query) {
                $query->orderBy('position', 'asc');
            }])->where('board_id', $id)->get()->toArray();

            return response()->json(['data' => $categories], 200);

        } catch(Exception $e) {
            Log::error("Erro ao carregar categoria: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao carregar categoria!"], 500);
        }
    }

    public function storeCategory(array $data)
    {
        try {
            $this->categoryRepository::create([
                'title' => $data['title'],
                'board_id' => $data['board_id'],
            ]);

            return response()->json(['message' => "Categoria criada com sucesso!"], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar categoria: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar categoria!"], 500);
        }
    }
}
