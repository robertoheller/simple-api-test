<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Task;
use App\Models\Image;

use Illuminate\Http\Response;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($task)
    {
        $task = Task::find($task);
        if(!$task){
            return response()->json([
              'message'=>'Task Not Found.'
            ],404);
        }
        $data = Image::where('task_id', $task->id)->get();

        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request, $task)
    {
        try {

            $task = Task::find($task);

            if(!$task){
                return response()->json([
                'message'=>'Task Not Found.'
                ],404);
            }

            $validatedData = $request->validated();

            $validatedData['image'] = $request->file('image')->store('image');

            $data = Image::create($validatedData);


            return response($data, Response::HTTP_CREATED);

        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Image $image)
    {
        $data = Image::find($image)->first()->delete();

        return response()->json([

            'deleted'   => true,

            'message'   => 'Deleted success'

        ]);
    }
}
