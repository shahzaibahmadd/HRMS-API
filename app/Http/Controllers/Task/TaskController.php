<?php

namespace App\Http\Controllers\Task;

use App\DTOs\Task\TaskDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\services\Task\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService){}

    public function store(CreateTaskRequest $request){
        $data=$request->validated();
        $data['assigned_by']= auth()->id();
        $dto=new TaskDTO(...$data);
        $task=$this->taskService->create($dto);
        if(!$task){
            return ResponseHelper::error("Task not created");
        }
        return ResponseHelper::success(new TaskResource($task),"Task created");
    }

    public function index(Request $request){
        $tasks=$this->taskService->listAll($request);
        return ResponseHelper::success(TaskResource::collection($tasks),"Task lists");
    }
}
