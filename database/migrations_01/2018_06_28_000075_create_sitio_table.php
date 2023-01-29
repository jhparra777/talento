<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitioTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'sitio';

    /**
     * Run the migrations.
     * @table sitio
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 50);
            $table->double('celular');
            $table->integer('telefono');
            $table->string('email', 50);
            $table->string('logo', 50);
            $table->string('favicon', 50);
            $table->string('web_corporativa');
            $table->string('quienes_somos');
            $table->string('vision');
            $table->string('mision');
            $table->string('social_facebook');
            $table->string('social_twitter');
            $table->string('social_youtube');
            $table->double('social_whatsapp');
            $table->integer('user_id_creo');
            $table->string('color', 100);
            $table->string('social_linkedin');
            $table->string('social_instagram');
            $table->string('audio');

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
