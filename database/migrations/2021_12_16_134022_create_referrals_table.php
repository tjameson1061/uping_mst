<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('referrals')) {

            Schema::create('referrals', function (Blueprint $table) {
                $table->id();
                $table->string('vendor_id');
                $table->string('referrer_id');
                $table->string('geo');
                $table->float('commission');
                $table->float('affiliate_price');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referrals');
    }
}
