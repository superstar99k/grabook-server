<?php

namespace Tests\Unit\Http\Requests\Api\V1\User;

use App\Enums\User\Status;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateRequestTest extends TestCase
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
            'verification_code' => 'bbb',
            'status' => Status::Activated,
        ]);
    }

    /**
     * @param bool $expected
     * @param array $data
     *
     * @test
     *
     * @dataProvider validationProvider
     */
    public function validation($expected, array $data)
    {
        $rules = (new UpdateRequest(['id' => 1]))->rules();
        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    /**
     * @return array<array<bool,array<int,string,string>>>
     */
    public function validationProvider(): array
    {
        return [
            [
                true,
                [
                    'id' => 1,
                    'name' => 'test3',
                    'email' => 'test3@example.com',
                ],
            ],
            [
                true,
                [
                    'id' => 1,
                    'email' => 'test3@example.com',
                ],
            ],
            [
                true,
                [
                    'id' => 1,
                    'name' => 'test3',
                ],
            ],
            // 変更前と同じ email の場合、unique の対象外
            [
                true,
                [
                    'id' => 1,
                    'name' => 'test3',
                    'email' => 'test1@example.com',
                ],
            ],
        ];
    }
}
