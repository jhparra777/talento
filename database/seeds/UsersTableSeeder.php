<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name'                     => 'Miguel Alberto Cortés Kocc',
            'email'                    => 'miguelcortes9936@gmail.com',
            'estado'                   => 1,
            'pais_id'                  => 170,
            'departamento_id'          => 11,
            'ciudad_id'                => 1,
            'unidad_trabajo'           => 1,
            'notificacion_requisicion' => 1,
            'permissions'              => '{"req.usuarios":true,"req.nuevo_user":true,"req.guardar_user":true,"req.editar_user":true,"req.actualizar_usuario":true,"req.requerimiento":true,"req.consultar_negocio":true,"req.mis_requerimiento":true,"req.nuevo_requerimiento":true,"req.guardar_requerimiento":true,"req.candidatos_aprobar_cliente_view":true,"req.reporte":true,"req.mostrar_clientes":true,"req.datos.empresa":true,"req.actualizar_datos":true}',
            'numero_id'                => 1140426030,
            'password'                 => bcrypt('migue9936'),
        ]);

        DB::table('users')->insert([
            'name'                     => 'Arnulfo Andres Polo Rubiano',
            'email'                    => 'apolorubiano@gmail.com',
            'estado'                   => 1,
            'pais_id'                  => 170,
            'departamento_id'          => 11,
            'ciudad_id'                => 1,
            'unidad_trabajo'           => 1,
            'notificacion_requisicion' => 1,
            'permissions'              => '{"req.usuarios":true,"req.nuevo_user":true,"req.guardar_user":true,"req.editar_user":true,"req.actualizar_usuario":true,"req.requerimiento":true,"req.consultar_negocio":true,"req.mis_requerimiento":true,"req.nuevo_requerimiento":true,"req.guardar_requerimiento":true,"req.candidatos_aprobar_cliente_view":true,"req.reporte":true,"req.mostrar_clientes":true,"req.datos.empresa":true,"req.actualizar_datos":true}',
            'numero_id'                => 1022416948,
            'password'                 => bcrypt('pruebas'),
        ]);

        DB::table('users')->insert([
            'name'                     => 'Jorge Andres Ortiz Guzman',
            'email'                    => 'andres8585@gmail.com',
            'estado'                   => 1,
            'pais_id'                  => 170,
            'departamento_id'          => 11,
            'ciudad_id'                => 1,
            'unidad_trabajo'           => 1,
            'notificacion_requisicion' => 1,
            'permissions'              => '{"req.usuarios":true,"req.nuevo_user":true,"req.guardar_user":true,"req.editar_user":true,"req.actualizar_usuario":true,"req.requerimiento":true,"req.consultar_negocio":true,"req.mis_requerimiento":true,"req.nuevo_requerimiento":true,"req.guardar_requerimiento":true,"req.candidatos_aprobar_cliente_view":true,"req.reporte":true,"req.mostrar_clientes":true,"req.datos.empresa":true,"req.actualizar_datos":true}',
            'numero_id'                => 1022416948,
            'password'                 => bcrypt('prueba'),
        ]);
    }
}
