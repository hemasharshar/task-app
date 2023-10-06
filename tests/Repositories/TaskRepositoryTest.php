<?php namespace Tests\Repositories;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TaskRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TaskRepository
     */
    protected $taskRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->taskRepo = \App::make(TaskRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_task()
    {
        $tasks = Task::factory()->make()->toArray();

        $createdTasks = $this->taskRepo->create($tasks);

        $createdTasks = $createdTasks->toArray();
        $this->assertArrayHasKey('id', $createdTasks);
        $this->assertNotNull($createdTasks['id'], 'Created Task must have id specified');
        $this->assertNotNull(Task::find($createdTasks['id']), 'Task with given id must be in DB');
        $this->assertModelData($tasks, $createdTasks);
    }

    /**
     * @test read
     */
    public function test_read_task()
    {
        $tasks = Task::factory()->create();

        $dbTasks = $this->taskRepo->find($tasks->id);

        $dbTasks = $dbTasks->toArray();
        $this->assertModelData($tasks->toArray(), $dbTasks);
    }

    /**
     * @test update
     */
    public function test_update_task()
    {
        $tasks = Task::factory()->create();
        $fakeTask = Task::factory()->make()->toArray();

        $updatedTask = $this->taskRepo->update($fakeTask, $tasks->id);

        $this->assertModelData($fakeTask, $updatedTask->toArray());
        $dbTask = $this->taskRepo->find($tasks->id);
        $this->assertModelData($fakeTask, $dbTask->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_task()
    {
        $tasks = Task::factory()->create();

        $resp = $this->taskRepo->delete($tasks->id);

        $this->assertTrue($resp);
        $this->assertNull(Task::find($tasks->id), 'Task should not exist in DB');
    }
}
