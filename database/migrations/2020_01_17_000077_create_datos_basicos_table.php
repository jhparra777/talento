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
    public $tableName = 'datos_basicos';

    /**
     * Run the migrations.
     * @table datos_basicos
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
            $table->string('nombres');
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable()->default(null);
            $table->string('telefono_fijo')->nullable()->default(null);
            $table->string('telefono_movil')->nullable()->default(null);
            $table->integer('ciudad_expedicion_id')->nullable()->default(null);
            $table->integer('departamento_expedicion_id')->nullable()->default(null);
            $table->date('fecha_expedicion')->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->integer('pais_nacimiento')->nullable()->default(null);
            $table->integer('departamento_nacimiento')->nullable()->default(null);
            $table->integer('ciudad_nacimiento')->nullable()->default(null);
            $table->string('genero', 20)->nullable()->default(null);
            $table->integer('estado_civil')->nullable()->default(null);
            $table->integer('aspiracion_salarial')->nullable()->default(null);
            $table->integer('departamento_residencia')->nullable()->default(null);
            $table->integer('ciudad_residencia')->nullable()->default(null);
            $table->string('direccion')->nullable()->default(null);
            $table->string('direccion_formato')->nullable()->default(null);
            $table->string('numero_libreta')->nullable()->default(null);
            $table->integer('clase_libreta')->nullable()->default(null);
            $table->string('distrito_militar')->nullable()->default(null);
            $table->char('tiene_vehiculo', 10)->nullable()->default(null);
            $table->integer('tipo_vehiculo')->nullable()->default(null);
            $table->string('numero_licencia')->nullable()->default(null);
            $table->integer('categoria_licencia')->nullable()->default(null);
            $table->integer('entidad_eps')->nullable()->default(null);
            $table->integer('entidad_afp')->nullable()->default(null);
            /*info de politica de privacidad*/
            $table->integer('acepto_politicas_privacidad')->nullable()->default(null);
            $table->integer('politicas_privacidad_id')->nullable()->default(null);
            $table->date('fecha_acepto_politica')->nullable()->default(null);
            $table->time('hora_acepto_politica')->nullable()->default(null);
            $table->string('ip_acepto_politica', 100)->nullable()->default(null);
            /* fin info politica privacidad */
            $table->integer('fuente_publicidad')->nullable()->default(null);
            $table->integer('datos_basicos_count')->nullable()->default(null);
            $table->integer('perfilamiento_count')->nullable()->default(null);
            $table->integer('experiencias_count')->nullable()->default(null);
            $table->integer('estudios_count')->nullable()->default(null);
            $table->integer('referencias_count')->nullable()->default(null);
            $table->integer('grupo_familiar_count')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('pais_residencia')->nullable()->default(null);
            $table->integer('tipo_id')->nullable()->default(null);
            $table->string('email');
            $table->string('empresa_registro')->nullable()->default(null);
            $table->string('barrio')->nullable()->default(null);
            $table->string('contacto_externo')->nullable()->default(null);
            $table->integer('estado_reclutamiento')->nullable()->default(null);
            $table->string('rh', 20)->nullable()->default(null);
            $table->string('grupo_sanguineo', 20)->nullable()->default(null);
            $table->integer('situacion_militar_definida')->nullable()->default(null);
            $table->string('cargo_desempenado')->nullable()->default(null);
            $table->integer('motivo_rechazo')->nullable()->default(null);
            $table->string('descrip_profesional')->nullable()->default(null);
            $table->tinyInteger('datos_basicos_activo')->default('1');
            $table->string('talla_camisa', 100)->nullable()->default(null);
            $table->string('talla_pantalon', 100)->nullable()->default(null);
            $table->string('talla_zapatos', 100)->nullable()->default(null);
            $table->tinyInteger('asistencia')->default('0');
            $table->integer('nivel_estudio_id')->nullable()->default(null);
            $table->tinyInteger('trabaja')->nullable()->default(null);
            $table->text('descripcion_conflicto')->nullable()->default(null);
            $table->integer('usuario_cargo')->nullable()->default(null);
            $table->integer('fondo_cesantias')->nullable()->default(null);
            $table->integer('caja_compensaciones')->nullable()->default(null);
            $table->integer('nombre_banco')->nullable()->default(null);
            $table->string('tipo_cuenta', 250)->nullable()->default(null);
            $table->string('numero_cuenta', 250)->nullable()->default(null);

            $table->index(["ciudad_residencia"], 'ciudad_residencia');

            $table->index(["user_id"], 'user_id');

            $table->index(["created_at"], 'created_at');

            $table->index(["pais_residencia"], 'pais_residencia');

            $table->index(["descrip_profesional"], 'idx_datos_basicos_descrip_profesional');

            $table->index(["genero"], 'idx_datos_basicos_genero');

            $table->index(["departamento_residencia"], 'departamento_residencia');

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
