<section id="informacion-laboral">
    <h4>INFORMACIÓN LABORAL</h4>

    <table class="tributaria">
        <tr>
            <th>Hace cuanto tiempo labora en la compañía</th>
            <td>{{$visita->tiempo_compania}}</td>
        </tr>
        
    

        <tr>
            <th>¿Con que cargo ingresó a la compañía?</th>
            <td>{{$visita->cargo_compania}}</td>
        </tr>
        
        
   
         <tr>
            <th>¿Ha tenido algún encargo durante su permanencia en la compañía?</th>
            <td>{{$visita->encargo_compania}}</td>
        </tr>
        
   

        <tr>
            <th>Observaciones encargo</th>
            <td>{{$visita->observaciones_encargo}}</td>
        </tr>
        
    </table>
   

</section>