<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
    border-collapse:collapse;
    border-spacing:0px;
    table-layout:fixed !important;
    width:100%">
    <tr style="border-collapse:collapse">
        <td class="es-adaptive" align="center" style="padding:0; Margin:0">

            <table class="es-content-body" style="
                mso-table-lspace:0pt;
                mso-table-rspace:0pt;
                border-collapse:collapse;
                border-spacing:0px;
                background-color:transparent;
                width:600px" cellspacing="0" cellpadding="0" bgcolor="{{ $data->configurationTemplate->color_secundario }}" align="center">
                <tr style="border-collapse:collapse">
                    <td align="left" style="padding:0; Margin:0; padding-top:25px">

                        <table width="100%" cellspacing="0" cellpadding="0" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px">
                            <tr style="border-collapse:collapse">
                                <td valign="top" align="center" style="padding:0; Margin:0; width:600px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td align="center" style="padding:0; Margin:0; padding-bottom:30px">
                                                <h2 style="
                                                    Margin:0;
                                                    line-height:36px;
                                                    mso-line-height-rule:exactly;
                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                    font-size:22px;
                                                    font-style:normal;
                                                    font-weight:normal;
                                                    color:#333333">
                                                    {{ $data->mailTitle }}
                                                </h2>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
                                            <td style="
                                                    Margin:0;
                                                    padding-top:130px;
                                                    padding-bottom:130px;
                                                    padding-left:40px;
                                                    padding-right:40px;
                                                    background-image:url('{{ asset('templates_src/conf_'.$data->configurationTemplate->id.'/'.$data->configurationTemplate->imagen_fondo_header) }}');
                                                    background-repeat:no-repeat;
                                                    background-size: cover
                                                " 
                                                align="left" 
                                                background='{{ asset('templates_src/conf_'.$data->configurationTemplate->id.'/'.$data->configurationTemplate->imagen_fondo_header) }}'
                                            >
                                                {{-- 
                                                    <a target="_blank" href="#" style="
                                                        -webkit-text-size-adjust:none;
                                                        -ms-text-size-adjust:none;
                                                        mso-line-height-rule:exactly;
                                                        font-family:tahoma, verdana, segoe, sans-serif;
                                                        font-size:14px;
                                                        text-decoration:underline;
                                                        color:{{ $data->configurationTemplate->color_secundario }}">
                                                        <img 
                                                            class="adapt-img" 
                                                            src='{{ asset('templates_src/conf_'.$data->configurationTemplate->id.'/'.$data->configurationTemplate->imagen_fondo_header) }}' 
                                                            alt="Background image" 
                                                            title="Background image" 
                                                            width="680" 
                                                            height="400" 
                                                            style="
                                                                display:block;
                                                                border:0;
                                                                outline:none;
                                                                text-decoration:none;
                                                                -ms-interpolation-mode:bicubic"
                                                        >
                                                    </a>
                                                 --}}
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