<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
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

    public function test_createUser(): void{

        $input = User::factory()->make()->toArray();
        $input['password'] ='123Shalin@$^';
        $response = $this->postJson('/api/register',$input);
        $response->assertCreated();
        $this->assertDatabaseHas('users',['email'=>$input['email']]);
        $response->assertJsonStructure([
            'status',
            'message']);
    }

    public function test_loginUser(): void{

        $password = '123Shalin@$^';

        $user = User::factory()->create([
            'password' => Hash::make(substr($password,0,72))
        ]);
        $response = $this->postJson('/api/login',
                                ['email'=>$user->email,
                                'password'=>$password]);
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'token']);
    }


}
