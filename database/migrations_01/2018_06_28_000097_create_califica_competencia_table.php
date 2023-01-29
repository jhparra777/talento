<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificaCompetenciaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'califica_competencia';

    /**
     * Run the migrations.
     * @table califica_competencia
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('entidad_id')->nullable()->default(null)->unsigned();
            $table->integer('competencia_entrevista_id')->nullable()->default(null)->unsigned();
            $table->string('valor', 100)->nullable()->default(null);
            $table->string('descripcion', 250)->nullable()->default(null);
            $table->string('tipo_entidad', 45)->nullable()->default(null);

        
            $table->timestamps();


            $table->foreign('competencia_entrevista_id')
                ->references('id')->on('califica_competencia')

                ->onDelete('cascade');

            $table->foreign('entidad_id')
                ->references('id')->on('entrevista_semi')
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
