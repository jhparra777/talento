<div class="row" id="container_postulados">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapsePostulados" aria-expanded="true" aria-controls="collapsePostulados">
                        POSTULAR CANDIDATOS(opcional)
                    </a>

                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapsePostulados" aria-expanded="true" aria-controls="collapsePostulados">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>

            <div id="collapsePostulados" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body" id="postulados">
                    <div class="row candidato-postulado">
                        <div class="col-md-2">
                            <div class="form-group">
                                @if (route('home') == 'https://gpc.t3rsc.co')
                                    <label>CI: <span class='text-danger sm-text-label'>*</span></label>
                                @else
                                    <label>Cédula: <span class='text-danger sm-text-label'>*</span></label>
                                @endif
                    
                                <input type="text" class="form-control form_cam can_cedula solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="Cédula" name="can_cedula[]">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nombres: <span class='text-danger sm-text-label'>*</span></label>
                                <input type="text" class="form-control form_cam can_nombres postular-cand | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="Nombres" name="can_nombres[]" readonly="true">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Apellidos: <span class='text-danger sm-text-label'>*</span></label>
                                <input type="text" class="form-control form_cam can_apellido postular-cand | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="Apellidos" name="can_apellido[]" readonly="true">
                            </div>
                        </div>
                        
                        @if (route('home') == 'https://gpc.t3rsc.co')
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Hora Ingreso </label>
                                
                                    <input type="time" min="09:00" max="18:00" name="hora_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="hora_ingreso">
                                </div>
                            </div>
                        @endif

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Móvil: <span class='text-danger sm-text-label'>*</span></label>
                                <input type="text" class="form-control form_cam can_movil solo-numero postular-cand | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="Móvil" name="can_movil[]" readonly="true">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Correo electrónico: <span class='text-danger sm-text-label'>*</span></label>
                                <input type="email" class="form-control form_cam can_email email postular-cand | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="email@dominio.com" name="can_email[]" readonly="true">
                            </div>
                        </div>

                        @if (route('home') == 'https://gpc.t3rsc.co')
                            <div class="col-md-2">
                                <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Lugar y Persona de Contacto</label>
                                
                                    <textarea name="lugar_contacto" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" rows="2"></textarea>
                                </div>
                            </div>
                        @endif

                        @if (route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://localhost:8000')
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha fin ultimo contrato  </label>
                                
                                    <input type="date" name="hora_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="fecha_ultimo_contrato">
                                </div>
                            </div>
                        @endif

                        <div class="col-md-2 form-group last-child">
                            <button type="button" class="btn btn-success add-person mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar">+</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>