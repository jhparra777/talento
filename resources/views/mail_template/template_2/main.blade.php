<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="
    width:100%;
    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
    padding:0;
    Margin:0">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Correo</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">

    {{-- Estilos del correo --}}
    @include('mail_template.template_2.src.template_2_styles')
</head>

<body style="
    width:100%;
    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
    padding:0;
    Margin:0">
    <div class="es-wrapper-color" style="background-color:#F1F1F1">

        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="
            mso-table-lspace:0pt;
            mso-table-rspace:0pt;
            border-collapse:collapse;
            border-spacing:0px;
            padding:0;
            Margin:0;
            width:100%;
            height:100%;
            background-repeat:repeat;
            background-position:center top">
            <tr style="border-collapse:collapse">
                <td valign="top" style="padding:0; Margin:0">

                    {{-- Header del correo --}}
                    @include('mail_template.template_2.header.mail_header')

                    {{-- Header con imagen del correo --}}
                    @include('mail_template.template_2.logo.mail_logo')

                    {{-- Presentación con imagen de fondo del correo --}}
                    @include('mail_template.template_2.background.mail_background')

                    {{-- Cuerpo del correo --}}
                    @include('mail_template.template_2.body.mail_body')

                    {{-- Lista de items --}}
                    {{-- @include('mail_template.template_2.sub_body.mail_sub_body') --}}

                    {{-- Extension del cuerpo del correo --}}
                    @if(!empty($data->mailAditionalTemplate))
                        @include("mail_template.includes.".$data->mailAditionalTemplate["nameTemplate"], ["dataTemplate" => $data->mailAditionalTemplate["dataTemplate"]])
                    @endif

                    {{-- Footer con botón --}}
                    {{-- @include('mail_template.template_2.footer.mail_footer') --}}

                    {{-- Footer con redes sociales --}}
                    @include('mail_template.template_2.social.mail_social')

                    {{-- Footer informativo --}}
                    @include('mail_template.template_2.information.mail_information')

                    {{-- Imagen final --}}
                    @include('mail_template.template_2.aditional.mail_aditional')

                </td>
            </tr>
        </table>

    </div>
</body>
</html>