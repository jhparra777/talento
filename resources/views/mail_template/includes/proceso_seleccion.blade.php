<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
    border-collapse:collapse;
    border-spacing:0px;
    table-layout:fixed !important;
    width:100%">
    <tr style="border-collapse:collapse">
        <td align="center" style="padding:0; Margin:0;">
            <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="
                mso-table-lspace:0pt;
                mso-table-rspace:0pt;
                border-collapse:collapse;
                border-spacing:0px;
                background-color:#FFFFFF;
                width:600px">
                <tr style="border-collapse:collapse">
                    <td align="left" style="padding:0; Margin:0; padding-top:0; padding-left:40px; padding-right:40px">

                        <table width="100%" cellspacing="0" cellpadding="0" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px">
                            <tr style="border-collapse:collapse">
                                <td valign="top" align="center" style="padding:0; Margin:0; width:520px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">

                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0; padding-bottom:10px">
                                                <table style="border-collapse:collapse; border-spacing:0; padding:0; text-align:left; vertical-align:top; width:100%">
                                                    <tbody>
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <td class="es-m-txt-c" align="left" style="padding:0; Margin:0; padding-top:10px">
                                                                <p style="
                                                                    Margin:0;
                                                                    -webkit-text-size-adjust:none;
                                                                    -ms-text-size-adjust:none;
                                                                    mso-line-height-rule:exactly;
                                                                    font-size:14px;
                                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                                    line-height:21px;
                                                                    color:#666666;
                                                                    text-align: justify;">
                                                                    Te invitamos a ingresar usando tu número de documento como usuario y contraseña a completar tu hoja de vida y recuerda cargar los siguientes documentos:

                                                                    <br>

                                                                    @if(isset($dataTemplate["cargo_documentos"]))
                                                                        <ul style="
                                                                            font-size:14px;
                                                                            font-family:tahoma, verdana, segoe, sans-serif;
                                                                            line-height:21px;
                                                                            color:#666666;">
                                                                            @foreach($dataTemplate["cargo_documentos"] as $documento)
                                                                                <li>
                                                                                    {{ $documento->descripcion }}
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <b>Utiliza como usuario tu correo electrónico y en el campo contraseña te sugerimos tu número de cédula. 
                                                                            <i>¡Bienvenido!</i>
                                                                        </b>
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0; padding-bottom:10px">
                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="
                                                                Margin:0;
                                                                color:#414e67;
                                                                font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,Cantarell,'Fira Sans','Droid Sans','Helvetica Neue',sans-serif;
                                                                font-size:14px;
                                                                font-weight:300;
                                                                line-height:1.8em;
                                                                margin:0;
                                                                padding:0;
                                                                text-align:center;">
                                                                <span class="es-button-border" style="
                                                                    border-style:solid;
                                                                    border-color:{{ $data->configurationTemplate->color_principal }};
                                                                    background:#FFFFFF none repeat scroll 0% 0%;
                                                                    border-width:0px;
                                                                    display:inline-block;
                                                                    border-radius:50px;
                                                                    width:auto">
                                                                    <a href="{{ url("cv/login") }}" class="es-button" target="_blank" style="
                                                                        mso-style-priority:100 !important;
                                                                        text-decoration:none;
                                                                        transition:all 100ms ease-in;
                                                                        -webkit-text-size-adjust:none;
                                                                        -ms-text-size-adjust:none;
                                                                        mso-line-height-rule:exactly;
                                                                        font-family:arial, 'helvetica neue', helvetica, sans-serif;
                                                                        font-size:14px;
                                                                        color:white;
                                                                        border-style:solid;
                                                                        border-color:{{ $data->configurationTemplate->color_principal }};
                                                                        border-width:15px 25px;
                                                                        display:inline-block;
                                                                        background:{{ $data->configurationTemplate->color_principal }} none repeat scroll 0% 0%;
                                                                        border-radius:50px;
                                                                        font-weight:bold;
                                                                        font-style:normal;
                                                                        line-height:17px;
                                                                        width:auto;
                                                                        text-align:center">
                                                                        ACCEDER
                                                                    </a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>