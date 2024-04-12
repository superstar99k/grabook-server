<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table
              ->string('name', 64)
              ->nullable(false)
              ->comment('氏名');
            $table->enum('role', \App\Enums\Role\Type::getValues())->nullable(false)->default(\App\Enums\Role\Type::User)->comment('権限');
            $table->string('postal_code', 8)->nullable(false)->comment('郵便番号');
            $table->string('address', 128)->nullable(false)->comment('住所');
            $table->string('tel', 16)->nullable(true)->comment('電話番号');
            $table
              ->string('email', 64)
              ->nullable(false)
              ->comment('メールアドレス');
            $table
               ->string('password', 128)
              ->nullable(true)
              ->comment('パスワード');
            $table
              ->string('verification_code', 255)
              ->nullable(false)
              ->comment('承認コード');
            $table->dateTime('verification_generated_at')->nullable(true);
            $table->dateTime('email_verified_at')->nullable(true)->comment('承認日時');
            $table
              ->enum('status', \App\Enums\User\Status::getValues())
              ->nullable(false)
              ->default(\App\Enums\User\Status::Pending)
              ->comment('ステータス');

            $table->timestamps();
            $table->softDeletes('deleted_at', 0);

            $table->unique('email');

            $table->comment('ユーザーマスタ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
