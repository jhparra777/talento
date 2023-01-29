<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosBasicosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'datos_basicos';

    /**
     * Run the migrations.
     * @table datos_basicos
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
            $table->string('nombres');
            $table->tinyInteger('datos_basicos_activo')->nullable()->default(null);
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable()->default(null);
            $table->string('telefono_fijo')->nullable()->default(null);
            $table->string('telefono_movil')->nullable()->default(null);
            $table->integer('ciudad_expedicion_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_expedicion_id')->nullable()->default(null)->unsigned();
            $table->date('fecha_expedicion')->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->integer('pais_nacimiento')->nullable()->default(null)->unsigned();
            $table->integer('departamento_nacimiento')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_nacimiento')->nullable()->default(null)->unsigned();
            $table->integer('genero')->nullable()->default(null)->unsigned();
            $table->integer('estado_civil')->nullable()->default(null);
            $table->integer('aspiracion_salarial')->nullable()->default(null)->unsigned();
            $table->integer('departamento_residencia')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_residencia')->nullable()->default(null)->unsigned();
            $table->string('direccion')->nullable()->default(null);
            $table->string('direccion_formato')->nullable()->default(null);
            $table->string('numero_libreta')->nullable()->default(null);
            $table->integer('clase_libreta')->nullable()->default(null);
            $table->string('distrito_militar')->nullable()->default(null);
            $table->char('tiene_vehiculo', 10)->nullable()->default(null);
            $table->integer('tipo_vehiculo')->nullable()->default(null)->unsigned();
            $table->string('numero_licencia')->nullable()->default(null);
            $table->integer('categoria_licencia')->nullable()->default(null)->unsigned();
            $table->integer('entidad_eps')->nullable()->default(null)->unsigned();
            $table->integer('entidad_afp')->nullable()->default(null)->unsigned();
            $table->integer('acepto_politicas_privacidad')->nullable()->default(null);
            $table->integer('fuente_publicidad')->nullable()->default(null);
            $table->integer('datos_basicos_count')->nullable()->default(null);
            $table->integer('perfilamiento_count')->nullable()->default(null);
            $table->integer('experiencias_count')->nullable()->default(null);
            $table->integer('estudios_count')->nullable()->default(null);
            $table->integer('referencias_count')->nullable()->default(null);
            $table->integer('grupo_familiar_count')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('pais_residencia')->nullable()->default(null)->unsigned();
            $table->integer('tipo_id')->nullable()->default(null)->unsigned();
            $table->string('email');
            $table->string('empresa_registro')->nullable()->default(null);
            $table->string('barrio')->nullable()->default(null);
            $table->string('contacto_externo')->nullable()->default(null);
            $table->integer('estado_reclutamiento')->nullable()->default(null);
            $table->string('rh', 20)->nullable()->default(null);
            $table->string('grupo_sanguineo', 20)->nullable()->default(null);
            $table->integer('situacion_militar_definida')->nullable()->default(null);
            $table->string('cargo_desempenado')->nullable()->default(null);
            $table->integer('motivo_rechazo')->nullable()->default(null)->unsigned();
            $table->string('descrip_profesional')->nullable()->default(null);
            $table->tinyInteger('asistencia');
            

          
            $table->timestamps();


            $table->foreign('entidad_eps')
                ->references('id')->on('entidades_eps')

                ->onDelete('cascade');

            $table->foreign('entidad_afp')
                ->references('id')->on('entidades_afp')
                ->onDelete('cascade');

             $table->foreign('tipo_id')
                ->references('id')->on('tipo_identificacion')
                ->onDelete('cascade');





            $table->foreign('ciudad_expedicion_id')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('categoria_licencia')
                ->references('id')->on('categorias_licencias')
                ->onDelete('cascade');

            $table->foreign('tipo_vehiculo')
                ->references('id')->on('tipos_vehiculos')
                ->onDelete('cascade');

            $table->foreign('departamento_expedicion_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('aspiracion_salarial')
                ->references('id')->on('aspiracion_salarial')
                ->onDelete('cascade');

            

            $table->foreign('pais_residencia')
                ->references('id')->on('paises')

                ->onDelete('cascade');

            $table->foreign('genero')
                ->references('id')->on('generos')
                ->onDelete('cascade');

            $table->foreign('pais_nacimiento')
                ->references('id')->on('paises')
                ->onDelete('cascade');

           

            $table->foreign('user_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('ciudad_nacimiento')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('ciudad_residencia')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('departamento_nacimiento')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('departamento_residencia')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('motivo_rechazo')
                ->references('id')->on('motivos_rechazos')
                ->onDelete('cascade');

            $table->foreign('pais_id')
                ->references('id')->on('paises')
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
