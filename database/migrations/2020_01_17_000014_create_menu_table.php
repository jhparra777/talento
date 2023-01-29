<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'menu';

    /**
     * Run the migrations.
     * @table menu
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('modulo', 70)->nullable()->default(null);
            $table->string('tipo', 100)->nullable()->default(null);
            $table->integer('padre_id')->nullable()->default(null);
            $table->char('boton', 1)->nullable()->default(null);
            $table->string('tipo_boton', 70)->nullable()->default(null);
            $table->string('nombre_menu', 120)->nullable()->default(null);
            $table->string('descripcion', 100)->nullable()->default(null);
            $table->string('clases', 200)->nullable()->default(null);
            $table->integer('orden')->nullable()->default(null);
            $table->integer('submenu')->nullable()->default(null);
            $table->string('slug', 45)->nullable()->default(null);
            $table->string('icono', 250)->nullable()->default(null);
            $table->tinyInteger('active')->default('1');

            $table->index(["padre_id"], 'padre_id');

            $table->index(["modulo"], 'modulo');
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
