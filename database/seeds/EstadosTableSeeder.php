<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('estados')->insert([
            "id"          => "1",
            "descripcion" => "CANCELADO POR CLIENTE",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "2",
            "descripcion" => "CANCELADO POR SOLUCIONES",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-14 02:24:20",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "3",
            "descripcion" => "CERRADO POR CUMPLIMIENTO PARCIAL",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "4",
            "descripcion" => "PROBLEMAS DE SEGURIDAD",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "5",
            "descripcion" => "ACTIVO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "6",
            "descripcion" => "RECLUTAMIENTO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "7",
            "descripcion" => "EN PROCESO SELECCION",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "8",
            "descripcion" => "EVALUACION DEL CLIENTE",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "9",
            "descripcion" => "EVALUACI\u00d3N DE SEGURIDAD",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "10",
            "descripcion" => "SEGURIDAD",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "11",
            "descripcion" => "EN PROCESO CONTRATACION",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "12",
            "descripcion" => "CONTRATADO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "13",
            "descripcion" => "INACTIVO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "14",
            "descripcion" => "QUITAR",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "15",
            "descripcion" => "APROBADO POR CLIENTE",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "16",
            "descripcion" => "TERMINADO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "17",
            "descripcion" => "ELIMINADO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "18",
            "descripcion" => "VENTA PERDIDA",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "19",
            "descripcion" => "CERRADO POR CUMPLIMIENTO PARCIAL",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "20",
            "descripcion" => "PENDIENTE DE APROBACI\u00d3N",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

        DB::table('estados')->insert([
            "id"          => "21",
            "descripcion" => "NO APROBADO",
            "tipo"        => "C",
            "cod_estado"  => "", "observaciones" => "", "created_at" => "2018-03-04 04:13:19",
            "updated_at"  => "2018-03-04 04:13:19",
        ]);

    }
}
