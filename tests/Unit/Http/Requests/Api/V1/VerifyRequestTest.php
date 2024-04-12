<?php

namespace Tests\Unit\Http\Requests\Api\V1;

use App\Enums\User\Status;
use App\Http\Requests\Api\V1\VerifyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class VerifyRequestTest extends TestCase
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
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'aaa',
            'verification_code' => 'bbb',
            'status' => Status::Pending,
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
        $rules = (new VerifyRequest())->rules();
        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    /**
     * @return array
     */
    public function validationProvider(): array
    {
        return [
            [
                true,
                [
                    'verification_code' => 'bbb',
                ],
            ],
            [
                false,
                [
                    'verification_code' => 'ccc',
                ],
            ],
        ];
    }
}
