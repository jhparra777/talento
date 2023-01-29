<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaReclutadoresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'carga_reclutadores';

    /**
     * Run the migrations.
     * @table carga_reclutadores
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('cedula')->nullable()->default(null);
            $table->string('nombre', 100)->nullable()->default(null);
            $table->string('apellidos', 200)->nullable()->default(null);
            $table->double('celular')->nullable()->default(null);
            $table->double('tel_fijo')->nullable()->default(null);
            $table->integer('reclutador_id')->nullable()->default(null)->unsigned();
            $table->integer('lote')->nullable()->default(null);
            $table->string('gestionado', 20)->nullable()->default(null);

            $table->index(["reclutador_id"], 'reclutador_id');
            $table->timestamps();


            $table->foreign('reclutador_id')
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
