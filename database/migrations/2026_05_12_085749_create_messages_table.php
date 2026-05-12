<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('social_account_id')->constrained()->onDelete('cascade');
        $table->string('sender_name');
        $table->string('sender_id');
        $table->text('content');
        $table->enum('type', ['comment', 'dm']);
        $table->string('post_id')->nullable();
        $table->boolean('is_read')->default(false);
        $table->timestamp('replied_at')->nullable();
        $table->timestamp('created_at')->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
