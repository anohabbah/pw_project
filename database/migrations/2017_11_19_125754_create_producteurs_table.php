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
            $table->string('nom', 100);
            $table->string('adresse', 100);
            $table->boolean('adresse_visible')->default(false);
            $table->string('telephone', 25);
            $table->string('email', 100)->unique();
            $table->string('mot_de_passe');
            $table->text('bio');
            $table->boolean('actif')->default(false);
            $table->float('longitude', 10)->nullable();
            $table->float('latitude', 10)->nullable();
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
