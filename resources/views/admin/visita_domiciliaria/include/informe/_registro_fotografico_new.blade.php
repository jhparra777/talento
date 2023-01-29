<div class="page-break"></div>
<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">ALBUM FOTOGRÁFICO</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>

<section class="center">

    <div class="row col-md-12">
        <div class="col-md-6" style="max-width: 50%;float: left; border-style: double;">
            @if($imagenes["foto_fachada"]!=null)
                <div>
                    <img class="img-registro" style="width: 100%;" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_fachada]")}}'>
                </div>           
                @else
                <div class="no-image">
                    <span>Imagen no cargada</span>
                </div>
            @endif 
            <b><p class=pie>Foto fachada</p></b>
        </div>

        <div class="col-md-6" style="max-width: 50%;float: left; border-style: double;">
            @if($imagenes["foto_evaluado_nucleo"]!=null)
                <div>
                    <img class="img-registro" style="width: 100%;" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_evaluado_nucleo]")}}'>
                </div>           
                @else
                <div class="no-image">
                    <span>Imagen no cargada</span>
                </div>
            @endif 
            <b><p class=pie>Foto núcleo familiar</p></b>
        </div>

    </div>

    <div class="row col-md-12">

        <div class="col-md-6" style="max-width: 50%;float: left; border-style: double;">
            @if($imagenes["foto_comedor"]!=null)
                <div>
                    <img class="img-registro" style="width: 100%;" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_comedor]")}}'>
                </div>           
                @else
                <div class="no-image">
                    <span>Imagen no cargada</span>
                </div>
            @endif 
            <b><p class=pie>Foto comedor</p></b>
        </div>

        <div class="col-md-6" style="max-width: 50%;float: left; border-style: double;">
            @if($imagenes["foto_sala"]!=null)
                <div>
                    <img class="img-registro" style="width: 100%;" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_sala]")}}'>
                </div>           
                @else
                <div class="no-image">
                    <span>Imagen no cargada</span>
                </div>
            @endif 
            <b><p class=pie>Foto sala</p></b>
        </div>
    </div>

    <div class="row col-md-12" style="padding-bottom: 30px;">
        <div class="col-md-6" style="max-width: 50%;float: left; border-style: double;">
            @if($imagenes["foto_evaluado"]!=null)
                <div>
                    <img style="width: 100%;" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_evaluado]")}}'>
                </div>           
            @else
                <div class="no-image">
                    <span>Imagen no cargada</span>
                </div>
            @endif 
            <b><p class=pie>Foto evaluado</p></b>
        </div>

        <div class="col-md-6" style="max-width: 50%;float: left;">

        </div>
    </div>
    
</section>
<br>