<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaSemiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'entrevista_semi';

    /**
     * Run the migrations.
     * @table entrevista_semi
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
            $table->integer('user_gestion_id')->nullable()->default(null)->unsigned();
            $table->string('estado_salud')->nullable()->default(null);
            $table->string('especificaciones_cargo')->nullable()->default(null);
            $table->string('apto', 45)->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default('1');

           
            $table->Timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('user_gestion_id')
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
