<footer class="site-footer footer-map">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <h2> Acerca de Nosotros</h2>
                    <hr>
                    <p class="about-lt" style="text-align:justify;">
                      ¡Atrévete a cambiar las cosas con nosotros!  Regístrate en nuestro portal y haz de tu hoja de vida una gran oportunidad.  
                      Crea tu Video perfil Laboral, puedes grabar hasta 45 segundos y contar detalles como tu experiencia y las habilidades que permiten detectar más detalles de ti como persona.  
                        {{--@if(isset($sitio->quienes_somos))
                            @if($sitio->quienes_somos != "")
                                {{ $sitio->quienes_somos }}
                            @else
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            @endif
                        @else
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        @endif--}}
                    </p>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <h2>Links de Interés</h2>
                    <hr>
                    <ul class="use-slt-link">
                        @if($sitio->web_corporativa)
                            @if($sitio->web_corporativa != "")
                                <li>
                                    <a target="_blank" href="{{ $sitio->web_corporativa }}">
                                        @if(isset($sitio->nombre))
                                            @if($sitio->nombre != "")
                                                {{ $sitio->nombre }}
                                            @else
                                                Desarrollo
                                            @endif
                                        @else
                                            Desarrollo
                                        @endif
                                    </a>
                                </li>
                            @else
                                <li><a target="_blank" href="http://desarrollo.t3rsc.co">Desarrollo</a></li>
                            @endif
                        @else
                            <li><a target="_blank" href="http://desarrollo.t3rsc.co">Desarrollo</a></li>
                        @endif
            
                        <!-- <li><a href="{{ route('empleos') }}">Mejores Empleos</a></li> -->
                        <li><a href="{{route('login')}}">Ingresar</a></li>
                        <li><a href="{{route('registrarse')}}">Registrarse</a></li>
                        <!-- <li><a href="{{$sitio->web_corporativa }}" target="_blank">Terminos y Condiciones</a></li> -->
                    </ul>
                </div>

                @if(route("home")!="https://expertos.t3rsc.co" && route("home")!="https://gpc.t3rsc.co")
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <h2>Legal</h2>
                        <hr>
                        <ul class="use-slt-link">
                            @foreach( $tipos_politicas as $tipo_politica )
                                @php
                                    $ultima_politica = $tipo_politica->politicasPrivacidad->last();
                                @endphp

                                @continue($ultima_politica == null)

                                <li>
                                    <a href="{{ route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $ultima_politica->id]) }}" target="_blank">{{ $tipo_politica->titulo_boton_footer }}</a>
                                </li>
                            @endforeach
                            <!--
                            <li id="inactivaBotonesModal"><a href="#" data-toggle="modal" data-target="#myModal">Tratamiento de datos personales</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#myModal2">Términos y condiciones</a></li>
                            -->
                            
                        </ul>
                    </div>
                @endif

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <h2>Síguenos</h2>
                    <hr>
                    <ul class="social-icons">
                        @if(isset($sitio->social_facebook))
                            @if($sitio->social_facebook !== "")
                                <li>
                                    <a href="{{ $sitio->social_facebook }}" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if(isset($sitio->social_twitter))
                            @if($sitio->social_twitter !== "")
                                <li>
                                    <a href="{{ $sitio->social_twitter }}" target="_blank" >
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if(isset($sitio->social_linkedin))
                            @if($sitio->social_linkedin !== "")
                                <li>
                                    <a href="{{ $sitio->social_linkedin }}" target="_blank">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if(isset($sitio->social_instagram))
                            @if($sitio->social_instagram !== "")
                                <li>
                                    <a href="{{ $sitio->social_instagram }}" target="_blank">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            @endif
                        @endif
                        
                        @if(isset($sitio->social_youtube))
                            @if($sitio->social_youtube !== "")
                                <li>
                                    <a href="{{ $sitio->social_youtube }}" target="_blank">
                                        <i class="fa fa-youtube-play"></i>
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if(isset($sitio->social_whatsapp))
                            @if($sitio->social_whatsapp > 1)
                                @if(route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
                                    <li>
                                        <a href="https://api.whatsapp.com/send?phone=+593993448708&text=Hola%20deseo%20ponerme%20en%20contacto%20con%20ustedes" target="_blank">
                                            <i class="fa fa-whatsapp"></i>
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="https://api.whatsapp.com/send?phone=57{{ $sitio->social_whatsapp }}&text=Hola%2C%20deseo%20adquirir%20un%20soporte%20con%20ustedes" target="_blank">
                                            <i class="fa fa-whatsapp"></i>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <p class="text-xs-center">Copyright © 2020 All Rights Reserved.Realizado Por <i class="fa fa-love" ></i><a target="_blank" href="https://t3rsc.co" style="display: inline;">T3RS</a></p>
                    
                </div>
                <div><a href="#" class="scrollup">Scroll</a></div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="color:black;z-index: 20000;">
        <div class="modal-dialog" role="document" >
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! $politica->titulo !!}</h4>
                </div>
                <div class="modal-body" style="height:400px;overflow:auto;">
                    <div id="texto" style="padding:10px;text-align:justify;margin:10px;font-family:arial;">
                    
                    {!! $politica->texto !!}
                    
                    </div>
                </div>
                <div class="modal-footer" id="botonesTratamientoDatos">
                    <button type="button" class="btn btn-danger btn-xs col-md-2 pull-right" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-xs col-md-2 pull-right" id="acepto_politica_c">Acepto</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" style="color:black;z-index: 20000;">
        <div class="modal-dialog" role="document" >
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">TÉRMINOS Y CONDICIONES</h4>
                </div>
                <div class="modal-body" style="height:400px;overflow:auto;">
                    <div id="texto" style="padding:10px;text-align:justify;margin:10px;font-family:arial;">
                    <p>Bienvenido a T3RS. Antes de que usted ingrese al sitio web (la aplicación), haga uso, o utilice cualquiera de los servicios (T3RS), es importante que usted revise cuidadosamente los Términos del Servicio (Términos). Adicionalmente, algunas páginas específicas en la aplicación pueden fijar términos y condiciones adicionales, los cuales están incorporados en los términos. Los Términos pueden ser cambiados o actualizados en cualquier momento, pero usted puede encontrar siempre la versión más reciente aquí. En el caso de inconsistencias entre estos Términos y la información incluida en otros materiales, siempre prevalecerá la información de los Términos.</p>
                    

<p>Al entrar y utilizar la aplicación usted indica que acepta los Términos y se limita a actuar de conformidad con lo allí estipulado. La aceptación de los Términos crea vínculo legal entre usted y T3RS y utilizará el servicio solamente en concordancia con los Términos. Si tiene preguntas sobre los Términos, contáctenos a soporte@t3rsc.co El uso de la aplicación y de sus diferentes servicios está condicionado por los Términos. Si usted no está de acuerdo con los Términos, no proceda a acceder la aplicación o a utilizar el servicio.</p>

<p>Términos de uso del servicio: el requerimiento en la aplicación, a la que usted accedió por haberse registrado como una Compañía Evaluadora, le permite a la Compañía Evaluadora entrevistar uno o múltiples postulantes utilizando preguntas generadas o seleccionadas por la Compañía Evaluadora. Durante la grabación de las respuestas del requerimiento en línea, el postulante registrará audio y video (el contenido) que la aplicación pondrá a disposición de la Compañía Evaluadora. El módulo de registro de candidatos y de gestión de procesos de selección en T3RS (designado uso del servicio) está solamente disponible para mayores de 18 años de edad. Adicionalmente, usted certifica que cualquier información que provea a T3RS es verdadera, exacta, vigente y completa (sea por los cuestionarios, los exámenes, las formas de registro u otros medios de requerimiento de información).</p>

<p>Conducta de la Compañía Evaluadora: El servicio está específicamente diseñado para permitir a las Compañías Evaluadoras entrevistar probables postulantes utilizando la tecnología del Internet y las preguntas proporcionadas por las Compañías Evaluadoras. Con este fin, le requerimos no utilizar este servicio para procesar, convertir, publicar, almacenar o compartir contenido digital prohibido. El contenido prohibido incluye pero no se limita a cualquiera de los siguientes tipos de contenido:</p>

<p>Video y/o audio grabado mientras que se usa T3RS que a nuestro parecer es abusivo, engañoso, pornográfico, obsceno, difamatorio, calumnioso, ofensivo o de cualquier manera inadecuado.</p>
<p>Material protegido por derechos de autor y que se utiliza sin el permiso expreso del propietario de dicho material.</p>
Contenido que viola o usurpa los derechos de otras personas.
<p>Cualquier material o archivo que contenga virus o esté infectado con Troyanos o cualquier forma de código corrupto que pueda comprometer el servicio de T3RS
Cualquier contenido que promueva actividades ilegales.</p>
<p>Cualquier contenido peligroso para menores de edad de cualquier manera.
Cualquier vínculo o conexión con los anteriores.</p>
<p>T3RS se reserva el derecho de determinar si el contenido es prohibido, y cualquier contenido puede ser sometido a revisión y/o eliminado en cualquier momento. Usted acepta que aunque T3RS no examina o examinará todo el contenido sometido, T3RS tiene el derecho absoluto (pero no la obligación) de suprimir, mover, y corregir los materiales por cualquier razón, en cualquier momento y sin previo aviso.</p>

<p>A pesar del antedicho, cuando usted ingresa a la aplicación y/o utiliza T3RS, reconoce y acepta que todo el contenido (sea privado o público) que se fija y se almacena en T3RS es la responsabilidad única de la persona que sometió el contenido. Por ningún motivo se hará responsable a T3RS o a sus funcionarios (incluyendo empleados, directivos, afiliados, agentes, asociados) por demandas de cualquier naturaleza, directas o indirectas, que tengan origen o relación con cualquier contenido que fue puesto a disposición en, o a través de T3RS, incluyendo pero no limitados a errores u omisiones en contenido, al igual que tampoco será T3RS o sus funcionarios, responsable por pérdidas o daños incurridos como resultado del uso de tal contenido.</p>

<p>Usted acepta y reconoce que T3RS, en uso de su discreción única, puede terminar el uso del servicio (en todo o en parte) y remover y/o desechar cualquier contenido, incluyendo pero no limitado a parte o totalidad del contenido, información, comunicaciones, o cualquier otro contenido dentro de T3RS, en cualquier momento, sin previo aviso, por cualquier razón, incluyendo pero no limitado a:</p>

<p>Conducta violatoria de estos Términos u otras políticas o pautas dispuestas por T3RS en cualquier lugar de la aplicación.</p>
<p>Conducta que T3RS considere dañina para otros usuarios de T3RS para el negocio de T3RS, el negocio de la Compañía Evaluadora, o para proveedores de información o terceras partes.</p>
<p>Conducta que viole los enunciados y la esencia de estos Términos. Además usted acepta que ni usted ni otra tercera persona harán responsable a T3RS por cualquier terminación de su acceso a la aplicación.</p>
<p>La aplicación y T3RS están protegidos por leyes internacionales de derechos de autor y por otras leyes aplicables. Usted acepta que cualquier uso de esta aplicación se hará solamente con el fin de responder a una invitación legítima para una entrevista de una Compañía Evaluadora. Usted acepta que no intentará ingresar a la aplicación con el propósito de descompilar información conducente a la creación de un sitio o servicio similar.</p>

<p>Autorización para utilizar el contenido: Para que podamos poner su Requerimiento a disposición del postulante, T3RS necesita los derechos para hacer uso de las preguntas del requerimiento y la información que usted nos provee cuando utiliza la aplicación (de acuerdo con y conforme a estos Términos). Por consiguiente, como condición para el uso de la aplicación, por este medio, concede usted a T3RS derechos perpetuos, universales y no exclusivos para copiar, exhibir, modificar, transmitir, distribuir y hacer trabajos subsecuentes derivados de y con cualquier contenido transmitido o proporcionado a la aplicación por usted, solamente con el propósito de entregar su Requerimiento a los legítimos postulantes, y obtener de ellos las respuestas en video en línea y entregarla posteriormente a la Compañía. Usted reconoce que tomará todas las medidas razonables para restringir la distribución del contenido, solamente a aquellas personas que tienen la legítima necesidad de revisar el contenido con el propósito de evaluar al postulante para un puesto de trabajo. Usted representa y garantiza a T3RS que usted es la persona que se registró en la aplicación.</p>

<p>Reclamo por discriminación: Usted acepta que utilizará la aplicación en una forma similar a la entrevista cara a cara, en concordancia con las políticas y buenas prácticas de gestión de Recursos Humanos y para garantizar que los postulantes no sean discriminados.<p>

<p>Remisión desautorizada de contenido: Usted conviene que no remitirá el contenido o cualquier parte del mismo excepto a las personas que tienen un legítimo interés en la contratación del postulante. Usted acepta además, que no remitirá contenido a ningún sitio público tal como YouTube, Vimeo o ningún otro sitio, a menos que sea autorizado explícitamente por la aplicación.</p>

<p>Reventa del servicio: Usted acuerda no reproducir, duplicar, copiar, vender, revender o explotar cualquier parte de la aplicación, uso de la aplicación o el acceso a la misma para cualquier propósito comercial con excepción de la creación de requerimientos, envío de requerimientos y revisión de resultados y/o prospectos a los requerimientos, con el propósito de evaluar postulantes para un trabajo o contratación.</p>

<p>Política de Privacidad: Respetamos su privacidad y hemos tomado medidas específicas para protegerla. Vea por favor nuestra Política de Privacidad.</p>

<p>Negación de la garantía: Usted acepta que el uso del servicio de T3RS es su propio riesgo. Con todo el alcance permitido por la ley, T3RS, sus funcionarios, directores, empleados, y agentes niegan todas las garantías, tácitas o implícitas, con respecto al sitio y a su uso. T3RS no ofrece ninguna garantía o representación sobre la exactitud o perfección del contenido de esta aplicación o del contenido de cualquier sitio web ligado a esta aplicación, y no asume ninguna responsabilidad por: (i) equivocaciones o errores, o inexactitudes del contenido, (ii) daños corporales o daño material, de cualquier naturaleza como resultado de su acceso a y uso de nuestra aplicación, (iii) cualquier acceso a o uso desautorizado de nuestros servidores protegidos y/o cualquier y toda la información personal y/o la información financiera almacenada en ellos, (iv) cualquier interrupción o cesación de la transmisión a o desde nuestra aplicación, (v) cualquier virus, troyanos o similares, los cuales pueden ser transmitidos a través de nuestra aplicación por un tercero, y/o (vi) cualquier error u omisión en cualquier contenido o cualquier pérdida o daño de cualquier clase ocurrida como resultado de su utilización de cualquier contenido puesto, enviado por correo electrónico, transmitido, o de otra manera hecho disponible vía la entrevista en T3RS. T3RS no autoriza, no endosa, no garantiza, ni asume la responsabilidad de cualquier producto o servicio anunciado u ofrecido por terceros a través del servicio de T3RS o ningún sitio de enlace u ofrecido en la modalidad de banner o cualquier otra publicidad, y T3RS no tomará parte o será de ninguna manera responsable de supervisar cualquier transacción entre usted y terceros proveedores de productos y/o servicios. Como en la compra de un producto o servicio a través de cualquier medio o en cualquier lugar, usted debe ser precavido y usar su buen juicio cuando sea apropiado.</p>

<p>Limitación de la responsabilidad: en ningún caso T3RS, sus funcionarios, directores, empleados, o agentes, serán responsables ante usted por cualquier daño directo, indirecto, fortuito, especial, punitivo o los daños consecuentes de cualquier naturaleza como resultado de (i) equivocaciones o errores, o inexactitudes del contenido, (ii) daños corporales o daño material, de cualquier naturaleza como resultado de su acceso a y uso de nuestra aplicación, (iii) cualquier acceso a o uso desautorizado de nuestros servidores protegidos y/o cualquier y toda la información personal y/o la información financiera almacenada en ellos, (iv) cualquier interrupción o cesación de la transmisión a o desde nuestra aplicación, (v) cualquier virus, troyanos o similares, los cuales pueden ser transmitidos a través de nuestra aplicación por un tercero, y/o (vi) cualquier error u omisión en cualquier contenido o cualquier pérdida o daño de cualquier clase ocurrida en como resultado de su utilización de cualquier contenido puesto, enviado por correo electrónico, transmitido, o de otra manera hecho disponible vía el requerimiento en T3RS, ya sean soportados por garantía, contrato, agravio, o cualquier otra teoría legal, y aunque la compañía tenga conocimiento de la posibilidad de tales daños. La limitación de la responsabilidad precedente se aplicará con todo el alcance de la ley en la jurisdicción correspondiente.</p>

<p>Usted reconoce específicamente que T3RS no será responsable por las propuestas de los usuarios o la conducta difamatoria, ofensiva, o ilegal de cualquier tercero y el riesgo cualquier daño o menoscabo como consecuencia de los anteriores recae enteramente en usted.</p>

<p>La aplicación es mantenida por T3RS desde sus oficinas en Bogotá, Colombia, Piso 1. T3RS no asume ni proclama que la aplicación sea apropiada o esté disponible en otros lugares. Los que tienen acceso o utilizan T3RS desde otras jurisdicciones hacen así que en su propia voluntad y son responsables de conformidad con las leyes locales.</p>

<p>Indemnización: Usted acepta defender, indemnizar y mantener fuera de peligro a T3RS, sus socios, funcionarios, directivos, empleados y agentes contra cualquier tipo de demanda, daños, obligaciones, pérdidas, responsabilidades, costos o deudas, y costos (que incluyen pero no se limitan a los honorarios del abogado) que se derivan de: (i) su uso y acceso a la aplicación de T3RS; (ii) su violación de cualquier término de estos Términos del Servicio; (iii) su violación de cualquier derecho de terceros, incluyendo sin limitación alguna violación a los derechos de autor, propiedad y derecho a la privacidad; o (iv) cualquier reclamación de que su contenido ha causado daños a terceros. Esta obligación a la defensa e indemnización, prevalecerá estos Términos del Servicio y su uso de la aplicación en T3RS</p>

<p>Capacidad de aceptar términos del servicio: Usted afirma que, o tiene más de 18 años de edad, o es un menor de edad emancipado, o tiene consentimiento de sus padres o guardián legal, y es completamente capaz y competente de aceptar los términos, las condiciones, las obligaciones, las afirmaciones, las representaciones, y las garantías dispuestas en estos Términos del Servicio, y se atiene y compromete a cumplir con los Términos del Servicio. Si usted es menor de 18 años de edad, por favor no utilice la aplicación de T3RS.</p>

<p>Cesión: Estos Términos del Servicio y todos los derechos y licencias concedidas aquí, no se pueden transferir o ceder por usted, pero pueden ser cedidos por T3RS sin ninguna restricción.</p>

<p>General: Usted acepta que: (i) los requerimientos cargados en T3RS serán conceptuado solamente en Colombia y (ii) el módulo de carga de requerimientos en T3RS será considerado como un sitio web pasivo que no da lugar a jurisdicción personal sobre T3RS, ya sea específica o general, otras jurisdicciones, excepto en Colombia. Estos Términos del Servicio serán gobernados por las leyes substantivas internas de Colombia. Cualquier reclamación o disputa entre usted y T3RS derivada, en todo o en parte, del requerimiento en T3RS será dirimida total o parcialmente por un juzgado competente de la jurisdicción de Colombia. Estos Términos, junto con la política de privacidad en Política de Privacidad y cualquier otro aviso legal publicado por T3RS, constituirá el acuerdo entero entre usted y T3RS referente al servicio de requerimiento de T3RS. Si alguna disposición de estos Términos del Servicio es juzgada inválida por una corte de la jurisdicción competente, la invalidez de tal disposición no afectará la validez de las provisiones restantes de estos Términos del Servicio, los cuales permanecerán en vigor y efecto. No se juzgará ninguna renuncia de ningún término de estos Términos del Servicio y la continuación de la renuncia de tal término o de cualquier otro término, y la falta de T3RS de hacer valer cualquier término de estos Términos del servicio no constituirá una renuncia de tal derecho o disposición. T3RS se reserva el derecho de enmendar estos Términos del Servicio en cualquier momento y sin previo aviso, y es su responsabilidad revisar estos Términos del Servicio por cualquier cambio. El uso que usted haga del software (aplicación de T3RS después de cualquier enmienda de estos Términos del Servicio significará su consentimiento y aceptación de los Términos revisados. Usted acepta que sin importar cualquier estatuto o ley que lo contradiga, cualquier demanda o reclamo a causa o relacionado con el uso de la aplicación o de los Términos, se debe interponer dentro del siguiente (1) año a la fecha de ocurrencia o será para siempre excluída.</p>

<p>Modificación de términos: Usted acepta que T3RS se reserva el derecho de enmendar los Términos en cualquier momento, por cualquier razón, y sin previo aviso, incluyendo el derecho de terminar el servicio o cualquier parte del mismo. Cualquier enmienda o modificación hecha por T3RS será hacia el futuro solamente.</p>

<p>Divulgación de violaciones: Usted puede divulgar el abuso de estos Términos a soporte@t3rsc.co</p>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-danger btn-xs col-md-2 pull-right" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-xs col-md-2 pull-right" id="acepto_politica_c">Acepto</button>--}}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</footer>

<script>

    /*este evento oculta los botones de "aceptar" y "cerrar" del modal de POLITICA DE PROTECCION DE DATOS*/
    $('#inactivaBotonesModal').click(function(e){
        $('#botonesTratamientoDatos').hide();
    });

    /* este evento selecciona el check de POLITICA DE PROTECCION DE DATOS que se encuentra en la vista de "cv/registro.blade.php" y cierra el modal */
    $('#acepto_politica_c').click(function (e) {
        
        $('input#acepto_politicas_privacidad').prop('checked', true);
        $('#myModal').modal('hide');
    });
</script>
		
		
    