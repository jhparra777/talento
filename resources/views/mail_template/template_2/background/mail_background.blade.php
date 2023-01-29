<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
    border-collapse:collapse;
    border-spacing:0px;
    table-layout:fixed !important;
    width:100%">
    <tr style="border-collapse:collapse">
        <td align="center" style="padding:0; Margin:0">

            <table class="es-content-body" style="
                mso-table-lspace:0pt;
                mso-table-rspace:0pt;
                border-collapse:collapse;
                border-spacing:0px;
                background-color:{{ $data->configurationTemplate->color_secundario }};
                width:600px" 
                cellspacing="0" 
                cellpadding="0" 
                bgcolor="{{ $data->configurationTemplate->color_secundario }}" 
                align="center"
            >
                <tr style="border-collapse:collapse">
                    <td style="
                        Margin:0;
                        padding-top:60px;
                        padding-bottom:60px;
                        padding-left:40px;
                        padding-right:40px;
                        background-image:url('{{ asset('templates_src/conf_'.$data->configurationTemplate->id.'/'.$data->configurationTemplate->imagen_fondo_header) }}');
                        background-repeat:no-repeat;
                        background-size: cover" 
                        align="left" 
                        background='{{ asset('templates_src/conf_'.$data->configurationTemplate->id.'/'.$data->configurationTemplate->imagen_fondo_header) }}'
                    >

                        <!-- Botón header -->
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
                                            <td align="center" style="
                                                padding:0;
                                                Margin:0;
                                                padding-bottom:10px;
                                                padding-top:40px">
                                                {{-- 
                                                    <h1 style="
                                                        Margin:0;
                                                        line-height:36px;
                                                        mso-line-height-rule:exactly;
                                                        font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;
                                                        font-size:30px;
                                                        font-style:normal;
                                                        font-weight:bold;
                                                        color:#FFFFFF">
                                                        {{ $data->mailTitle }}
                                                    </h1>
                                                 --}}
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
                                            <td esdev-links-color="#757575" align="center" style="
                                                Margin:0;
                                                padding-top:10px;
                                                padding-bottom:20px;
                                                padding-left:30px;
                                                padding-right:30px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:15px;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    line-height:23px;
                                                    color:#757575">
                                                    {{-- puede ir un texto --}}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
                                            <td align="center" style="
                                                padding:0;
                                                Margin:0;
                                                padding-top:10px;
                                                padding-bottom:20px">
                                                <div style="padding: 1rem;"></div>
                                                <span class="es-button-border" style="
                                                    border-style:solid;
                                                    border-color:{{ $data->configurationTemplate->color_principal }};
                                                    background:{{ $data->configurationTemplate->color_principal }} none repeat scroll 0% 0%;
                                                    border-width:0px;
                                                    display:inline-block;
                                                    border-radius:50px;
                                                    width:auto">
                                                    {{-- <a href="#" class="es-button" target="_blank" style="
                                                        mso-style-priority:100 !important;
                                                        text-decoration:none;
                                                        transition:all 100ms ease-in;
                                                        -webkit-text-size-adjust:none;
                                                        -ms-text-size-adjust:none;
                                                        mso-line-height-rule:exactly;
                                                        font-family:arial, 'helvetica neue', helvetica, sans-serif;
                                                        font-size:14px;
                                                        color:#FFFFFF;
                                                        border-style:solid;
                                                        border-color:{{ $data->configurationTemplate->color_principal }};
                                                        border-width:15px 30px 15px 30px;
                                                        display:inline-block;
                                                        background:{{ $data->configurationTemplate->color_principal }} none repeat scroll 0% 0%;
                                                        border-radius:50px;
                                                        font-weight:bold;
                                                        font-style:normal;
                                                        line-height:17px;
                                                        width:auto;
                                                        text-align:center">
                                                        GET TICKETS
                                                    </a> --}}
                                                </span>
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