<?php

use Illuminate\Database\Seeder;

class TipoFuenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipo_fuente')->insert([
            "id"          => "1",
            "descripcion" => "TRABAJECONNOSOTROS.COM",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",

        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "2",
            "descripcion" => "RECOMENDADOS POR TRABAJADORES",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "3",
            "descripcion" => "AGENCIAS TEMPORALES DE EMPLEO",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "4",
            "descripcion" => "BOLSA DE EMPLEO DE INSTITUCIONES EDUCATIVAS",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "5",
            "descripcion" => "AVISOS DE PRENSA",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "6",
            "descripcion" => "ENVIADOS POR EL CLIENTE",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "7",
            "descripcion" => "ELEMPLEO.COM",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "8",
            "descripcion" => "ENVIADOS Y/O REFERENCIADOS POR CLIENTE",
            "created_at"  => "2016-04-06 23:30:11",
            "updated_at"  => "2016-04-06 23:30:11",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "9",
            "descripcion" => "COMPUTRABAJO.COM",
            "created_at"  => "2016-04-06 23:30:42",
            "updated_at"  => "2016-04-06 23:30:42",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "10",
            "descripcion" => "LINKED IN",
            "created_at"  => "2016-04-06 23:30:49",
            "updated_at"  => "2016-04-06 23:30:49",
        ]);

        DB::table('tipo_fuente')->insert([
            "id"          => "11",
            "descripcion" => "OTRAS",
            "created_at"  => "2016-04-06 23:31:06",
            "updated_at"  => "2016-04-06 23:31:06",
        ]);

    }
}
