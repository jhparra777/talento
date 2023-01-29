<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosVerificadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'documentos_verificados';

    /**
     * Run the migrations.
     * @table documentos_verificados
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipo_documento_id')->nullable()->default(null);
            $table->string('nombre_archivo', 100)->nullable()->default(null);
            $table->string('descripcion_archivo', 100)->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->string('gestion_hv', 45)->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null);
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
