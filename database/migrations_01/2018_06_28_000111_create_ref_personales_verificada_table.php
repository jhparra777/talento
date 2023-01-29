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
    public $set_schema_table = 'ref_personales_verificada';

    /**
     * Run the migrations.
     * @table ref_personales_verificada
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->integer('usuario_gestion')->nullable()->default(null)->unsigned();
            $table->string('encuestado', 100)->nullable()->default(null);
            $table->string('dificultades', 100)->nullable()->default(null);
            $table->string('cualidades', 100)->nullable()->default(null);
            $table->string('desacuerdo', 100)->nullable()->default(null);
            $table->string('debe_mejorar', 100)->nullable()->default(null);
            $table->string('relaciones_interpersonales', 100)->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->integer('ref_verificada')->nullable()->default(null);
            $table->integer('referencia_personal_id')->nullable()->default(null)->unsigned();

            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

               ->onDelete('cascade');

            $table->foreign('referencia_personal_id')
                ->references('id')->on('referencias_personales')
               ->onDelete('cascade');

           

            $table->foreign('usuario_gestion')
                ->references('id')->on('users')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
