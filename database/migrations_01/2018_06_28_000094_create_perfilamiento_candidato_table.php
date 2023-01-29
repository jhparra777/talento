<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilamientoCandidatoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'perfilamiento_candidato';

    /**
     * Run the migrations.
     * @table perfilamiento_candidato
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('reclutador_id')->nullable()->default(null)->unsigned();
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->string('tipo', 40)->nullable()->default(null);
            $table->string('tabla', 50)->nullable()->default(null);
            $table->integer('tabla_id')->nullable()->default(null);

           
            $table->timestamps();


            $table->foreign('reclutador_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
               

            $table->foreign('candidato_id')
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
