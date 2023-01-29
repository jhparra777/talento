<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefPersonalesVerificadaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ref_personales_verificada';

    /**
     * Run the migrations.
     * @table ref_personales_verificada
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null);
            $table->integer('usuario_gestion')->nullable()->default(null);
            $table->integer('req_id')->nullable()->default(null);
            $table->string('encuestado', 100)->nullable()->default(null);
            $table->string('dificultades', 100)->nullable()->default(null);
            $table->string('cualidades', 100)->nullable()->default(null);
            $table->string('desacuerdo', 100)->nullable()->default(null);
            $table->string('debe_mejorar', 100)->nullable()->default(null);
            $table->string('relaciones_interpersonales', 100)->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->integer('ref_verificada')->nullable()->default(null);
            $table->integer('referencia_personal_id')->nullable()->default(null);
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
       Schema::dropIfExists($this->tableName);
     }
}
