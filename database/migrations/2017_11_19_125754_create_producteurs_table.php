<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producteurs', function (Blueprint $table) {
            $table->increments('id_producteur');
            $table->string('adresse');
            $table->boolean('adresse_visible')->default(false);
            $table->string('nom');
            $table->string('telephone');
            $table->string('email');
            $table->string('mot_de_passe');
            $table->text('bio');
            $table->boolean('state')->default(false);
            $table->string('long', 30)->nullable();
            $table->string('lat', 30)->nullable();
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
        Schema::dropIfExists('producteurs');
    }
}
