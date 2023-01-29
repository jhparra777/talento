<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="
    width:100%;
    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    {{-- Estilos del correo --}}
    @include('mail_template.template_1.src.template_1_styles')
</head>

<body style="
    width:100%;
    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
    padding:0;
    Margin:0">

    <div class="es-wrapper-color" style="background-color:#f5f5f5">

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
                    @include('mail_template.template_1.header.mail_header')

                    {{-- Logo del correo --}}
                    @include('mail_template.template_1.logo.mail_logo')

                    {{-- Cuerpo del correo --}}
                    @include('mail_template.template_1.body.mail_body')

                    {{-- Footer del correo (Logo t3) --}}
                    @include('mail_template.template_1.footer.mail_footer')

                    {{-- Redes del footer del correo --}}
                    @include('mail_template.template_1.social.mail_social')

                    {{-- Imagen final del correo --}}
                    @include('mail_template.template_1.aditional.mail_aditional')

                </td>
            </tr>
        </table>

    </div>
</body>
</html>