@extends("home.layout.master")
@section('content')
<section id="counter">
      <div class="container">
        <div class="row">
          
          <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Preguntas del requerimiento {{ $req_id }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="http://190.146.237.133:8080/soluciones-inmediatas/public">
                                <i class="ti-home"></i> Inicioss
                            </a>
                        </li>
                        <li class="current">Preguntas del requerimiento {{ $req_id }}</li>
                    </ol>
                </div>
            </div>
         
        </div>
      </div>
    </section>
@stop