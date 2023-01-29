<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposFamiliaresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'grupos_familiares';

    /**
     * Run the migrations.
     * @table grupos_familiares
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('numero_id');
            $table->integer('user_id');
            $table->string('documento_identidad')->nullable()->default(null);
            $table->integer('codigo_departamento_expedicion')->nullable()->default(null);
            $table->integer('codigo_ciudad_expedicion')->nullable()->default(null);
            $table->string('nombres')->nullable()->default(null);
            $table->string('primer_apellido')->nullable()->default(null);
            $table->string('segundo_apellido')->nullable()->default(null);
            $table->integer('escolaridad_id')->nullable()->default(null);
            $table->integer('parentesco_id')->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->integer('codigo_departamento_nacimiento')->nullable()->default(null);
            $table->integer('codigo_ciudad_nacimiento')->nullable()->default(null);
            $table->string('profesion_id')->nullable()->default(null);
            $table->char('active', 1);
            $table->integer('codigo_pais_expedicion')->nullable()->default(null);
            $table->string('codigo_pais_nacimiento')->nullable()->default(null);
            $table->integer('tipo_documento')->nullable()->default(null);
            $table->integer('genero')->nullable()->default(null);

            $table->index(["user_id"], 'grupos_familiares_user_id_fk');

            $table->index(["numero_id"], 'numero_id');
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
