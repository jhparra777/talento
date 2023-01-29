<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRequerimientosEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE  VIEW `requerimientos_estados`  AS  select (select `xx`.`estado` from `estados_requerimiento` `xx` where ((`xx`.`id` = (select max(`ss`.`id`) from `estados_requerimiento` `ss` where (`ss`.`req_id` = `a`.`req_id`))) and (`xx`.`created_at` = (select max(`ll`.`created_at`) from `estados_requerimiento` `ll` where (`ll`.`req_id` = `a`.`req_id`)))) group by `a`.`req_id` order by `a`.`id` desc) AS `max_estado`,`a`.`req_id` AS `req_id`,`b`.`created_at` AS `fecha_creacion_req`,max(`a`.`created_at`) AS `fecha_ultimo_estado`,`c`.`cliente_id` AS `cliente_id` from (((`estados_requerimiento` `a` join `requerimientos` `b` on((`a`.`req_id` = `b`.`id`))) join `negocio` `c` on((`b`.`negocio_id` = `c`.`id`))) join `estados` `d` on((`a`.`estado` = `d`.`id`))) group by `a`.`req_id` ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       DB::statement("DROP VIEW requerimientos_estados");
    }
}
