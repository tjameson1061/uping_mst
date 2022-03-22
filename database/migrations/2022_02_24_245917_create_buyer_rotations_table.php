<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerRotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_rotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_setup_id');
            $table->integer('buyer_index')->nullable();
            $table->integer('buyer_used_count')->nullable();
            $table->integer('buyer_total_count')->nullable();
            $table->integer('tier_id')->nullable();
            $table->integer('status');
            $table->timestamps();

            $table->foreign('buyer_setup_id')->references('id')->on('buyer_setups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_rotations');
    }
}
