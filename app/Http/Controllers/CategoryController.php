<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function show(int $id)
    {
        $boardController = new BoardController();
        $exists = $boardController->checkIfBoardExits($id);

        if(!$exists) {
            return response()->json(['redirect' => route('desktop')]);
        }

        $categories = Category::with(['tasks' => function ($query) {
            $query->orderBy('position', 'asc');
        }])->where('board_id', $id)->get()->toArray();

        return response()->json(['data' => $categories], 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'board_id' => 'required|integer|min:1'
            ]);

            Category::create([
                'title' => $request->title,
                'board_id' => $request->board_id,
            ]);

            return response()->json(['message' => "Categoria criada com sucesso!"], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar categoria: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar categoria!"], 500);
        }
    }
}
