<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'documentos';

    /**
     * Run the migrations.
     * @table documentos
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
            $table->integer('tipo_documento_id')->nullable()->default(null);
            $table->string('nombre_archivo', 100)->nullable()->default(null);
            $table->longText('descripcion_archivo')->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->char('active', 1);
            $table->integer('gestiono')->nullable()->default(null);
            $table->integer('requerimiento')->nullable()->default(null);

            $table->index(["user_id"], 'documentos_user_id_foreign');
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
