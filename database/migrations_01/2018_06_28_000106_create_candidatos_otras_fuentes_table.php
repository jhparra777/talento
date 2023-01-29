<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosOtrasFuentesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'candidatos_otras_fuentes';

    /**
     * Run the migrations.
     * @table candidatos_otras_fuentes
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('nombres', 45)->nullable()->default(null);
            $table->increments('id');
            $table->integer('cedula')->nullable()->default(null);
            $table->integer('telefono')->nullable()->default(null);
            $table->integer('celular')->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->integer('tipo_fuente_id')->nullable()->default(null)->unsigned();
            $table->integer('requerimiento_id')->nullable()->default(null)->unsigned();

          
            $table->timestamps();


            $table->foreign('requerimiento_id')
                ->references('id')->on('requerimientos')

                ->onDelete('cascade');

            $table->foreign('tipo_fuente_id')
                ->references('id')->on('tipo_fuente')
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
