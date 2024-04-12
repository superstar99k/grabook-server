<?php

namespace Tests\Unit\Http\Requests\Api\V1\User;

use App\Enums\User\Status;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreRequestTest extends TestCase
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
        $rules = (new StoreRequest())->rules();
        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    /**
     * @return array<array<bool,array<string,string>>>
     */
    public function validationProvider(): array
    {
        return [
            [
                true,
                [
                    'name' => 'test',
                    'email' => 'test2@example.com',
                ],
            ],
            [
                false,
                [
                    'name' => 'test',
                    'email' => 'test1@example.com',
                ],
            ],
            [
                false,
                [
                    'name' => '',
                    'email' => '',
                ],
            ],
            [
                false,
                [
                    'name' => 'test',
                    'email' => '',
                ],
            ],
            [
                false,
                [
                    'name' => '',
                    'email' => 'test2@example.com',
                ],
            ],
        ];
    }
}
