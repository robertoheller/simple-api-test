<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Image;

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

        if ($request->hasFile('image')) {

            foreach ($request->file('image') as $file) {

                $image = new Image;
                $image->image = $file->store('image');
                $image->task_id = $data->id;
                $image->save();

            }

        }

        return response($data, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $data = Task::find($task);

        $data->load('images');

        return response($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {

        $validatedData = $request->validated();

        $data = Task::find($task)->first();

        $data->update($validatedData);

        return response($data, 200);

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
