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
    public $set_schema_table = 'negocio_ans';

    /**
     * Run the migrations.
     * @table negocio_ans
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vacantes_inicio')->nullable()->default(null);
            $table->integer('negocio_id')->nullable()->default(null)->unsigned();
            $table->integer('cantidad_dias')->nullable()->default(null);
            $table->char('regla', 10)->default('');
            $table->integer('num_cand_presentar_vac')->default('0');
            $table->integer('departamento')->default(null)->unsigned();
            $table->integer('ciudad')->default(null)->unsigned();
            $table->integer('dias_presentar_candidatos_antes')->default('0');

           
            $table->timestamps();


            $table->foreign('negocio_id')
                ->references('id')->on('negocio')

                ->onDelete('cascade');

            $table->foreign('ciudad')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('departamento')
                ->references('id')->on('departamentos')
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
