<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->default(0);
            $table->bigInteger('componentable_id');
            $table->string('componentable_type');
            $table->string('name');
            $table->enum('type', [ 'LIGHT', 'FAN' ])->default('LIGHT');
            $table->enum('state', [ 'OFF', 'ON' ])->default('OFF');
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
        Schema::dropIfExists('components');
    }
}
