<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYrlRealtyTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('yrl_realty_types')) {
            return;
        }
        Schema::create('yrl_realty_types', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('display_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realty_wall_types');
    }
}
