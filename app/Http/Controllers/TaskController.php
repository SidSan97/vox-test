<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskReorderRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Repository\TaskRepository;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(
        TaskRepository $taskRepository,
    )
    {
        $this->taskRepository = $taskRepository;
    }

    public function show(int $id) {
        $data = $this->taskRepository->showTask($id);

        return $data;
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        $result = $this->taskRepository->storeTask($data);

        return $result;
    }

    public function reorder(TaskReorderRequest $request)
    {
        $data = $request->validated();

        $result = $this->taskRepository->reorderTask($data);

        return $result;
    }

    public function edit(TaskUpdateRequest $request)
    {
        $data = $request->validated();

        $result = $this->taskRepository->editTask($data);

        return $result;
    }

    public function delete(int $id)
    {
        $data = $this->taskRepository->deleteTask($id);

        return $data;
    }
}
