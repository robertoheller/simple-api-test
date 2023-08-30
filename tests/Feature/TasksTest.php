<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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


    public function test_edit_tasks()
    {
        $payload = [
            'title' => 'Test User',
            'description' => 'description test',
            'updated_user_id' => '1',
            'completed' => '0',
        ];

        $response = $this->post('/api/tasks/1', $payload)
            ->assertStatus(200);
    }

    public function test_tasks_image_list()
    {

        $response = $this->get('/api/tasks/1/image')
            ->assertStatus(200);

    }


    public function test_task_image_can_be_uploaded(): void
    {
        Storage::fake('avatars');
 
        $file = UploadedFile::fake()->image('avatar.jpg');
 
        $response = $this->post('/api/tasks/1/image', [
            'image' => $file,
        ])->assertStatus(200);
 
        // Storage::disk('avatars')->assertExists('/image/'.$file->hashName());
    }

    // public function test_task_image_delete(): void
    // {

    //     $response = $this->delete('/api/tasks/1/image/1')
    //         ->assertStatus(200);

    // }


    public function test_delete_tasks()
    {
        $response = $this->delete('/api/tasks/1')
            ->assertOk(200);
    }

}
