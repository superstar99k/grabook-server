<?php

namespace Tests\Feature\Http\Controller\Api\V1\Admin;

use App\Enums\User\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        User::insert([
            'id' => 1,
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => 'aaa',
            'verification_code' => 'aaa',
            'status' => Status::Activated,
        ]);

        User::insert([
            'id' => 2,
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => 'bbb',
            'verification_code' => 'aaa',
            'status' => Status::Deactivated,
        ]);
    }

    /**
     * @param int $count
     * @param array $params<string,mixed>
     *
     * @test
     *
     * @dataProvider indexProvider
     */
    public function index(int $count, array $params)
    {
        $response = $this->actingAs(User::find(1))
            ->get(route('admin.users.index', $params));

        $response->assertOk();
        $response->assertJsonCount($count, 'data');
    }

    /**
     * @test
     *
     * @param int $id
     */
    public function detail()
    {
        $response = $this->actingAs(User::find(1))
            ->get(route('admin.users.detail', [
                'id' => 1,
            ]));

        $response->assertOk();
    }

    /**
     * @return array<array<int,array<string>>>
     */
    public function indexProvider(): array
    {
        return [
            [
                1,
                [
                ],
            ],
            [
                1,
                [
                    'in_deactivate' => null,
                ],
            ],
            // 無効状態のアカウントも出力
            [
                2,
                [
                    'in_deactivate' => 1,
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function store()
    {
        $response = $this->actingAs(User::find(1))
            ->postJson(route('admin.users.store', [
                'name' => 'test3',
                'email' => 'test3@example.com',
            ]));

        $response->assertCreated();
    }

    /**
     * @test
     *
     * @dataProvider updateProvider
     */
    public function update(array $params)
    {
        $response = $this->actingAs(User::find(1))
            ->patchJson(route('admin.users.update', $params));

        $response->assertOk();
    }

    /**
     * @return array
     */
    public function updateProvider(): array
    {
        return [
            [
                [
                    'id' => 1,
                    'name' => 'testaaa',
                ],
            ],
            [
                [
                    'id' => 1,
                    'email' => 'testaaa@example.com',
                ],
            ],
            [
                [
                    'id' => 1,
                    'name' => 'testbbb',
                    'email' => 'testbbb@example.com',
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function deactivate()
    {
        $response = $this->actingAs(User::find(1))
            ->patch(route('admin.users.deactivate', [
                'id' => 1,
            ]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function activate()
    {
        $response = $this->actingAs(User::find(1))
            ->patch(route('admin.users.activate', [
                'id' => 2,
            ]));

        $response->assertOk();
    }
}
