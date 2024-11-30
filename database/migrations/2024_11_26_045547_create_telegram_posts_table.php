<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('message_id');
            $table->string('column');
            $table->text('value');
            $table->unsignedBigInteger('telegram_user_id'); 
            $table->foreign('telegram_user_id')->references('id')->on('telegram_users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_posts');
    }
};
