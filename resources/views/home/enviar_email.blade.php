@extends("home.layout.master")
<!--extends("cv.layouts.master_default")-->
@section('content')

<div class="page-header" style="background: url({{url('assets/img/banner1.jpg')}});">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="breadcrumb-wrapper">
<h2 class="product-title">Enviar email</h2>
<ol class="breadcrumb">
<li><a href="{{ route('home') }}"><i class="ti-home"></i> Inicio</a></li>
<li style="color: #ed8402;">Enviar Email</li>
</ol>
</div>
</div>
</div>
</div>
</div>
<section class="find-job section">
    <div class="container">
        <div class=" center-block"> 
            <div class="col-md-6 col-md-offset-3 fr_login">
                <h1 class="color">Comparte la oferta por email</h1>
                {!! Form::open(['route' => ['enviar_email2',$requerimientos->id],'id'=>'formenvio']) !!}
                   {!! Form::hidden('req_id',$requerimientos->id,null) !!}


                @if (route("home") != "http://komatsu.t3rsc.co" && route("home") != "https://komatsu.t3rsc.co")

                 <div class="form-group">
                    {!! Form::text('nombre',null,['class'=>'form-control','id'=>'email','placeholder'=>'Escribe tu nombre']) !!}
                 </div>

                 <div class="form-group">
                    {!! Form::text('nombre_destino',null,['class'=>'form-control','id'=>'email','placeholder'=>'Escribe el nombre de la persona a la que le vas a compartir la oferta']) !!}
                 </div>
               
                <div class="form-group">
                  {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Escribe el correo del destinatario']) !!}
                </div>

                @else
                
                <div class="form-group">
                   {!! Form::text('nombre','El Equipo de Reclutamiento y Selección de Komatsu',['class'=>'form-control','id'=>'email','placeholder'=>'Escribe tu nombre','readonly']) !!}
                </div>

                <div class="form-group">
                  {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'example@email.com,example2@email.com']) !!}
                </div>

                @endif


                <div class="btn-container-aligned">
                    <button id="enviar" type="submit" class="btn btn-common btn-rm">Enviar <i class="fa fa-arrow-circle-o-right"></i></button>
                </div>
                 <div class="btn-container-aligned">
                    <br>
                    <a href="{{route("home.detalle_oferta",["id"=>$requerimientos->id])}}" class="btn-t3 btn btn-danger col-md-12">Regresar</a>    
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
<script>
    $(function(){

        $('#enviar').click(function(){
           
           $(this).prop('disabled','disabled');

           $('#formenvio').submit();
        })
    });
</script>
@stop()