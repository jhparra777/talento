<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenciasPersonalesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'referencias_personales';

    /**
     * Run the migrations.
     * @table referencias_personales
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
            $table->string('primer_apellido')->nullable()->default(null);
            $table->string('segundo_apellido')->nullable()->default(null);
            $table->integer('tipo_relacion_id');
            $table->string('telefono_movil')->nullable()->default(null);
            $table->string('telefono_fijo')->nullable()->default(null);
            $table->integer('codigo_departamento')->nullable()->default(null);
            $table->integer('codigo_ciudad')->nullable()->default(null);
            $table->string('ocupacion')->nullable()->default(null);
            $table->char('active', 1);
            $table->string('codigo_pais')->nullable()->default(null);

            $table->index(["numero_id"], 'numero_id');

            $table->index(["tipo_relacion_id"], 'ref_person_tipo_relac_id_fk');

            $table->index(["user_id"], 'ref_person_user_id_fk');
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
