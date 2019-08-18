<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Newtables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('cx')->index();
            $table->bigInteger('rx')->index();
            $table->string('title', 100)->index();
        });

        \Illuminate\Support\Facades\DB::statement("
        INSERT INTO source SELECT NULL as id, tb_source.* FROM tb_source
        ");

        Schema::create('rel', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('cx')->index();
            $table->string('ndc', 20);

            $table->unique(['cx', 'ndc']);
        });

        \Illuminate\Support\Facades\DB::statement("
        INSERT INTO rel SELECT NULL as id, cx, ndc FROM tb_rel GROUP BY cx, ndc
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Unused
    }
}
