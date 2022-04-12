<?php  
namespace Hattori\ToDo\Tests\Feature;

use Hattori\ToDo\Models\Label;
use Hattori\ToDo\Models\Task;
use Hattori\ToDo\Models\User;
use Hattori\ToDo\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class LabelTest extends TestCase
{
    use RefreshDatabase;
	public function setUp():void
	{
		parent::setUp();
	}

	public function testGetUsersLabels() {
        $user = factory(User::class)->create();
		factory(Label::class, 10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/labels');

         $response->assertStatus(200)
         ->assertJsonStructure([
			    'status',
			    'data' => [
			      '*' =>[
			        'id',
			        'text',
                    'tasks'
			      ]
			    ]
			  ]);
	}

    public function testCreateLabel() {
        $user = factory(User::class)->create();

		$label = factory(Label::class)->make([
            'user_id' => $user->id
        ]);

		$payload = [
        	'text' => $label->text,
        ];
        $response = $this->actingAs($user)->post('labels', $payload);

         $response->assertStatus(201)
         ->assertJsonStructure([
         	'message',
         	'data'
         ]);

         $this->assertDatabaseHas('labels', [
         	'text' => $label->text,
         ]);
	}


}
?>