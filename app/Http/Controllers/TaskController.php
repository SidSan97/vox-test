<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|integer|min:1',
                'title' => 'required|string|max:255',
                'description' => 'string|max:500',
                'position' => 'required|integer|min:0',
            ]);

            Task::create([
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description ?? null,
                'position' => $request->position,
            ]);

            return response()->json(['message' => "Task criada com sucesso!"], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar task!"], 500);
        }
    }
}
