<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function show(int $id) {
        try {
            $task = Task::where('id', $id)->first();

            return response()->json(['data' => $task], 200);
        } catch (Exception $e) {
            Log::error("Erro ao carregar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao carregar task. Tente novamente."], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|integer|min:1',
                'title' => 'required|string|max:255',
                'description' => 'string|max:500',
            ]);

            $position = $this->getLastPositionTask($request->category_id);

            Task::create([
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description ?? null,
                'position' => $position,
            ]);

            return response()->json(['message' => "Task criada com sucesso!"], 201);

        } catch(Exception $e) {
            Log::error("Erro ao criar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao criar task!"], 500);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|integer|min:1',
                'tasks' => 'required|array',
            ]);

            foreach ($request->tasks as $taskData) {
                Task::where('id', $taskData['id'])->update([
                    'category_id' => $request->category_id,
                    'position' => $taskData['position']
                ]);
            }

            return response()->json(['message' => 'Tarefas reordenadas']);

        } catch(Exception $e) {
            Log::error("Erro ao reordenar task: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao reordenar task!"], 500);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|min:1',
                'title' => 'required|string|max:255',
                'description' => 'string|max:500',
            ]);

            Task::find($request->id)->update([
                'title' => $request->title,
                'description' => $request->description ?? null,
            ]);

            return response()->json(['message' => "Tarefa atualizada com sucesso!"], 200);

        }catch (Exception $e) {
            Log::error("Erro ao atualizar a tarefa: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao atualizar a tarefa. Tente novamente mais tarde!"], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json(['message' => "Tarefa excluída com sucesso!"], 200);

        } catch (Exception $e) {
            Log::error("Erro ao excluir tarefa: ", ['error' => $e->getMessage()]);

            return response()->json(['message' => "Erro ao excluir tarefa. Tente novamente mais tarde!"], 500);
        }
    }

    public function getLastPositionTask(int $categoryId)
    {
        $lastPosition = Task::where('category_id', $categoryId)->max('position');

        $nextPosition = is_null($lastPosition) ? 0 : $lastPosition + 1;

        return $nextPosition;
    }

}
