<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealtyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('realty_types')) {
            return;
        }
        Schema::create('realty_types', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('uk_title')->nullable();
            $table->integer('parent_id')
                ->unsigned()
                ->nullable();

            $table->integer('alternative_id')
                ->unsigned()
                ->nullable();

            $table->integer('yrl_realty_type_id')
                ->unsigned()
                ->nullable();

            $table->foreign('yrl_realty_type_id')
                ->references('id')->on('yrl_realty_types');

        });

        Schema::table('realty_types', function (Blueprint $table) {
            $table->foreign('alternative_id')
                ->references('id')->on('realty_types');

            $table->foreign('parent_id')
                ->references('id')->on('realty_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realty_types');
    }
}
