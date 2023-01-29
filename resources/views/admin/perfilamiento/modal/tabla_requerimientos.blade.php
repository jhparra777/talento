<div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="background: #fff">
                        <thead>
                            <tr>
                                <td></td>
                                <td># Req</td>
                                <td>Cliente</td>
                                <td>Ciudad</td>
                                <td>Cargo</td>
                                <td>Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requerimientos as $req)
                            <tr>
                                <td>{!! Form::checkbox("req[]",$req->id,null,["class"=>"seleccionar_requerimiento"]) !!}</td>
                                <td>{{$req->id}}</td>
                                <td>{{$req->empresa()->nombre}}</td>
                                <td>{{$req->getUbicacion()->ciudad}}</td>
                                <td>{{$req->cargo()->descripcion}}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->id])}}">
                                        <span class="fa fa-file-pdf-o"></span>Ficha
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $requerimientos->render() !!}