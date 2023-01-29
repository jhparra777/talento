<!DOCTYPE html>
<html lang="en">
<head>
    @if(triRoute::validateOR('local'))
        <?php set_time_limit(420); ?>
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Informe de Selección - T3RS</title>

    <link rel="stylesheet" href="{{ asset('assets/css/estilos_informe_visita.css') }}">

    <script src="https://kit.fontawesome.com/a23970da56.js" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        @page {
            margin: 0.8cm 0.8cm;
            font-family: 'Roboto', sans-serif;
        }

        .novedades{
            width: 60%; 
            margin: 0 auto;
        }
        
        body {
            font-family: 'Roboto', sans-serif;

            background-color: #f1f1f1;
        }

        .text-center{ text-align: center; }
        .text-left{ text-align: left; }
        .text-right{ text-align: right; }
        .text-justify{ text-align: justify; }

        .table{ border-collapse:separate; }

        .table th {
            border: none;
        }

        /* th, td {
            width: 25%;
            text-align: left;
            vertical-align: top;
            padding: 0.3em;
        } */

        .alinea{
            width: 25%;
            text-align: left;
            vertical-align: top;
            padding: 0.3em;
        }
   
        /* ul { list-style: url("/images/brand/1.png") square; } */

        .font-size-10{ font-size: 10pt; }
        .font-size-11{ font-size: 11pt; }
        .font-size-12{ font-size: 12pt; }
        .font-size-14{ font-size: 14pt; }

        .circle {
            position: relative;
            background-color: #6F3795;
            margin: 10px auto;
        }

        .c-1 {
            width: 50px;
            height: 50px;
            border-radius: 25px 25px 25px 25px;
        }

        .c-2 {
            width: 86px;
            height: 86px;
            border-radius: 43px 43px 43px 43px;
        }

        .text-circle-1 {
            padding-left: 5px;
            padding-top: 12px;
            color: #fff;
            font-size: 15pt;
            font-weight: 700;
        }

        .text-circle-2 {
            padding-left: 5px;
            padding-top: 18px;
            color: #fff;
            font-size: 30pt;
            font-weight: 700;
        }

        .table-result{
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 0.5rem;
            font-family: 'Roboto', sans-serif;
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);
        }

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .ml-0{ margin-left: 0; }
        .ml-05{ margin-left: 0.5rem; }
        .ml-1{ margin-left: 1rem; }
        .ml-2{ margin-left: 2rem; }
        .ml-3{ margin-left: 3rem; }
        .ml-4{ margin-left: 4rem; }

        .mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .m-auto{ margin: auto; }

        .pd-0{ padding: 0; }
        .pd-05{ padding: 0.5rem; }
        .pd-1{ padding: 1rem; }
        .pd-2{ padding: 2rem; }
        .pd-3{ padding: 3rem; }
        .pd-4{ padding: 4rem; }

        .no-list{ list-style: none; }

        .table-result{
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 0.5rem;
            font-family: 'Roboto', sans-serif;
            /*box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);*/
        }

        .secciones-titulos {
            margin-bottom: -2rem;
            margin-top: 2rem;
        }

        .secciones-titulos-2 {
            margin-top: 2rem;
        }

        .bg-blue{ background-color: #2E2D66; color: white; }
        .bg-dark-blue{ background-color: #2c3e50; color: white; }
        .bg-red{ background-color: #D92428; color: white; }
        .bg-yellow{ background-color: #E4E42A; color: white; }
        .bg-green{ background-color: #00A954; color: white; }

        .color-blue{ color: #2E2D66; }
        .color-red{ color: #D92428; }
        .color-yellow{ color: #E4E42A; }
        .color-green{ color: #00A954; }

        .color{ color: #6F3795; }
        .color-sec{ color: #231F20; }

        .bg-blue-a{ background-color: #0288d1; color: white; }
        .bg-red-a{ background-color: #f44336; color: white; }
        .bg-yellow-a{ background-color: #fdd835; color: white; }
        .bg-green-a{ background-color: #7cb342; color: white; }

        .br-05{ border-radius: 5px; }

        .fw-600{ font-weight: 600; }
        .fw-700{ font-weight: 700; }

        .page-break{ page-break-after: always; }

        .profile-picture{
            padding: .25rem;
            width: 100px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
        }

        .divider{ width: 44.5%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px;}
        .divider-th{ width: 90%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px;}
        .divider-hd{ width: 100%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-10{ width: 10%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-20{ width: 20%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-25{ width: 25%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-30{ width: 30%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-40{ width: 40%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-50{ width: 50%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-60{ width: 60%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-70{ width: 70%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-80{ width: 80%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-90{ width: 90%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }


        .text-uppercase { text-transform: uppercase; }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /*background-color: #2a0927;*/
            color: #d6d6d6;
            text-align: center;
            line-height: 20px;
            display: none;
        }

        .main{
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 1rem;
            border-radius: 1rem;
            border: solid 1px #ddd;
            background-color: white;
        }

        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
                border-top-color: transparent;
                border-right-color: transparent;
                border-bottom-color: transparent;
                border-left-color: transparent;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .btn-default:hover {
            color: #333;
            background-color: #e6e6e6;
            border-color: #adadad;
        }

        .btn:hover {
            text-decoration: none;
        }

        .center {
           /* // border: 1px solid #0a0a00; */
            margin: 0 auto;
            width: 90%;
        }
    </style>

    <style media="print">
        body {
            margin: 0.5cm 0.5cm;

            background-color: transparent !important;
        }

        .main {
            width: 100%;

            padding: 0rem;
            border-radius: 0rem;
            border: none;
            background-color: none;
        }

        footer {
            display: block !important;
        }

        .section-descarga {
            display: none;
        }
    </style>
</head>
<body>
    <div class="section-descarga" style="margin: auto; width: 80%; border: solid 1px #ddd; background-color: white; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; margin-top: 1rem;">
        <div class="text-right">
            <button class="btn btn-default" onclick="window.print()">Descargar PDF <i class="fas fa-download"></i></button>
        </div>
    </div>

    <main class="main">
        {{-- Logos T3RS y cliente --}}
        <section>
            <table width="100%">
                <tr>
                    <td class="text-left">
                        <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="T3RS" width="120">
                    </td>
                    <td></td>
                    <td class="text-right">
                        @if(!triRoute::validateOR('local'))
                            @if(!is_null($reqcandidato->logo_empresa) && $reqcandidato->logo_empresa != "")
                                <img src="{{ asset("configuracion_sitio/$reqcandidato->logo_empresa") }}" alt="T3RS" height="60">
                            @elseif($logo!="")
                                <img src="{{ url('configuracion_sitio/'.$logo) }}" alt="T3RS" height="60">
                            @else
                                <img src="{{ url('img/logo.png') }}" alt="T3RS" height="60">
                            @endif
                        @else
                            <img src="https://picsum.photos/120/60" alt="T3RS" height="60">
                        @endif
                    </td>
                </tr>
            </table>
        </section>

        {{-- Foto de perfil del candidato (si posee) --}}
        <section >
            <div class="text-center">
                @if(!triRoute::validateOR('local'))
                    @if(!empty($visita->foto_perfil))
                        <img 
                            src="{{ url('recursos_datosbasicos/'.$visita->foto_perfil) }}" 
                            alt="Foto de perfil" 
                            class="profile-picture" 
                            width="100"
                        >
                    @elseif($visita->avatar != "")
                        <img 
                            src="{{ $visita->avatar }}" 
                            alt="Foto de perfil" 
                            class="profile-picture" 
                            width="100"
                        >
                    @else
                        <img 
                            src="{{ url("img/personaDefectoG.jpg") }}" 
                            alt="Foto de perfil" 
                            class="profile-picture" 
                            width="100"
                        >
                    @endif
                @else
                    <img class="profile-picture" src="https://picsum.photos/500" alt="Foto de perfil">
                @endif
            </div>
        </section>

        {{-- Datos de empresa, cargo ciudad y fecha --}}
        <section class="col-md-12">
            <div class="font-size-11 text-center">
                <ul class="no-list pd-0 mt-1">
                    
                    @if($visita->nombre_empresa !=null)
                        <li>
                            <b>Empresa:</b> {{ $visita->nombre_empresa }}
                        </li>
                    @endif

                    @if($visita->cargo !=null)
                        <li>
                            <b>Cargo:</b> {{ $visita->cargo }}
                            {{-- {{ ucwords(mb_strtolower($datos_basicos->dec_tipo_doc)) }}: {{ number_format($datos_basicos->numero_id) }} --}}
                        </li>
                    @endif

                    <li>
                        <b>Ciudad y fecha:</b> {{ \App\Models\Ciudad::GetCiudad($visita->pais_residencia,$visita->departamento_residencia,$visita->ciudad_residencia) }}  {{date("d-m-Y",strtotime($visita->visita_candidato->fecha_gestion_admin))}}
                    </li>
  
                    <li>
                        <b>Persona que realiza la visita:</b> {{ $visitador->nombres_admin }} {{ $visitador->primer_apellido_admin }} {{ $visitador->segundo_apellido_admin }}
                    </li>
                </ul>
            </div>
        </section>

        {{-- Datos del usuario --}}
        @include('admin.visita_domiciliaria.include.informe._datos_basicos_new')
        {{-- Datos seccion familiares --}}
        @include('admin.visita_domiciliaria.include.informe._estructura_familiar_new')
        {{-- Datos seccion vivienda --}}
        @include('admin.visita_domiciliaria.include.informe._aspecto_vivienda_new')
        {{-- Datos seccion ingresos y egresos --}}
        @include('admin.visita_domiciliaria.include.informe._ingresos_egresos_new')
        {{-- Datos seccion bienes inmuebles --}}
        @include('admin.visita_domiciliaria.include.informe._bienes_inmuebles_new')
        {{-- Datos seccion formacion academica --}}
        @include('admin.visita_domiciliaria.include.informe._formacion_academica_new')
        {{-- Datos seccion informacion laboral --}}
        @include('admin.visita_domiciliaria.include.informe._informacion_laboral_new')
        {{-- Datos seccion Estado salud --}}
        @include('admin.visita_domiciliaria.include.informe._estado_salud_new')
        {{-- Datos seccion informacion adicional --}}
        @include('admin.visita_domiciliaria.include.informe._informacion_adicional_new')
        {{-- Datos seccion visita periodica --}}
        @include('admin.visita_domiciliaria.include.informe._visita_periodica_new')
        {{-- Datos seccion concepto general --}}
        @include('admin.visita_domiciliaria.include.informe._concepto_general_new')
        {{-- Datos seccion registro fotografico --}}
        @include('admin.visita_domiciliaria.include.informe._registro_fotografico_new')
        {{-- Datos seccion enlace virtual --}}
        @include('admin.visita_domiciliaria.include.informe._link_visita_virtual_new')

    </main>

    <footer>
        <div
                style="
                position:fixed !important;
                z-index: -1000;
                bottom: .5cm;
                right: .5cm;
                opacity: .7;
                font-size: 8pt;
                text-align: right;"
        >
            <i><a href="https://www.t3rsc.co" style="text-decoration: none; color:black;">Documento generado con la tecnología de t3rsc.co</a></i>
        </div>
    </footer>
</body>
</html>