<?php

namespace App\Jobs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auditoria;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class QueryAuditoria {

    protected $model = null;
    protected $data = [];
    protected $tabla_id = null;
    protected $tbl_auditoria = null;

    public function __construct() {
//        $this->model = $model;
//        $this->data = $data;
        $usuario = Sentinel::getUser();
        $this->tbl_auditoria = new Auditoria();
        $this->tbl_auditoria->user_id = $usuario->id;
    }

    public function delete($model, $id) {
        $this->model = $model;

        $this->tabla_id = $id;
        $this->tbl_auditoria->tabla_id = $id;
        $this->bootSaveModel();
        ///GUARDAR DATOS DEL MODELO
        DB::table($this->getNameTable())->where("id", $id)->delete();
        //GUARDAR AUDITORIA
        $this->datosDespues($model);
        $this->tbl_auditoria->tipo = "ELIMINAR REGISTRO";
        $this->guardarAuditoria();
        
    }

    public function guardar($model, $data, $id = null) {
        $this->model = $model;
        $this->data = $data;
        $this->tabla_id = $id;
        $this->tbl_auditoria->tabla_id = $id;
        $this->bootSaveModel();
        ///GUARDAR DATOS DEL MODELO
        $model->fill($data);
        $model->save();
        //GUARDAR AUDITORIA
        $this->datosDespues($model);
        $this->guardarAuditoria();
        return $model;
    }

    public function observaciones($obj) {
        $this->tbl_auditoria->observaciones = $obj;
        return $this;
    }

    public function datosAntes() {
        //BUSCAR REGISTRO EN EL MODELO SI EXISTE PARA CAPTURA INFORMACION ANTIGUA

        $info = DB::table($this->getNameTable())->where("id", $this->tabla_id)->first();

        $this->tbl_auditoria->tipo = "ACTUALIZA REGISTRO";
        if ($info == null) {
            $this->tbl_auditoria->tipo = "NUEVO REGISTRO";
        }

        $info = json_encode($info);
        $this->tbl_auditoria->valor_antes = $info;
        return $info;
    }

    public function datosDespues($model) {
        $datos = json_encode($model);

        if ($this->tbl_auditoria->tabla_id == null) {
            $this->tbl_auditoria->tabla_id = $model->id;
        }
        $this->tbl_auditoria->valor_despues = $datos;
        return $datos;
    }

    public function guardarAuditoria() {
        //dd($this->tbl_auditoria);
        $this->tbl_auditoria->save();
    }

    public function bootSaveModel() {
        $this->datosAntes();
        $this->getNameTable();
    }

    public function getNameTable() {
        $nameTable = "";

        if (isset($this->model->exists)) {
            $nameTable = with($this->model)->getTable();
        } else {
            $nameTable = with($this->model->get(0))->getTable();
        }


        $this->tbl_auditoria->tabla = $nameTable;
        return $nameTable;
    }

}
