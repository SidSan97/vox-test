<?php

namespace App\Repository;

use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskRepository {

    protected $taskRepository;

    public function __construct(
        Task $taskRepository,
    )
    {
        $this->taskRepository = $taskRepository;
    }

    public function showTask(int $id)
    {
        try {
            $task = $this->taskRepository::where('id', $id)->with('user:id,name')->first();

            return response()->json(['data' => $task], 200);
        } catch (Exception $e) {
            Log::error("Erro ao carregar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao carregar task. Tente novamente."], 500);
        }
    }

    public function storeTask(array $data)
    {
        try {
            $position = $this->getLastPositionTask($data['category_id']);

            $this->taskRepository::create([
                'category_id' => $data['category_id'],
                'user_id' => Auth::id(),
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'position' => $position,
            ]);

            return response()->json(['message' => "Task criada com sucesso!"], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar task!"], 500);
        }
    }

    public function reorderTask(array $data)
    {
        try {
            foreach ($data['tasks'] as $taskData) {
                $this->taskRepository::where('id', $taskData['id'])->update([
                    'category_id' => $data['category_id'],
                    'position' => $taskData['position']
                ]);
            }

            return response()->json(['message' => 'Tarefas reordenadas']);

        } catch(Exception $e) {
            Log::error("Erro ao reordenar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao reordenar task!"], 500);
        }
    }

    public function editTask(array $data)
    {
        try {
            $this->taskRepository::find($data['id'])->update([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
            ]);

            return response()->json(['message' => "Tarefa atualizada com sucesso!"], 200);

        }catch (Exception $e) {
            Log::error("Erro ao atualizar a tarefa: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao atualizar a tarefa. Tente novamente mais tarde!"], 500);
        }
    }

    public function deleteTask(int $id)
    {
        try {
            $task = $this->taskRepository::findOrFail($id);
            $task->delete();

            return response()->json(['message' => "Tarefa excluída com sucesso!"], 200);

        } catch (Exception $e) {
            Log::error("Erro ao excluir tarefa: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao excluir tarefa. Tente novamente mais tarde!"], 500);
        }
    }

    public function getLastPositionTask(int $categoryId)
    {
        $lastPosition = $this->taskRepository::where('category_id', $categoryId)->max('position');

        $nextPosition = is_null($lastPosition) ? 0 : $lastPosition + 1;

        return $nextPosition;
    }
}
