<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function(Blueprint $table)
        {
           $table->engine = 'InnoDB';

           $table->increments('id');
           $table->integer('user_id')->unsigned();
           $table->float('height');
           $table->float('width');
           $table->float('depth');
           $table->float('weight');
           $table->string('startaddress');
           $table->string('endaddress');
           $table->text('contents');
           $table->timestamps();

           $table->foreign('user_id')
                 ->references('id')
                 ->on('users')
                 ->onDelete('cascade');


        });
        DB::statement('ALTER TABLE parcels ADD COLUMN startpoint POINT NOT NULL');
        DB::statement('ALTER TABLE parcels ADD COLUMN endpoint POINT NOT NULL');
        DB::statement('CREATE SPATIAL INDEX sx_start ON parcels(startpoint)');
        DB::statement('CREATE SPATIAL INDEX sx_end ON parcels(endpoint)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('parcels');
    }
}
