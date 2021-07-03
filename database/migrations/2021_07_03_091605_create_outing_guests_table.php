<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutingGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outing_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outing_id')->onDelete('CASCADE');
            $table->foreignId('user_id')->onDelete('CASCADE');
            $table->boolean('is_joining')->nullable();
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
        Schema::dropIfExists('outing_guests');
    }
}
