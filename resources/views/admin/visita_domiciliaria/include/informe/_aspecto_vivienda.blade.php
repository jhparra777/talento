<section id="aspecto_vivienda">
    <h4>ASPECTOS DE LA VIVIENDA</h4>

 
    <h5>Características de la vivienda</h5>

    <div class="vivienda">
        <ul>
            <li><span class="negrita">Tipo vivienda:</span> 
                <span class="valor">
                    @foreach($tipo_vivienda as $tipo)
                        @if($visita->tipo_vivienda==$tipo->id) 
                            {{$tipo->descripcion}} 
                        @endif
                        
                    @endforeach
                </span>
            </li>
            @if($visita->propiedad==3)
                <li><span class="negrita">Nombre arrendador:</span> <span class="valor">{{$visita->nombre_arrendador}}</span></li>
            @endif
            <li><span class="negrita">No. Familias que habitan:</span> <span class="valor">{{$visita->nro_familias}}</span></li>
            <li><span class="negrita">No. de pisos:</span> <span class="valor">{{$visita->nro_pisos}}</span></li>
            <li><span class="negrita">No. de personas que habitan:</span> <span class="valor">{{$visita->nro_personas}}</span></li>
            <li><span class="negrita">Estrato:</span> <span class="valor">{{$visita->estrato}}</span></li>
            <li><span class="negrita">Sector:</span> <span class="valor">{{$visita->sector_vivienda}}</span></li>
            <li><span class="negrita">Orden durante visita:</span> 
                @if($visita->orden_entrevista==1)
                    <span class="valor">Bueno</span>
                @elseif($visita->orden_entrevista==2)
                    <span class="valor">Regular</span>
                @else
                    <span class="valor">Malo</span>
                @endif
            </li>
            <li><span class="negrita">Medio utilizado:</span> <span class="valor">{{$visita->medio_transporte}}</span></li>

            
        </ul>
    </div>
    <div class="vivienda">
        <ul>
            <li><span class="negrita">Tipo propiedad:</span> 
                <span class="valor">
                    @foreach($tipo_propiedad as $tipo2)
                        @if($visita->propiedad==$tipo2->id) 
                            {{$tipo2->descripcion}} 
                        @endif
                        
                    @endforeach
                </span>
            </li>
            @if($visita->propiedad==3)
                <li><span class="negrita">Teléfono arrendador:</span> <span class="valor">{{$visita->telefono_arrendador}}</span></li>
            @endif
            
            <li><span class="negrita">Localidad:</span> <span class="valor">{{$visita->localidad_id}}</span></li>
            <li><span class="negrita">Facilidades de tansporte:</span>
                @if($visita->facilidades_transporte==1)
                    <span class="valor">Bueno</span>
                @elseif($visita->facilidades_transporte==2)
                    <span class="valor">Regular</span>
                @else
                    <span class="valor">Malo</span>
                @endif
            </li>
            <li><span class="negrita">Facilidades de tansporte:</span>
                @if($visita->facilidades_transporte==1)
                    <span class="valor">Bueno</span>
                @elseif($visita->facilidades_transporte==2)
                    <span class="valor">Regular</span>
                @else
                    <span class="valor">Malo</span>
                @endif
            </li>
            <li><span class="negrita">Tiempo traslado al trabajo:</span> <span class="valor">{{$visita->tiempo_trabajo}}</span></li>

            
        </ul>
    </div>
  
   

  
   
    <br/>
    
    
   
     <br/>
    <table>
        <tr>
            <th>En el sector hay presencia de: </th>
            <th>SI</th>
            <th>NO</th>
            <th>Observaciones</th>
            
        </tr>
        <tr>
            <td>
                Milicias
            </td>
            <td>
                @if($visita->hay_milicias) X @endif
            </td>
            <td>
                @if(!$visita->hay_milicias) X @endif
            </td>
            <td rowspan="4">{{$visita->observaciones_hurto}}</td>
        </tr>
        <tr>
            <td>
                Pandillas
            </td>
            <td>
                @if($visita->hay_pandillas) X @endif
            </td>
            <td>
                @if(!$visita->hay_pandillas) X @endif
            </td>
        </tr>
        <tr>
            <td>
                Habitantes calle
            </td>
            <td>
                @if($visita->hay_habitantes_calle) X @endif
            </td>
            <td>
                @if(!$visita->hay_habitantes_calle) X @endif
            </td>
        </tr>
        <tr>
            <td>
                Delincuencia común
            </td>
            <td>
                @if($visita->hay_delincuencia) X @endif
            </td>
            <td>
                @if(!$visita->hay_delincuencia) X @endif
            </td>
        </tr>
    </table>
    <br>
    <h5>
        Material predominante en la construcción
    </h5>
    <table>
        <tr>
            <th>Techo</th>
            <th>Paredes</th>
            <th>Pisos</th>
        </tr>
        <tr>
            <td>{{$material_techo[$visita->material_techo]}}</td>
            <td>{{$material_paredes[$visita->material_paredes]}}</td>
            <td>{{$material_piso[$visita->material_piso]}}</td>
        </tr>


    </table>
    <br/>
    <table>
        <tr>
            <th>Observaciones generales de la vivienda</th>
        </tr>
        <td>
            {{$visita->observaciones_generales_vivienda}}
        </td>
         <tr>
            <th>Orden y aseo durante la visita</th>
        </tr>
        <td>
            @if($visita->orden_entrevista==1)
                Bueno
            @elseif($visita->orden_entrevista==2)
                Regular
            @else
                Malo
            @endif
        </td>
    </table>
    <h5>
       Distribución espacial de la vivienda
    </h5>
    <table>
        <tr>
            <th>Habitaciones</th>
            <td>{{$distribucion_espacial["habitaciones"]}}</td>
            <th>Baños</th>
            <td>{{$distribucion_espacial["banos"]}}</td>
            <th>Cocina</th>
            <td>{{$distribucion_espacial["cocina"]}}</td>
            <th>Sala</th>
            <td>{{$distribucion_espacial["sala"]}}</td>


        </tr>
        <tr>
            <th>Patio</th>
            <td>{{$distribucion_espacial["patio"]}}</td>
            <th>Comedor</th>
            <td>{{$distribucion_espacial["comedor"]}}</td>
            <th>Garage</th>
            <td>{{$distribucion_espacial["garage"]}}</td>
            <th>Estudio</th>
            <td>{{$distribucion_espacial["estudio"]}}</td>
            


        </tr>
    </table>

    <h5>
        Mobiliario
    </h5>
    <table>
        <tr>
            <th>Televisor</th>
            <td>{{$mobiliario["televisor"]}}</td>
            <th>Estereo</th>
            <td>{{$mobiliario["estereo"]}}</td>
            <th>DVD/Teatro en casa</th>
            <td>{{$mobiliario["dvd"]}}</td>
            <th>Estufa</th>
            <td>{{$mobiliario["estufa"]}}</td>
            <th>Horno microondas</th>
            <td>{{$mobiliario["microondas"]}}</td>


        </tr>
        <tr>
            <th>Lavadora</th>
            <td>{{$mobiliario["lavadora"]}}</td>
            <th>Nevera</th>
            <td>{{$mobiliario["nevera"]}}</td>
            <th>Video juegos</th>
            <td>{{$mobiliario["video_juegos"]}}</td>
            <th>PC</th>
            <td>{{$mobiliario["pc"]}}</td>
            <th>Portatil</th>
            <td>{{$mobiliario["portatil"]}}</td>
            


        </tr>
    </table>
    


</section>