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
        Schema::create('crawlers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('url');
            $table->integer('status');
            $table->string('path')->nullable();
            $table->timestamps();
            $table->index(['name', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawlers');
    }
};
