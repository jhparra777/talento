<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Gestionar Facturación</h4>
</div>
<div class="modal-body">
    {!! Form::model($facturacion,["class"=>"form-horizontal", "role"=>"form", "id"=>"fr_facturacion"]) !!}
        {!! Form::hidden("req_id",$req_id) !!}
        {!! Form::hidden("facturacion_id", $facturacion_id) !!}
        
        <div class="col-md-6 form-group">
		    <label for="factura_entrega_terna" class="col-sm-12">Factura entrega terna:</label>
		    <div class="col-sm-12">
		    	{!! Form::select("factura_entrega_terna",[""=>"Seleccione",1=>"Si",0=>"No"],null,["class"=>"form-control","id"=>"factura_entrega_terna" ]); !!}
		    </div>
		</div>

		<div class="col-md-6 form-group">
		    <label for="recaudo_centrega_terna" class="col-sm-12">Recaudo entrega terna:</label>
		    <div class="col-sm-12">
		    	{!! Form::select("recaudo_centrega_terna",[""=>"Seleccione",1=>"Si",0=>"No"],null,["class"=>"form-control","id"=>"recaudo_centrega_terna" ]); !!}
		    </div>
		</div>

		<div class="col-md-6 form-group">
		    <label for="factura_cierre_proceso" class="col-sm-12">Factura cierre proceso:</label>
		    <div class="col-sm-12">
		    	{!! Form::select("factura_cierre_proceso",[""=>"Seleccione",1=>"Si",0=>"No"],null,["class"=>"form-control","id"=>"factura_cierre_proceso" ]); !!}
		    </div>
		</div>

		<div class="col-md-6 form-group">
		    <label for="recaudo_cierre_proceso" class="col-sm-12">Recaudo cierre proceso:</label>
		    <div class="col-sm-12">
		    	{!! Form::select("recaudo_cierre_proceso",[""=>"Seleccione",1=>"Si",0=>"No"],null,["class"=>"form-control","id"=>"recaudo_cierre_proceso" ]); !!}
		    </div>
		</div>

		<div class="col-md-12 form-group">
		    <label for="observaciones" class="col-sm-12">Observaciones:</label>
		    <div class="col-sm-12">
		    	{!! Form::textarea("observaciones",null,["class"=>"form-control","id"=>"observaciones" ]); !!}
		    </div>
		</div>

    {!! Form::close() !!}
   
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if($facturacion_id > 0)
    	<button type="button" class="btn btn-success" id="actualizar_factura_requerimiento">Actualizar</button>
    @else
    	<button type="button" class="btn btn-success" id="guardar_factura_requerimiento">Guardar</button>
    @endif
</div>