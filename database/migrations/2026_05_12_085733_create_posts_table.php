<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        $table->foreignId('social_account_id')->constrained()->onDelete('cascade');
        $table->text('content');
        $table->string('media_url')->nullable();
        $table->timestamp('scheduled_at')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->enum('status', ['draft', 'scheduled', 'published', 'failed'])->default('draft');
        $table->string('platform_post_id')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
