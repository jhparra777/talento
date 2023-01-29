<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertasUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ofertas_users';

    /**
     * Run the migrations.
     * @table ofertas_users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('requerimiento_id');
            $table->date('fecha_aplicacion')->nullable()->default(null);
            $table->integer('cedula')->nullable()->default(null);
            $table->tinyInteger('estado')->default('1');
            $table->tinyInteger('referer')->nullable()->default(null);

            $table->index(["user_id", "requerimiento_id", "cedula", "estado"], 'user_id');

            $table->unique(["id"], 'id');
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
