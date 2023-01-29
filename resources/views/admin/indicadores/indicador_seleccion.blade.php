@extends("admin.layout.master")
@section('contenedor')
{{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "<i class='fa fa-line-chart' aria-hidden='true'></i>  Indicador selección"])
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                    <div class="box box-info collapsed-box | tri-bt-purple tri-br-1">
                        <div class="box-header with-border">
                            <h2 class="box-title | tri-fs-16">
                                Información sobre el indicador 
                                
                            </h2>

                            <div class="box-tools pull-right">
                                <button 
                                    type="button"
                                    class="btn btn-box-tool" 
                                    data-widget="collapse" 

                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-container="body"
                                    title="Despliega para ver explicación sobre el indicador">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Ver más
                                </button>
                            </div>
                        </div>
                         <div class="box-body">
                            <div class="chart">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        
                                        <p>En este indicador se obtendrá la cantidad de vacantes solicitadas y candidatos en proceso de contratación en los requerimientos creados en un rango de fechas seleccionado. Se obtendrá el acumulado de los mismos datos de los requerimientos creados en 1 año anterior al actual, para obtener la cantidad de vacantes vencidas a la fecha.</p>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
            </div>
        </div>
    </div>
<hr/>
<br>
<br>
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicador_seleccion","method"=>"GET","accept-charset"=>"UTF-8","id"=>"fr-seleccion"]) !!}
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="col-md-6">
                <label for="inputEmail3" class="control-label">Fecha requerimiento:</label>
                <div class="form-group">
                    
                    {!! Form::text("fecha_rango",null,["class"=>"range form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Rango creación requerimiento","id"=>"fecha_inicio","autocomplete"=>"off","required"=>true]); !!}
                </div>
            </div>

            <div class="col-sm-6" style="margin-top: 1.8em;">
                <div class="form-group">
                     <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="generar">
                         Generar <i aria-hidden="true" class="fa fa-search"></i>
                     </button>
                        <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route("admin.reporte.indicador_seleccion")}}">Limpiar</a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<hr>
<div class="clear-fix"></div>
    <div class="text-center" id="boxPreloader" style="display:none;">
        <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
    </div>
    <div class="container-fluid" id="search-results">

        
    </div>





    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
        <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
        {!! Form::close() !!}
    </br>
    


<script type="text/javascript">
   $(function(){

        $('#generar').click(function(){
            if($('#fr-seleccion').smkValidate()) {
             $.ajax({
                    type: "POST",
                    data: $("#fr-seleccion").serialize(),
                    url: "{{ route('admin.reporte.indicador_seleccion.search') }}",
                    beforeSend:function(){
                        $('#boxPreloader').show();

                    },
                    success: function (response) {
                        if(response.success) {
                            setTimeout(() => {
                            $('#boxPreloader').hide();
                            $("#search-results").html(response.view);
                            let labels=response.labels.pie;
                            let colors=response.colors.pie;
                            let data=response.data.pie;
                            generatePieChart(labels,colors,data);
                            labels=response.labels.bar;
                            colors=response.colors.bar;
                            data=JSON.parse(response.data.bar);
                            generateBarChart(labels,colors,data);
                            }, 500)
                            
                            
                        }else {
                            mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                        }
                    }
                })

                }//validate
        });
   });
</script>

<script src="{{ asset('js/admin/chart-scripts/pie-chart.js') }}"></script>
<script src="{{ asset('js/admin/chart-scripts/bar-chart.js') }}"></script>

@stop