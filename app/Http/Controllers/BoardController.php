<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardDeleteRequest;
use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\BoardUpdateRequest;
use App\Models\Board;
use App\Models\User;
use App\Repository\BoardRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BoardController extends Controller
{
    protected $boardRepository;

    public function __construct(
        BoardRepository $boardRepository,
    )
    {
        $this->boardRepository = $boardRepository;
    }

    public function index()
    {
        $data = $this->boardRepository->indexBoard();

        return $data;
    }

    public function store(BoardStoreRequest $request)
    {
        $data = $request->validated();

        $result = $this->boardRepository->storeBoard($data);

        return $result;
    }

    public function update(BoardUpdateRequest $request)
    {
        $data = $request->validated();

        if($data['role'] !== "admin") {
            return response()->json(['message' => "Você não possui permissão para esta ação!"], 403);
        }

        $result = $this->boardRepository->updateBoard($data);

        return $result;
    }

    public function delete(BoardDeleteRequest $request, int $id)
    {
        $validation = $request->validated();

        if($validation['role'] !== "admin") {
            return response()->json(['message' => "Você não possui permissão para esta ação!"], 403);
        }

        $data = $this->boardRepository->deleteBoard($id);

        return $data;
    }
}
