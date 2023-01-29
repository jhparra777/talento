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
    public $set_schema_table = 'referencias_personales';

    /**
     * Run the migrations.
     * @table referencias_personales
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
            $table->string('primer_apellido')->nullable()->default(null);
            $table->string('segundo_apellido')->nullable()->default(null);
            $table->integer('tipo_relacion_id')->unsigned();
            $table->string('telefono_movil')->nullable()->default(null);
            $table->string('telefono_fijo')->nullable()->default(null);
            $table->integer('codigo_departamento')->nullable()->default(null)->unsigned();
            $table->integer('codigo_ciudad')->nullable()->default(null)->unsigned();
            $table->string('ocupacion')->nullable()->default(null);
            $table->char('active', 1);
            $table->integer('codigo_pais')->nullable()->default(null)->unsigned();

           
            $table->timestamps();


            $table->foreign('codigo_ciudad')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('codigo_departamento')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('codigo_pais')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('tipo_relacion_id')
                ->references('id')->on('tipo_relaciones')
                ->onDelete('cascade');

            $table->foreign('user_id')
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
