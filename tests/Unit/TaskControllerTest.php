<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class TaskControllerTest extends TestCase
{

    public function test_tasks_it_stores_task_with_images()
    {

        $image1 = UploadedFile::fake()->image('document.jpg', 300);
        $image2 = UploadedFile::fake()->image('document2.jpg', 300);

        $data = [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'created_user_id' => 2,
            'image' => [$image1, $image2],
        ];

        $response = $this->post('/api/tasks', $data);

        $response->assertStatus(201);

        $responseData = json_decode($response->getContent(), true);

        $this->assertDatabaseHas('tasks', ['title' => 'Task Title']);
        $this->assertDatabaseHas('images', ['task_id' => $responseData['id']]);
        $this->assertDatabaseHas('images', ['task_id' => $responseData['id']]);

    }
}
