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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('company', 60)->nullable(false)->comment('会社名');
            $table->string('name', 30)->nullable(false)->comment('名前');
            $table->string('email', 128)->nullable(false)->comment('メールアドレス');
            $table->longText('message')->nullable(true)->comment('問合せ内容');

            $table->timestamps();

            $table->comment('お問合せ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
