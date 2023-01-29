<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Carnet Candidato</title>
    </head>

    <style>

        body{
          font-family: Verdana, arial, sans-serif;
          font-size: 8px;
        }

        @page { margin: 30px 40px; }

        .page-break {
          page-break-after: always;
        }


        .titulo{
          background-color: #333131;
          padding: 10px 0px;
          color: #FFFFFF;
          text-align: center;
          font-size: 16px;
        }

        .tabla1 tr th{
            background-color: #fdf099;
            font-weight: bold;
            padding: 5px 10px;
            text-align: left;
            width: 180px;
            font-size: 14px;
        }

        .tabla2 tr th{
            background-color: #fdf099;
            font-weight: bold;
            padding: 5px 10px;
            text-align: left;
            font-size: 8px;
        }

        .tabla1 tr td{
          padding: 5px 10px;
          font-size: 8px;
          width: 100%;
        }

        .tabla2 tr td{
          padding: 5px 10px;
          font-size: 8px;
        }

        .col-center{
          float: none;
          margin-left: auto;
          margin-right: auto;
        }

        .logo_derecha{      
          position: absolute;
          right: 0;
        }

    </style>

    <body>

      @if(isset($req->empresa_contrata))
      <!-- los carnet segun la empresa -->
        @if($empresa->id == 4)
         <!-- carnet de nodos -->

          <?php $fondo = "background-image: url('".url('carnet_candidatos.jpg')."');"; ?>

                <div style="position: relative; margin:0;">
                  <img alt="Logo T3RS" class="" src="{{url('carnet_nodos.jpg')}}" style="position: absolute;width:100%;height:290px;">
                    
                   <div style="postion:absolute;width:56%;z-index:1;">

                   <div class="datos_candidato" style="font-size:11px;padding:3px;word-wrap: break-word;top:100px;height:auto; width:38%; position: relative;z-index:3; float:left;margin-left:100px; font-weight:500;">
                     <span style="z-index:5;line-height: 2.3;">
                      <p> {{ucwords(mb_strtolower($candidato->nombres))}}<br>
                      {{ucwords(mb_strtolower($candidato->primer_apellido)).' '.ucwords(mb_strtolower($candidato->segundo_apellido))}} <br>
                      {{$candidato->numero_id}}</p>
                      <li style="list-style: none; margin-top: -16px;">
                      {{ucwords(mb_strtolower($req->cargo_req()))}}<br>
                      {{ucwords(mb_strtolower($req->nombre_cliente))}}</li>
                     </span>
                   </div>

                    <div class="datos_candidato" style="float:right;word-wrap: break-word;top:156px;height:auto; width:30%; position: relative;z-index:2; margin-right:32px;">

                     <span> 
                        @if($candidato->foto_perfil != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('recursos_datosbasicos/'.$candidato->foto_perfil)}}" />
                        @elseif($candidato->avatar != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ $candidato->avatar }}" />
                        @else
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
                        @endif
                     </span> 
                    </div>

                 </div>
              </div>

          @elseif($empresa->id == 3)

              <div style="position: relative; margin:0;">
                  <img alt="Logo T3RS" class="" src="{{url('carnet_tercerizar.jpg')}}" style="position: absolute;width:100%;height:290px;">
                    
                  <div style="postion:absolute;width:56%;z-index:1;">

                    <div class="datos_candidato" style="float:left;word-wrap: break-word;top:110px;height:auto; width:30%; position: relative;z-index:2; margin-left:0px;">

                     <span> 
                        @if($candidato->foto_perfil != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('recursos_datosbasicos/'.$candidato->foto_perfil)}}" />
                        @elseif($candidato->avatar != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ $candidato->avatar }}" />
                        @else
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
                        @endif
                     </span>

                    </div>

                   <div class="datos_candidato" style="font-size:11px;padding:3px;word-wrap: break-word;top:53px;height:auto; width:38%; position: relative;z-index:3; float:right;margin-right:30px; font-weight:500;">

                     <span style="z-index:5;line-height: 2.5;">
                      <p> {{ucwords(mb_strtolower($candidato->nombres))}}<br>
                      {{ucwords(mb_strtolower($candidato->primer_apellido)).' '.ucwords(mb_strtolower($candidato->segundo_apellido))}} <br>
                      {{$candidato->numero_id}}</p>
                      <li style="list-style: none; margin-top: -20px;">
                      {{ucwords(mb_strtolower($req->cargo_req()))}}<br>
                      {{ucwords(mb_strtolower($req->nombre_cliente))}}</li>
                     </span>
                   </div>

                 </div>
              </div>

          @elseif($empresa->id == 2)

           <div style="position: relative; margin:0; color: #FFFFFF !important;">
            <img alt="Logo T3RS" class="" src="{{url('carnet_vym.jpg')}}" style="position: absolute;width:100%;height:290px;">
                    
                   <div style="postion:absolute;width:56%;z-index:1;">

                   <div class="datos_candidato" style="font-size:11px;padding:3px;word-wrap: break-word;top:38px;height:auto; width:38%; position: relative;z-index:3; float:left;margin-left:50px; font-weight:500;">
                     <span style="z-index:5;line-height: 2.3;">
                      <p> {{ucwords(mb_strtolower($candidato->nombres))}}<br>
                      {{ucwords(mb_strtolower($candidato->primer_apellido)).' '.ucwords(mb_strtolower($candidato->segundo_apellido))}} <br>
                      {{$candidato->numero_id}}</p>
                      <li style="list-style: none; margin-top: -15px;">
                      {{ucwords(mb_strtolower($req->cargo_req()))}}<br>
                      {{ucwords(mb_strtolower($req->nombre_cliente))}}</li>
                     </span>
                   </div>

                    <div class="datos_candidato" style="float:right;word-wrap: break-word;top:156px;height:auto; width:30%; position: relative;z-index:2; margin-right:32px;">

                     <span> 
                        @if($candidato->foto_perfil != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('recursos_datosbasicos/'.$candidato->foto_perfil)}}" />
                        @elseif($candidato->avatar != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ $candidato->avatar }}" />
                        @else
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
                        @endif
                     </span> 
                    </div>

                 </div>
              </div>

            @else

            <div style="position: relative; margin:0;">
             <img alt="Logo T3RS" class="" src="{{url('carnet_listos.jpg')}}" style="position: absolute;width:100%;height:290px;">
                    
                  <div style="postion:absolute;width:56%;z-index:1;">

                    <div class="datos_candidato" style="float:left;word-wrap: break-word;top:156px;height:auto; width:30%; position: relative;z-index:2; margin-left:30px;">

                     <span> 
                        @if($candidato->foto_perfil != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('recursos_datosbasicos/'.$candidato->foto_perfil)}}" />
                        @elseif($candidato->avatar != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ $candidato->avatar }}" />
                        @else
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
                        @endif
                     </span>

                    </div>

                   <div class="datos_candidato" style="font-size:11px;padding:2px;word-wrap: break-word;top:80px;height:auto; width:38%; position: relative;z-index:3; float:right;margin-right:40px; font-weight:500;">

                     <span style="z-index:5;line-height: 2.5;">
                      <p> {{ucwords(mb_strtolower($candidato->nombres))}}<br>
                      {{ucwords(mb_strtolower($candidato->primer_apellido)).' '.ucwords(mb_strtolower($candidato->segundo_apellido))}} <br>
                      {{$candidato->numero_id}}</p>
                      <li style="list-style: none; margin-top: -20px;">
                      {{ucwords(mb_strtolower($req->cargo_req()))}}<br>
                      {{ucwords(mb_strtolower($req->nombre_cliente))}}</li>
                     </span>
                   </div>

                 </div>
              </div>

          @endif
    
      @else

       <?php $fondo = "background-image: url('".url('carnet_candidatos.jpg')."');"; ?>

            <div style="position: relative; margin:0;">
             <img alt="Logo T3RS" class="" src="{{url('carnet_listos.jpg')}}" style="position: absolute;width:100%;height:290px;">
                    
                  <div style="postion:absolute;width:56%;z-index:1;">

                    <div class="datos_candidato" style="float:left;word-wrap: break-word;top:156px;height:auto; width:30%; position: relative;z-index:2; margin-left:30px;">

                     <span> 
                        @if($candidato->foto_perfil != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('recursos_datosbasicos/'.$candidato->foto_perfil)}}" />
                        @elseif($candidato->avatar != "")
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ $candidato->avatar }}" />
                        @else
                         <img style="width:90%;height:140px;" alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
                        @endif
                     </span>

                    </div>

                   <div class="datos_candidato" style="font-size:11px;padding:2px;word-wrap: break-word;top:80px;height:auto; width:38%; position: relative;z-index:3; float:right;margin-right:40px; font-weight:500;">

                     <span style="z-index:5;line-height: 2.5;">
                      <p> {{ucwords(mb_strtolower($candidato->nombres))}}<br>
                      {{ucwords(mb_strtolower($candidato->primer_apellido)).' '.ucwords(mb_strtolower($candidato->segundo_apellido))}} <br>
                      {{$candidato->numero_id}}</p>
                      <li style="list-style: none; margin-top: -20px;">
                      {{ucwords(mb_strtolower($req->cargo_req()))}}<br>
                      {{ucwords(mb_strtolower($req->nombre_cliente))}}</li>
                     </span>
                   </div>

                 </div>
              </div>
    @endif
  </body>
</html>