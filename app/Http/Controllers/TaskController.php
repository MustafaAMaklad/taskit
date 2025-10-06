<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\IndexRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResource
    {
        return TaskResource::collection(
            QueryBuilder::for(Task::class, $request)
                ->allowedFilters([
                    AllowedFilter::exact('status'),
                    AllowedFilter::scope('from_date'),
                    AllowedFilter::scope('to_date'),
                ])
                ->allowedSorts([
                    'title',
                    'created_at',
                    'due_date',
                ])
                ->defaultSort('-due_date')
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResource
    {
        return TaskResource::make(
            Task::create($request->only([
                'title',
                'description',
                'due_date',
                'assignee_id',
                'main_task_id'
            ]))->refresh()
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResource
    {
        return TaskResource::make($task->load('subTasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task): JsonResource
    {
        $task->update($request->only([
            'title',
            'description',
            'due_date',
            'assignee_id',
            'main_task_id'
        ]));

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->success();
    }
}
