<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegocioAnsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'negocio_ans';

    /**
     * Run the migrations.
     * @table negocio_ans
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vacantes_inicio')->nullable()->default(null);
            $table->integer('negocio_id')->nullable()->default(null);
            $table->integer('cantidad_dias')->nullable()->default(null);
            $table->char('regla', 10)->default('');
            $table->integer('num_cand_presentar_vac')->default('0');
            $table->integer('departamento')->default('0');
            $table->integer('ciudad')->default('0');
            $table->integer('dias_presentar_candidatos_antes')->default('0');
            $table->integer('cargo_especifico_id')->nullable()->default(null);
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
