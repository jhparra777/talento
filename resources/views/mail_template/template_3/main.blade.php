<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="
    width:100%;
    font-family:tahoma, verdana, segoe, sans-serif;
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

    {{-- Estilos del correo --}}
    @include('mail_template.template_3.src.template_3_styles')
</head>

<body style="
    width:100%;
    font-family:tahoma, verdana, segoe, sans-serif;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
    padding:0;
    Margin:0">
    <div class="es-wrapper-color" style="background-color:#E8E8E4">

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
                    @include('mail_template.template_3.header.mail_header')

                    {{-- Logo inicio del correo --}}
                    @include('mail_template.template_3.logo.mail_logo')

                    {{-- Texto e imagen de fondo del inicio del correo --}}
                    @include('mail_template.template_3.background.mail_background')

                    {{-- Cuerpo del correo --}}
                    @include('mail_template.template_3.body.mail_body')

                    {{-- Footer y redes sociales del correo --}}
                    @include('mail_template.template_3.footer.mail_footer')

                    {{-- Imagen final del correo --}}
                    @include('mail_template.template_3.aditional.mail_aditional')

                </td>
            </tr>
        </table>

    </div>
</body>
</html>