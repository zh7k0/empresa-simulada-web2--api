<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebEmpresaSimuladaDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_feria', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('razon_social', 200)->unique();
            $table->string('descripcion', 200)->nullable();
            $table->string('url_stream', 200)->nullable();
            $table->string('url_logo', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->string('youtube', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('categoria', 100);
        });

        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tipo_evento', 50)->default('feria');
            $table->dateTime('fecha_realizacion');
            $table->string('categorias', 100);
            $table->boolean('esta_habilitado')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_feria');
        Schema::dropIfExists('eventos');
    }
}
