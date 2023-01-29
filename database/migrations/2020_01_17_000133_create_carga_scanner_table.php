<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaScannerTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'carga_scanner';

    /**
     * Run the migrations.
     * @table carga_scanner
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('user_carga')->nullable()->default(null);
            $table->double('identificacion')->nullable()->default(null);
            $table->string('primer_nombre', 50)->nullable()->default(null);
            $table->string('segundo_nombre', 45)->nullable()->default(null);
            $table->string('primer_apellido', 45)->nullable()->default(null);
            $table->string('segundo_apellido', 45)->nullable()->default(null);
            $table->string('genero', 45)->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->string('rh', 5)->nullable()->default(null);
            $table->integer('user_gestion')->nullable()->default(null);
            $table->tinyInteger('asistencia')->nullable()->default(null);
            $table->string('fuente_recl', 50)->nullable()->default(null);
            $table->tinyInteger('entidad_eps')->nullable()->default(null);
            $table->double('num_emergencia')->nullable()->default(null);
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
