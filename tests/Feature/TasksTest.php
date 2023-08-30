<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;

class TasksTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_tasks_list(): void
    {
        $response = $this->get('/api/tasks')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'created_user_id',
                            'created_at'
                        ]
                    ]
                ]
            );
    }


    public function test_new_tasks()
    {
        $payload = [
            'title' => 'Test User',
            'description' => 'description test',
            'created_user_id' => '1',
            'completed' => '0',
        ];

        $response = $this->post('/api/tasks', $payload)
            ->assertJsonStructure(
                [
                    'id',
                    'title',
                    'description',
                    'updated_at',
                    'created_at'
                ]
            );
    }

    public function test_show_task()
    {

        $task = Task::first();

        $response = $this->get('/api/tasks/' . $task->id)
            ->assertStatus(200);
    }


    public function test_edit_tasks()
    {
        $task = Task::first();

        $payload = [
            'title' => 'Test User',
            'description' => 'description test',
            'updated_user_id' => '1',
            'completed' => '1',
        ];

        $response = $this->put('/api/tasks/' . $task->id, $payload)
            ->assertStatus(200);
    }


    public function test_delete_tasks()
    {
        $task = Task::first();

        $response = $this->delete('/api/tasks/' . $task->id)
            ->assertStatus(200);
    }

}
