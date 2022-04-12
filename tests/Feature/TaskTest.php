<?php  
namespace Hattori\ToDo\Tests\Feature;

use Hattori\ToDo\Models\Label;
use Hattori\ToDo\Models\Task;
use Hattori\ToDo\Models\User;
use Hattori\ToDo\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class TaskTest extends TestCase
{
    use RefreshDatabase;
	public function setUp():void
	{
		parent::setUp();
	}

	public function testGetUsersTasks() {
        $user = factory(User::class)->create();
		factory(Task::class, 10)->create([
            'user_id' => $user->id
        ])->each(function($task) {
        	$task->labels()->sync(factory(Label::class, 5)->create()->pluck('id')->toArray());
        });

        $response = $this->actingAs($user)->get('/tasks');

         $response->assertStatus(200)
         ->assertJsonStructure([
			    'status',
			    'data' => [
			      '*' =>[
			        'id',
			        'title',
			        'description',
			        'status',
			        'labels'
			      ]
			    ]
			  ]);
	}
	public function testCreateTasks() {
        $user = factory(User::class)->create();

		$task = factory(Task::class)->make([
            'user_id' => $user->id
        ]);

		$labels = factory(Label::class, 10)->create([
            'user_id' => $user->id
        ]);
		$payload = [
        	'title' => $task->title,
        	'description' => $task->description,
        	'labels' => $labels->pluck('id')->toArray()
        ];
        $response = $this->actingAs($user)->post('tasks', $payload);

         $response->assertStatus(201)
         ->assertJsonStructure([
         	'message',
         	'data'
         ]);

         $this->assertDatabaseHas('tasks', [
         	'title' => $task->title,
        	'description' => $task->description,
         ]);
	}

	public function testEditTasks() {
        $user = factory(User::class)->create();

		$task = factory(Task::class)->create([
            'user_id' => $user->id
        ]);

		$payload = [
			'title' => 'test',
			'description' => 'test',
			'status' => 'close',
			'labels' => []
		];

        $response = $this->actingAs($user)->patch('tasks/'.$task->id, $payload);
         
         $response->assertStatus(200)
         ->assertJsonStructure([
         	'message',
         	'data'
         ]);

         $this->assertDatabaseHas('tasks', [
         	'title' => 'test',
			'description' => 'test',
			'status' => 'close'
         ]);
	}

	public function testShowTask() {
        $user = factory(User::class)->create();

		$task = factory(Task::class)->create([
            'user_id' => $user->id
        ]);

		$labels = factory(Label::class, 5)->create();
		$task->labels()->sync($labels->pluck('id')->toArray());
        $response = $this->actingAs($user)->get('tasks/'.$task->id);
         
         $response->assertStatus(200)
         ->assertJsonStructure([
         	'data'
		 ]);

         
	}

}
?>