<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenciasClienteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'competencias_cliente';

    /**
     * Run the migrations.
     * @table competencias_cliente
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('competencia_entrevista_id')->nullable()->default(null)->unsigned();
            $table->integer('cliente_id')->nullable()->default(null)->unsigned();

           
            $table->timestamps();


            $table->foreign('competencia_entrevista_id', 'competencia_entrevista_id')
                ->references('id')->on('competencias_entrevistas')

                ->onDelete('cascade');

            $table->foreign('cliente_id', 'cliente_id')
                ->references('id')->on('clientes')
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
