<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKiosksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosks', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('admin_id');
	        $table->string('name', 50);
	        $table->longText('info');
	        $table->float('longitude', 9, 6);
	        $table->float('latitude', 9, 6);
	        $table->string('picture');
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
        Schema::dropIfExists('kiosks');
    }
}
