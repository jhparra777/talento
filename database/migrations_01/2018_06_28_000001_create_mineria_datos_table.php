<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMineriaDatosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'mineria_datos';

    /**
     * Run the migrations.
     * @table mineria_datos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('direccion')->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->double('cedula')->nullable()->default(null);
            $table->integer('datos_basicos_count')->nullable()->default(null);
            $table->decimal('edad', 7, 0)->nullable()->default(null);
            $table->bigInteger('experiencias')->nullable()->default(null);
            $table->bigInteger('estudios')->nullable()->default(null);
            $table->bigInteger('grupos_familiares')->nullable()->default(null);
            $table->bigInteger('referencias_personales')->nullable()->default(null);
            $table->string('ciudad')->nullable()->default(null);
            $table->text('nombre_completo')->nullable()->default(null);
            $table->string('celular')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('estado_candidato', 70)->nullable()->default(null);
            $table->string('fecha_actualizacion', 10)->nullable()->default(null);
            $table->string('cargo')->nullable()->default(null);
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
