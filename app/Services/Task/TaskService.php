<?php

namespace App\Services\Task;
use app\DTOs\Task\TaskDTO;
use App\Filters\Task\TaskFilter;
use App\Http\Requests\Task\CreateTaskRequest;
use App\models\Task;

use App\Services\ErrorLogging\ErrorLoggingService;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class TaskService
{

  public function create(TaskDTO $dto): ?Task
  {

      try{
          return Task::create($dto->toArray());
      }catch (\Throwable $e){
          ErrorLoggingService::log($e);
          return null;
      }
  }

  public function update(Task $task, TaskDTO $dto): ?Task
  {

      try{

          $task->update($dto->toArray());

          return $task;
      }catch (\Throwable $e){
          ErrorLoggingService::log($e);
          return null;
      }
  }

  public function delete(Task $task): void{

      try {
          $task->delete();
      }catch (\Throwable $e){
          ErrorLoggingService::log($e);
          return;
      }
  }

  public function listAll(Request $request)
  {
      try {

             $query=Task::with('user.roles')->latest();
             $query=app(Pipeline::class)->send($query)->through([
                 fn ($query) => (new TaskFilter($request))->apply($query),
             ])->thenReturn();

          $per_page=$request->get('per_page',10);

          return $query->paginate($per_page);
      }catch (\Throwable $e){
          ErrorLoggingService::log($e);
          return collect();
      }
  }


}
