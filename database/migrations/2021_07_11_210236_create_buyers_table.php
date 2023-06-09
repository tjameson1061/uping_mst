<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('buyers')) {
            Schema::create('buyers', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->default(1);
                $table->integer('company_id')->nullable();
                $table->char('name')->unique();
                $table->char('account_contact1', 255)->nullable();
                $table->longText('avatar')->nullable();
                $table->char('account_contact2', 255)->nullable();
                $table->char('buyer_type', 255)->nullable();
                $table->char('fcaLicense', 255)->nullable();
                $table->char('icoLicense', 255)->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

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
        Schema::dropIfExists('buyers');
    }
}
