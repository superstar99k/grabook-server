<?php

namespace Tests\Unit\Services;

use App\Enums\User\Status;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->userService = app()->make(UserService::class);

        User::insert([
            'id' => 1,
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => 'aaa',
            'verification_code' => 'bbb',
            'status' => Status::Activated,
        ]);

        Auth::shouldReceive('user')->andReturn(User::find(1));
    }

    /**
     * @test
     */
    public function store()
    {
        $user = $this->userService->store([
            'name' => 'test2',
            'email' => 'test2@example.com',
        ]);

        $this->assertSame($user->name, 'test2');
        $this->assertSame($user->email, 'test2@example.com');
        $this->assertSame((string) $user->status, Status::Pending);
        $this->assertNotNull($user->verification_code);
        $this->assertNotNull($user->verification_generated_at);
    }

    /**
     * @test
     */
    public function update()
    {
        $user = $this->userService->update(1, [
            'name' => 'test111',
            'email' => 'test111@example.com',
        ]);

        $this->assertSame($user->name, 'test111');
        $this->assertSame($user->email, 'test111@example.com');
    }

    /**
     * @test
     */
    public function deactivate()
    {
        $user = $this->userService->deactivate(1);

        $this->assertSame((string) $user->status, Status::Deactivated);
    }

    /**
     * 無効ステータスを再度無効にはできない
     *
     * @test
     */
    public function deactivate_fail()
    {
        $this->deactivate();

        $this->expectException(ModelNotFoundException::class);

        $this->deactivate();
    }

    /**
     * @test
     */
    public function activate()
    {
        $this->deactivate();

        $user = $this->userService->activate(1);

        $this->assertSame((string) $user->status, Status::Activated);
    }

    /**
     * 有効ステータスを再度有効にはできない
     *
     * @test
     */
    public function activate_fail()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->userService->activate(1);
    }
}
