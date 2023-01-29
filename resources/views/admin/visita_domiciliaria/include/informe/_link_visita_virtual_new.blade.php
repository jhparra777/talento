@if (!empty($visita->link_visita_virtual))
    <div class="page-break"></div>
    <section class="secciones-titulos-2 center">
        <h2 style="color: #6F3795;">LINK DE LA VISITA DOMICILIARIA VIRTUAL</h2>
        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
    </section>

    <section class="center">
        <ul>
            <li>
                <a  target="_blank" class="colorText"  href= '{{ $visita->link_visita_virtual }}' >Enlace visita virtual</a>
            </li>
        </ul>
    </section>
@endif
