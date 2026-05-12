<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticsSnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('analytics_snapshots', function (Blueprint $table) {
        $table->id();
        $table->foreignId('social_account_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->integer('followers_count')->default(0);
        $table->integer('reach')->default(0);
        $table->integer('impressions')->default(0);
        $table->decimal('engagement_rate', 5, 2)->default(0);
        $table->integer('posts_count')->default(0);
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
        Schema::dropIfExists('analytics_snapshots');
    }
}
