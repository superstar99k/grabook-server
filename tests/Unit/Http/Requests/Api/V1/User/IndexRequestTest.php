<?php

namespace Tests\Unit\Http\Requests\Api\V1\User;

use App\Http\Requests\Api\V1\User\IndexRequest;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * @method void validation(bool $expected, array $data)
 */
class IndexRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
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
        $rules = (new IndexRequest())->rules();
        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    /**
     * @return array<array<bool,array<string>>>
     */
    public function validationProvider(): array
    {
        return [
            [
                true,
                [
                    'in_deactivate' => '1',
                ],
            ],
            [
                true,
                [
                    'in_deactivate' => '0',
                ],
            ],
            [
                true,
                [
                    'in_deactivate' => null,
                ],
            ],
            [
                false,
                [
                    'in_deactivate' => '111',
                ],
            ],
            [
                false,
                [
                    'in_deactivate' => 'a',
                ],
            ],
        ];
    }
}
