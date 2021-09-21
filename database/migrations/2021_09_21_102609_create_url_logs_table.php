<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы лога заходов
 */
class CreateUrlLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('url_logs', function(Blueprint $table) {
            $table->id();
            $table->datetime('created_at');
            $table->string('url', 2048);
            $table->string('urlhash', 32);
            $table->index(['urlhash', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('url_logs');
    }
}
