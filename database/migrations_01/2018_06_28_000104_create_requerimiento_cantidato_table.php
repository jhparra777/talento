<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientoCantidatoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'requerimiento_cantidato';

    /**
     * Run the migrations.
     * @table requerimiento_cantidato
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('requerimiento_id')->unsigned();
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->increments('id');
            $table->string('estado_candidato', 45)->nullable()->default(null);
            $table->string('otra_fuente', 45)->nullable()->default(null);

         
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('requerimiento_id')
                ->references('id')->on('requerimientos')
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
