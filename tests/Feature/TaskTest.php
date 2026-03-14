<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
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

    public function test_createTask(): void{

        $user = User::factory()->create();
        $response = $this->actingAs($user,'sanctum')->postJson('/api/tasks',[
              'name' => fake()->name(),
              'description' => fake()->paragraph(),
              'user_id'=> $user->id
            ]);
        //$response->dump();
        $response->assertCreated();
        $response->assertJsonStructure([
            'message',
            'data']);    
    }

    public function test_updateTask(): void{
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user,'sanctum')->putJson("/api/tasks/{$task->id}",[
              'name' => fake()->name(),
              'description' => fake()->paragraph()
            ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data']); 
    }

    public function test_deleteTask():void{
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user,'sanctum')->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message']); 
    }

    public function test_getallTask():void{
        $user = User::factory()->create();
        //$task = Task::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user,'sanctum')->getJson("/api/tasks");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data'
        ]); 
    }

    public function test_getTask():void{
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user,'sanctum')->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data'
        ]); 
    }
}
