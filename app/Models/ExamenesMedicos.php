<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenesMedicos extends Model
{
    //
      protected $table    = 'examenes_medicos';
    protected $fillable = ["orden_id",'examen'];



   public function orden(){
   		return $this->belongsTo('App\Models\OrdenMedica', 'id');
   }
}
