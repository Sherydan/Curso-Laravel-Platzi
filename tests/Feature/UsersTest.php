<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;


class UsersTest extends TestCase
{
    
    # la clase (UsersTest) se conoce como un testcase
    # TODAS las clases de test se conocen como la test suite

    # cada metodo es un test puntual
    public function testCanSeeUserPage(){
        $user = factory(User::class)->create();

        $response = $this->get("/users/$user->username");
        $response->assertSee($user->username);

    }

    public function testCanLogin(){
        $user = factory(User::class)->create();
        $other = factory(User::class)->create();

        $response = $this->post("/login", [
            'email' => $user->email, 
            'password'=>'secret']);

        $this->assertAuthenticatedAs($user);
    }

    public function testCanFollow(){
        $user = factory(User::class)->create();
        $other = factory(User::class)->create();

        # actingAs logea al usuario
        $response = $this->actingAs($user)->post('/users/'. $other->username .'/follow');

        
        $this->assertDatabaseHas('followers',[
            'user_id' => $user->id,
            'followed_id' => $other->id,
        ]);

    }
}