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
    public $set_schema_table = 'grupos_familiares';

    /**
     * Run the migrations.
     * @table grupos_familiares
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('numero_id');
            $table->integer('user_id')->unsigned();
            $table->string('documento_identidad')->nullable()->default(null);
            $table->integer('codigo_departamento_expedicion')->nullable()->default(null)->unsigned();
            $table->integer('codigo_ciudad_expedicion')->nullable()->default(null)->unsigned();
            $table->string('nombres')->nullable()->default(null);
            $table->string('primer_apellido')->nullable()->default(null);
            $table->string('segundo_apellido')->nullable()->default(null);
            $table->integer('escolaridad_id')->nullable()->default(null)->unsigned();
            $table->integer('parentesco_id')->nullable()->default(null)->unsigned();
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->integer('codigo_departamento_nacimiento')->nullable()->default(null)->unsigned();
            $table->integer('codigo_ciudad_nacimiento')->nullable()->default(null)->unsigned();
            $table->integer('profesion_id')->nullable()->default(null);
            $table->char('active', 1);
            $table->integer('codigo_pais_expedicion')->nullable()->default(null)->unsigned();
            $table->integer('codigo_pais_nacimiento')->nullable()->default(null)->unsigned();
            $table->integer('tipo_documento')->nullable()->default(null)->unsigned();
            $table->integer('genero')->nullable()->default(null)->unsigned();

           
            $table->timestamps();


            $table->foreign('codigo_ciudad_expedicion')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('genero')
                ->references('id')->on('generos')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('codigo_ciudad_nacimiento')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('codigo_departamento_expedicion')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('codigo_departamento_nacimiento')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('codigo_pais_expedicion')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('codigo_pais_nacimiento')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('escolaridad_id')
                ->references('id')->on('escolaridades')
                ->onDelete('cascade');

            $table->foreign('parentesco_id')
                ->references('id')->on('parentescos')
                ->onDelete('cascade');

            $table->foreign('tipo_documento')
                ->references('id')->on('tipos_documentos')
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
