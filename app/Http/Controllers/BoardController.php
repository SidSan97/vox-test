<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BoardController extends Controller
{
    public function index()
    {
        try {
            $user = User::find(Auth::id());

            $boards = $user->boards()->wherePivotIn('role', ['admin', 'collaborator'])->get()->toArray();

            return response()->json(['data' => $boards], 200);

        } catch(Exception $e) {
            Log::error("Erro ao carregar quadros: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao carregar quadro!"], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $board = Board::create([
                'name' => $request->name,
            ]);

            $board->users()->attach(Auth::id(), ['role' => 'admin']);

            return response()->json(['message' => 'Quadro criado com sucesso!'], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar quadro: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar quadro!"], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $task = Board::findOrFail($id);
            $task->delete();

            return response()->json(['message' => "Qaudro excluído com sucesso!"], 200);

        } catch (Exception $e) {
            Log::error("Erro ao excluir quadro: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao excluir quadro. Tente novamente mais tarde!"], 500);
        }
    }
}
