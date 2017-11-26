<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->increments('id_produit');
            $table->unsignedInteger('id_categorie');
            $table->unsignedInteger('id_producteur');
            $table->string('intitule', 100);
            $table->text('description');
            $table->decimal('prix', 27);

            $table->foreign('id_categorie')->references('id_categorie')->on('categories')->onDelete('cascade');
            $table->foreign('id_producteur')->references('id_producteur')->on('producteurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}
