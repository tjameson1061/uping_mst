<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePingtreeTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pingtree_trackers', function (Blueprint $table) {
            $table->id();
            $table->char('vid')->nullable();
            $table->unsignedBigInteger('buyer_setup_id');
            $table->float('epl');
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
        Schema::dropIfExists('pingtree_trackers');
    }
}
