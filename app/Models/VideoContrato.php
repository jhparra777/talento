<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoContrato extends Model
{
    //
   protected $table    = 'video_firma_contrato';
   protected $fillable = ['id_firma_contrato','archivo_video'];
}
