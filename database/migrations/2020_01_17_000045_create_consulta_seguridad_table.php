<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultaSeguridadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'consulta_seguridad';

    /**
     * Run the migrations.
     * @table consulta_seguridad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->default(null);
            $table->unsignedInteger('user_gestion')->nullable()->default(null);
            $table->unsignedInteger('req_id')->nullable()->default(null);
            $table->unsignedInteger('cliente_id')->nullable()->default(null);
            $table->integer('factor_seguridad')->nullable()->default(null);
            $table->integer('contador')->nullable()->default(null);
            $table->string('pdf_consulta_file', 100)->nullable()->default(null);
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
