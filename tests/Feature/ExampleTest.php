<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }



	public function testTaskIndex(){
	    $user = factory(User::class)->create();
	    $this->actingAs($user);
	    $response =$this->get( '/task');
	    $response->assertStatus(200);
	    $response->assertJson([
	    ]);

	}

	public function testTaskStore(){
		$user = factory(User::class)->create();
		$this->actingAs($user);
		$taskData=[
			"title" => "unit testing..."
		];
		$response =$this->post( '/task',$taskData);
		$response->assertStatus(200);
		$response->assertJson([
			"user_id"=>$user->id,
			"title" =>"unit testing...",
			"completed" => 0
		]);
	}


	public function testTaskDestroy(){
		$task = User::first()->tasks()->first();

		$this->actingAs( User::first());

		$response =$this->delete( '/task/'.$task->id);
		$response->assertStatus(200);

	}
}
