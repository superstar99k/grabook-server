<?php

namespace Tests\Feature\Http\Controller\Api\V1;

use App\Enums\User\Status;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthControllerTest extends TestCase
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
            'verification_code' => 'abcdefghijklmnopqrstuvwxyz',
            'verification_generated_at' => CarbonImmutable::now(),
            'status' => Status::Pending,
        ]);

        User::insert([
            'id' => 2,
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => 'zzz',
            'verification_code' => 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
            'verification_generated_at' => CarbonImmutable::yesterday(),
            'status' => Status::Pending,
        ]);

        User::insert([
            'id' => 10,
            'name' => 'test10',
            'email' => 'test10@example.com',
            'verification_generated_at' => CarbonImmutable::now(),
            'verification_code' => 'jjj',
            'status' => Status::Pending,
        ]);

        User::insert([
            'id' => 11,
            'name' => 'test11',
            'email' => 'test11@example.com',
            'verification_generated_at' => CarbonImmutable::now()->subHours(config('auth.password_timeout_hour')),
            'verification_code' => 'kkk',
            'status' => Status::Pending,
        ]);
    }

    /**
     * @param array $params
     *
     * @test
     *
     * @dataProvider sendResetPasswordEmailProvider
     */
    public function send_reset_password_email(array $params)
    {
        $response = $this->postJson(route('auth.send_reset_password_email', $params));

        $response->assertOk();
    }

    /**
     * @return array
     */
    public function sendResetPasswordEmailProvider(): array
    {
        return [
            [
                [
                    'email' => 'test@example.com',
                    'email_confirmation' => 'test@example.com',
                ],
            ],
            // emailが存在しない場合でも正常終了レスポンスを返すこと
            [
                [
                    'email' => 'test1@example.com',
                    'email_confirmation' => 'test1@example.com',
                ],
            ],
        ];
    }

    /**
     * パスワードが変更されていること
     *
     * @test
     */
    public function reset_password()
    {
        $userBefore = User::whereVerificationCode('abcdefghijklmnopqrstuvwxyz')->first();

        $response = $this->withSession([
            config('session.keys.password_reset_code') => [
                'verification_code' => 'abcdefghijklmnopqrstuvwxyz',
                'user_id' => 1,
                'expired' => CarbonImmutable::now(),
            ],
        ])
        ->postJson(route('auth.resert_password', [
            'password' => 'aaabbbccc',
            'password_confirmation' => 'aaabbbccc',
            'verification_code' => 'abcdefghijklmnopqrstuvwxyz',
        ]));

        $response->assertOk();

        $userAfter = User::whereVerificationCode('abcdefghijklmnopqrstuvwxyz')->first();

        $this->assertNotSame($userBefore->password, $userAfter->password);
    }

    /**
     * 有効期限が過ぎている場合は更新されないこと
     *
     * @test
     */
    public function reset_password_expired()
    {
        $userBefore = User::whereVerificationCode('abcdefghijklmnopqrstuvwxyz')->first();

        $response = $this->withSession([
            config('session.keys.password_reset_code') => [
                'verification_code' => 'abcdefghijklmnopqrstuvwxyz',
                'user_id' => 1,
                'expired' => CarbonImmutable::now()->subHours(config('auth.password_timeout_hour')),
            ],
        ])
        ->postJson(route('auth.resert_password', [
            'password' => 'aaabbbccc',
            'password_confirmation' => 'aaabbbccc',
            'verification_code' => 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
        ]));

        $response->assertOk();

        $userAfter = User::whereVerificationCode('abcdefghijklmnopqrstuvwxyz')->first();

        $this->assertSame($userBefore->password, $userAfter->password);
    }

    /**
     * 存在しないverification_codeでも正常終了レスポンスを返すこと
     *
     * @test
     */
    public function not_exists_verification_code()
    {
        $response = $this->withSession([
            config('session.keys.password_reset_code') => [
                'verification_code' => 'aaaaaaaaaaaaaaaaaaaaaaaaa',
                'user_id' => 1,
                'expired' => CarbonImmutable::now()->subHours(config('auth.password_timeout_hour')),
            ],
        ])
        ->postJson(route('auth.resert_password', [
            'password' => 'aaabbbccc',
            'password_confirmation' => 'aaabbbccc',
            'verification_code' => 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
        ]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function verify()
    {
        $response = $this->post(route('auth.verify', [
            'verification_code' => 'jjj',
        ]));

        $response->assertOk();

        $afterUser = User::find(10);

        $this->assertSame($afterUser->status->value, Status::Activated);
    }

    /**
     * 有効期限切れの場合、ステータスは更新されない
     *
     * @test
     */
    public function verify_expired_fail()
    {
        $response = $this->post(route('auth.verify', [
            'verification_code' => 'kkk',
        ]));

        $response->assertOk();

        $afterUser = User::find(10);

        $this->assertNotSame($afterUser->status->value, Status::Activated);
    }

    /**
     * 既に有効ステータスになっている場合はそのまま
     *
     * @test
     */
    public function verify_activated_fail()
    {
        User::whereKey(10)
            ->first()
            ->fill([
                'status' => Status::Activated,
            ])
            ->save();

        $beforeUser = User::find(10);

        $this->assertSame($beforeUser->status->value, Status::Activated);

        $this->post(route('auth.verify', [
            'verification_code' => 'jjj',
        ]));

        $afterUser = User::find(10);

        $this->assertEquals(0, $beforeUser->updated_at->diffInSeconds($afterUser->updated_at));
    }
}
