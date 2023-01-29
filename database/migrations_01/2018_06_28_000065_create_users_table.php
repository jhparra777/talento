<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('remember_token')->nullable()->default(null);
            $table->string('hash_verificacion')->nullable()->default(null);
            $table->string('username')->nullable()->default(null);
            $table->double('numero_id')->nullable()->default(null);
            $table->string('facebook_key')->nullable()->default(null);
            $table->string('google_key')->nullable()->default(null);
            $table->string('foto_perfil')->nullable()->default(null);
            $table->integer('estado')->nullable()->default(null);
            $table->integer('padre_id')->nullable()->default(null);
            $table->longText('permissions')->nullable()->default(null);
            $table->dateTime('last_login')->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->integer('notificacion_requisicion')->nullable()->default(null);
            $table->string('nickname')->nullable()->default(null);
            $table->string('cedula')->nullable()->default(null);
            $table->string('correo_corporativo')->nullable()->default(null);
            $table->string('telefono')->nullable()->default(null);
            $table->integer('unidad_trabajo')->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->string('video_perfil')->nullable()->default(null);

          
            $table->timestamps();


            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
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
