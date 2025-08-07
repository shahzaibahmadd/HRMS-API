<?php

namespace App\Http\Controllers\Task;

use App\DTOs\Task\TaskDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\Task\TaskService;
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
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $dto = new UpdateTaskDTO(...$request->validated());

        $updatedTask = $this->taskService->update($task, $dto);

        if (!$updatedTask) {
            return ResponseHelper::error("Task not updated");
        }

        return ResponseHelper::success(new TaskResource($updatedTask), "Task updated");
    }
}
