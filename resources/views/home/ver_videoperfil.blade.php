@extends("home.layout.master")
@section('content')

<div class="container-fluyd" style="background: white;color: white;">
	<div class="col-sm-6 col-sm-offset-3" style="padding: 5em;">
		@if($user!=null && $user->video_perfil!=null)
			<video controls style="width: 100%;">
				<source src='{{ route("view_document_url", encrypt("recursos_videoperfil/|".$user->video_perfil)) }}' type="video/webm">
			</video>
		@else
			<h1> ¡ Video no disponible !</h1>
		@endif
	</div>
</div>

@stop
