<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenMedicaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'orden_medica';

    /**
     * Run the migrations.
     * @table orden_medica
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('req_can_id');
            $table->integer('proveedor_id');
            $table->integer('resultado')->nullable()->default(null);
            $table->text('observacion')->nullable()->default(null);
            $table->string('documento', 100)->nullable()->default(null);
            $table->integer('user_envio')->nullable()->default(null);
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
