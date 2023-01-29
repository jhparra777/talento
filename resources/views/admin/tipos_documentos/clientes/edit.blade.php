@extends("admin.layout.master")
@section('contenedor')

    <style>
        .dropdown-menu{
            left: -80px;
            padding: 0;
        }

        .form-control-feedback{
            display: none !important;
        }

        .smk-error-msg{
            position: unset !important;
            float: right;
            margin-right: 14px !important;
        }

        .text-center {
            text-align: center;
        }
    </style>

     @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Editar tipo documento cliente"])

    

    <div class="clearfix"></div>

    <div class="row">
    

   
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-body">
                {!! Form::model(Request::all(), ["route" => "admin.gestion_documental.clientes.tipos_documentos.update", "method" => "POST","data-smk-icon" => "glyphicon glyphicon-remove","id"=>"fr_edit_tipo"]) !!}
               
                 {!! Form::hidden('tipo_id',$registro->id)!!}
                <div class="col-md-8 col-md-offset-2 form-group">
                    <label for="inputEmail3" class="control-label">Descripción:</label>

                            
                    {!! Form::text("descripcion",$registro->descripcion,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","required"=>true ]); !!}
                            
                </div>

                {{--<div class="col-md-8 col-md-offset-2 form-group">
                    <label for="inputEmail3" class="control-label">Categoría:</label>

                            
                    {!! Form::select("categoria_id[]",$categorias,null,["class"=>"selectpicker form-control","multiple"=>true,"data-actions-box"=>true ]); !!}
                            
                </div>--}}

                <div class="col-md-8 col-md-offset-2 form-group">
                    <label for="inputEmail3" class="control-label">Estado:</label>

                            
                    {!! Form::select("active",[1=>"Activo",0=>"Inactivo"], $registro->active,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","required"=>true ]); !!}
                            
                </div>

                <div class="col-md-12 text-right">
                    <button 
                        type="submit"
                        class="btn btn-default | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                        id="guardar">
                        Guardar
                    </button>
                </div>
            </div>
            
        </div>
    </div>

        <div class="clearfix"></div>
        
        
    
        
    {!! Form::close() !!}
    <br>
    <br>
       

       
    </div>

    <br>

    <div class="clearfix"></div>

    

    <div class="clearfix"></div>

    <div class="col-sm-12 text-right">
        <button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" onclick="window.history.back();" title="Volver">Volver</button>
    </div>


    <script>
        $(function(){
            $("#guardar").click(function(){
                if ($('#fr_edit_tipo').smkValidate()) {
                    $('#fr_edit_tipo').submit();
                }
                else{
                    return false;
                }

            })
            
        });
    </script>
   


    
@stop