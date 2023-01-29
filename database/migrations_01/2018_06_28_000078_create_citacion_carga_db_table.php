<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitacionCargaDbTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'citacion_carga_db';

    /**
     * Run the migrations.
     * @table citacion_carga_db
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('lote')->nullable()->default(null);
            $table->integer('user_carga')->unsigned();
            $table->double('identificacion');
            $table->string('nombres', 100)->nullable()->default(null);
            $table->string('primer_apellido', 100)->nullable()->default(null);
            $table->string('segundo_apellido', 100)->nullable()->default(null);
            $table->double('telefono_fijo')->nullable()->default(null);
            $table->double('telefono_movil')->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('estado', 20)->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->integer('motivo')->nullable()->default(null)->unsigned();
            $table->integer('remitido_call')->nullable()->default(null);

        
            $table->timestamps();


            $table->foreign('user_carga', 'user_carga')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('motivo', 'motivo')
                ->references('id')->on('motivo_recepcion')
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
