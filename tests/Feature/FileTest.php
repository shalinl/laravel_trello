<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_fileUpload():void{

        Storage::fake('public');
        $file = UploadedFile::fake()->image('test.jpg');
        $user = User::factory()->create();
        $task = Task::factory(['user_id'=>$user->id])->create();
        $response = $this->actingAs($user,'sanctum')->postJson('/api/files',['file'=>$file,'task_id'=>$task->id]);
        $response->assertCreated();
        $response->assertJsonStructure(['status','message']);
    }
}
