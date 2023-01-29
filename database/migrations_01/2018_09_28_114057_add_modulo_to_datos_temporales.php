<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModuloToDatosTemporales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datos_temporales', function(Blueprint $table) {
    $table->string('modulo', 100)->nullable();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datos_temporales', function (Blueprint $table) {
        $table->dropColumn('modulo');
});
    }
}
