<?php

namespace App\Repository;

use App\Models\Board;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BoardRepository {

    protected $boardRepository;
    protected $userRepository;

    public function __construct(
        Board $boardRepository,
        User $userRepository,
    )
    {
        $this->boardRepository = $boardRepository;
        $this->userRepository = $userRepository;
    }

    public function indexBoard()
    {
        try {
            $user = $this->userRepository::find(Auth::id());

            $boards = $user->boards()->wherePivotIn('role', ['admin', 'collaborator'])->get()->toArray();

            return response()->json(['data' => $boards], 200);

        } catch(Exception $e) {
            Log::error("Erro ao carregar quadros: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao carregar quadro!"], 500);
        }
    }

    public function storeBoard(array $data)
    {
         try {
            $board = $this->boardRepository::create([
                'name' => $data['name'],
            ]);

            $board->users()->attach(Auth::id(), ['role' => 'admin']);

            return response()->json(['message' => 'Quadro criado com sucesso!'], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar quadro: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar quadro!"], 500);
        }
    }

    public function updateBoard(array $data)
    {
        try {
            $this->boardRepository::find($data['id'])->update([
                'name' => $data['title'],
            ]);

            return response()->json(['message' => "Quadro atualizado com sucesso!"], 200);

        }catch (Exception $e) {
            Log::error("Erro ao atualizar o quadro: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao atualizar o quadro. Tente novamente mais tarde!"], 500);
        }
    }

    public function deleteBoard(int $id)
    {
        try {
            $task = $this->boardRepository::findOrFail($id);
            $task->delete();

            return response()->json(['message' => "Qaudro excluído com sucesso!"], 200);

        } catch (Exception $e) {
            Log::error("Erro ao excluir quadro: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao excluir quadro. Tente novamente mais tarde!"], 500);
        }
    }

    public function checkIfBoardExits(int $id) {
        $result = $this->boardRepository::where('id', $id)->exists();

        return $result;
    }
}
