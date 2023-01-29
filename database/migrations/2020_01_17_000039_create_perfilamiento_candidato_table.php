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
    public $tableName = 'perfilamiento_candidato';

    /**
     * Run the migrations.
     * @table perfilamiento_candidato
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->nullable()->default(null);
            $table->integer('reclutador_id')->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null);
            $table->string('tipo', 40)->nullable()->default(null);
            $table->string('tabla', 50)->nullable()->default(null);
            $table->integer('tabla_id')->nullable()->default(null);
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
