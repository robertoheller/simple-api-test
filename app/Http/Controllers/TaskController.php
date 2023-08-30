<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tasks = Task::paginate(10);

        return $tasks;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {

        $validatedData = $request->validated();

        $data = Task::create($validatedData);

        return response($data, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $data = Task::find($task);

        return response($data, Response::HTTP_ACCEPTED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {

        $validatedData = $request->validated();

        $data = Task::find($task)->first();

        return $data->update($validatedData);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {

        $data = Task::find($task)->first()->delete();

        return response()->json([

            'deleted'   => true,

            'message'   => 'Deleted success'

        ]);
    }
}
