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
        Schema::create('premium_members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable(false)->comment('ユーザーID');
            $table->string('subscription_id', 127)->nullable(false)->comment('Subscription ID');
            $table->date('expiry_date')->nullable(false)->comment('有効期限');

            $table->timestamps();
            $table->softDeletes('deleted_at', 0);

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');

            $table->comment('有料会員マスタ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premium_members');
    }
};
