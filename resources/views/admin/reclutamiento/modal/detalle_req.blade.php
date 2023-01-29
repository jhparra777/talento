<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Detalle Requerimiento</h4>
</div>
<div class="modal-body">


    <table class="table table-bordered tbl_info">
        <tr>
            <th>Fecha radicación</th>
            <td>{{ $requerimiento->created_at}} </td>

            <th>Fecha terminación</th>
            <td>{{ $requerimiento->fecha_terminacion}} </td>
            <th>Dias Gestion</th>
            <td>{{ $requerimiento->dias_gestion}} </td>
        </tr>

    </table>
    <h4 class="titulo1">INFORMACIÓN SOBRE LA EMPRESA CLIENTE</h4>
    <table class="table table-bordered tbl_info">
        <tr>
            <th>Empresa cliente</th>
            <td>{{ $cliente->nombre}} </td>

            <th>Teléfono</th>
            <td>{{ $cliente->telefono}} </td>
        </tr>
        <tr>
            <th>Contacto</th>
            <td>{{ $cliente->contacto}} </td>

            <th>Cargo</th>
            <td>{{ $cliente->cargo}} </td>
            
        </tr>
        <tr>
           
            <th>E-mail</th>
            <td>{{ $cliente->correo}} </td>
        </tr>
    </table>
    <h4 class="titulo1">INFORMACIÓN PERFIL SOLICITADO</h4>
    <table class="table table-bordered tbl_info">  
        <tr>
            <th>Vacantes solicitadas</th>
            <td>{{ $requerimiento->num_vacantes}} </td>

            <th>Cargo</th>
            <td>{{ $requerimiento->nombre_cargo}} </td>
        </tr>
        <tr>
             <th>Cargo Especifico</th>
            <td>{{ $requerimiento->cargo_especifico}} </td>
            <th>Tipo Proceso</th>
            <td>{{ $requerimiento->tipo_desc}} </td>

            
        </tr>
        <tr>
            <th>Tipo Contrato</th>
            <td>{{ $requerimiento->tipo_contrato}} </td>
            <th>Tipo de experiencia</th>
            <td>{{ $requerimiento->tipo_experiencia}} </td>
        </tr>
        <tr>
            <th>Sexo</th>
            <td>{{ $requerimiento->genero_desc}} </td>
            <th>Edad Mimima</th>
            <td>{{ $requerimiento->edad_minida}} </td>
        </tr>
        <tr>
            <th>Edad Maxima</th>
            <td>{{ $requerimiento->edad_minida}} </td>
        </tr>
    </table>
    <h4 class="titulo1">TIPO DE GENERACIÓN </h4>
    <table class="table table-bordered tbl_info">

        <tr>
            <th>Motivo</th>
            <td>{{ $requerimiento->motivo_req}} </td>
        </tr>

        <tr>
            <th>Horario de trabajo</th>
            <td>{{ $requerimiento->tipo_jornadas_desc}} </td>
        </tr>

        <tr>
            <th>Salario</th>
            <td>{{ $requerimiento->salario}} </td>
        </tr>




        <tr>
            <th>Sitio de trabajo</th>
            <td> {{ $requerimiento->sitio_trabajo}} </td>
        </tr>

        <tr>
            <th>FUNCIONES: (Principales tareas y responsabilidades)</th>
            <td> {{ $requerimiento->funciones}} </td>
        </tr>


        <tr>
            <th>Formación Academia </th>
            <td>{{ $requerimiento->formacion_academica}} </td>
        </tr>

        <tr>
            <th>Experiencia laboral</th>
            <td>{{ $requerimiento->experiencia_laboral}} </td>
        </tr>

        <tr>
            <th>Conocimientos especificos</th>
            <td>{{ $requerimiento->conocimientos_especificos}} </td>
        </tr> 
        <tr><th>Pruebas especificas a cargo de la empresa usuaria.</th>
            <td>{{ (($requerimiento->pruebas_empresa==1)?"SI":"NO") }} </td></tr>

        <tr><th>¿ Cuales ?</th>
            <td> {{ $requerimiento->cuales_pruebas}} </td>
        </tr>

        <tr>
            <th>Observaciones</th>
            <td>{{ $requerimiento->observaciones}} </td>
        </tr>

        <tr>
            <th>Solicitado Por</th>
            <td>

                {{ $requerimiento->nombre_solicitado}} </td>
        </tr>

    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>