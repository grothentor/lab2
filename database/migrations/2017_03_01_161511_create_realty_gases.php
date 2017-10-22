<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealtyGases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('realty_gases')) {
            return;
        }
        Schema::create('realty_gases', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('uk_title')->nullable();
            $table->integer('parent_id')
                ->unsigned()
                ->nullable();
        });

        Schema::table('realty_gases', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')->on('realty_gases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realty_gases');
    }
}
