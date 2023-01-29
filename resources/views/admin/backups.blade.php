@extends("admin.layout.master")
@section("contenedor")
<div class="container">
    <div class="jumbotron" style="background: #f5f5f5;">
    <h3>Información:</h3>
    <p>Los backups del software reune todos los documentos genereados y cargados en la plataforma. Para descargar un archivo comprimido con dicho backup haz clic en el siguiente enlace:</p>
    <div class="text-center">
        <a class="btn btn-info" type="button" href="{{$sitio->url_backup}}" target="_blank">Descargar backup</a>
    </div>

</div>
@stop