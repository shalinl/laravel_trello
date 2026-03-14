<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;

class CommentTest extends TestCase
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

    public function test_createComment():void{

        $user = User::factory()->create();
        $task = Task::factory(['user_id'=>$user->id])->create();
        $response = $this->actingAs($user,'sanctum')->postJson('/api/comments',[
                "description"=>fake()->paragraph,
                "task_id"=>$task->id,
                "user_id"=>$user->id
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(["message","data"]);
    }

    public function test_updateComment(): void{
        $user = User::factory()->create();
        $task = Task::factory(['user_id'=>$user->id])->create();
        $comment = Comment::factory(['user_id'=>$user->id,'task_id'=>$task->id])->create();
        $response = $this->actingAs($user,'sanctum')->putJson("/api/comments/{$comment->id}",[
              'description' => fake()->paragraph()
            ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data']); 
    }

    public function test_deleteComment():void{
        $user = User::factory()->create();
        $task = Task::factory(['user_id'=>$user->id])->create(['user_id'=>$user->id]);
        $comment = Comment::factory(['user_id'=>$user->id,'task_id'=>$task->id])->create();
        $response = $this->actingAs($user,'sanctum')->deleteJson("/api/comments/{$comment->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message']); 
    }

    public function test_getallComments():void{
        $user = User::factory()->create();
        $response = $this->actingAs($user,'sanctum')->getJson("/api/comments");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data'
        ]); 
    }

    public function test_getCommentbyId():void{
        $user = User::factory()->create();
        $task = Task::factory(['user_id'=>$user->id])->create();
        $comment = Comment::factory(['user_id'=>$user->id,'task_id'=>$task->id])->create();
        $response = $this->actingAs($user,'sanctum')->getJson("/api/comments/{$comment->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data'
        ]); 
    }
}
