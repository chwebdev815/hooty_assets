<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journalists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('First_name',50);
            $table->string('Last_name',50);
            $table->string('email_address',100)->unique();
            $table->string('Domain_name',200);
            $table->string('Organization',100);
            $table->string('Confidence_score');
            $table->string('Type',50);
            $table->string('Sources');
            $table->string('Pattern');
            $table->string('Position');
            $table->string('Twitter_handle');
            $table->string('LinkedIn_URL');
            $table->string('Phone_number',15);
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journalists');
    }
}
