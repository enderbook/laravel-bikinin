<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPesanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pesan', function (Blueprint $table) {
            $table->id('id_pesan');
            $table->foreignId('id_chat');  // ID Chat Room
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');  // User yang mengirim
            $table->text('pesan');
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
        Schema::dropIfExists('tb_pesan');
    }
}
