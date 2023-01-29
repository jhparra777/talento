<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
    border-collapse:collapse;
    border-spacing:0px;
    table-layout:fixed !important;
    width:100%">
    <tr style="border-collapse:collapse">
        <td align="center" style="padding:0; Margin:0">
            <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="
                mso-table-lspace:0pt;
                mso-table-rspace:0pt;
                border-collapse:collapse;
                border-spacing:0px;
                background-color:#FFFFFF;
                width:600px">
                <tr style="border-collapse:collapse">
                    <td align="left" style="Margin:0; padding-bottom:10px; padding-left:30px; padding-right:30px; padding-top:40px">
                        <table width="100%" cellspacing="0" cellpadding="0" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px">
                            <tr style="border-collapse:collapse">
                                <td valign="top" align="center" style="padding:0; Margin:0; width:540px">
                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td class="es-m-txt-c" align="left" style="padding:0; Margin:0">
                                                <h3 style="
                                                    Margin:0;
                                                    line-height:24px;
                                                    mso-line-height-rule:exactly;
                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                    font-size:20px;
                                                    font-style:normal;
                                                    font-weight:normal;
                                                    color:#333333">
                                                    {!! $data->mailTitle !!}
                                                    <br>
                                                </h3>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
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
                                                    {!! $data->mailBody !!}

                                                    <br>
                                                </p>
                                            </td>
                                        </tr>

                                        {{-- <tr style="border-collapse:collapse">
                                            <td esdev-links-color="#18212e" class="es-m-txt-c" align="left" style="
                                                padding:0;
                                                Margin:0;
                                                padding-top:5px;
                                                padding-bottom:10px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:14px;
                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                    line-height:21px;
                                                    color:#666666">
                                                    If you have any questions about our software, we offer unlimited 24/7 support via our 
                                                    <a target="_blank" style="
                                                        -webkit-text-size-adjust:none;
                                                        -ms-text-size-adjust:none;
                                                        mso-line-height-rule:exactly;
                                                        font-family:tahoma, verdana, segoe, sans-serif;
                                                        font-size:14px;
                                                        text-decoration:underline;
                                                        color:#18212e" href="https://viewstripo.email/">
                                                        help center
                                                    </a>, and 
                                                    <a target="_blank" style="
                                                        -webkit-text-size-adjust:none;
                                                        -ms-text-size-adjust:none;
                                                        mso-line-height-rule:exactly;
                                                        font-family:tahoma, verdana, segoe, sans-serif;
                                                        font-size:14px;
                                                        text-decoration:underline;
                                                        color:#18212e" href="https://viewstripo.email/">
                                                        training courses
                                                    </a>
                                                    .<br>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
                                            <td class="es-m-txt-c" align="left" style="padding:0; Margin:0; padding-top:10px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:14px;
                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                    line-height:21px;
                                                    color:#666666">
                                                    Best regards, Mark<br>
                                                </p>
                                            </td>
                                        </tr> --}}

                                        {{-- Botón del correo --}}
                                        @if(!empty($data->mailButton))
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="
                                                    padding:0;
                                                    Margin:0;
                                                    padding-right:10px;
                                                    padding-top:40px;
                                                    padding-bottom:20px;
                                                    text-align: center;">
                                                    <span class="es-button-border" style="
                                                        border-style:solid;
                                                        border-color:{{ $data->configurationTemplate->color_principal }};
                                                        background:{{ $data->configurationTemplate->color_principal }};
                                                        border-width:0px;
                                                        display:inline-block;
                                                        border-radius:4px;
                                                        width:auto">
                                                        <a href="{{ $data->mailButton->buttonRoute }}" class="es-button" target="_blank" style="
                                                            mso-style-priority:100 !important;
                                                            text-decoration:none;
                                                            -webkit-text-size-adjust:none;
                                                            -ms-text-size-adjust:none;
                                                            mso-line-height-rule:exactly;
                                                            font-family:arial, 'helvetica neue', helvetica, sans-serif;
                                                            font-size:16px;
                                                            color:#FFFFFF;
                                                            border-style:solid;
                                                            border-color:{{ $data->configurationTemplate->color_principal }};
                                                            border-width:10px 20px 10px 20px;
                                                            display:inline-block;
                                                            background:{{ $data->configurationTemplate->color_principal }};
                                                            border-radius:4px;
                                                            font-weight:normal;
                                                            font-style:normal;
                                                            line-height:19px;
                                                            width:auto;
                                                            text-align:center">
                                                            {{ $data->mailButton->buttonText }}
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr style="border-collapse:collapse">
                    <td align="left" style="Margin:0; padding-top:20px; padding-left:30px; padding-right:30px; padding-bottom:40px">

                        {{-- <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px;
                            float:left">
                            <tr style="border-collapse:collapse">
                                <td class="es-m-p20b" align="left" style="padding:0; Margin:0; width:260px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:14px;
                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                    line-height:21px;
                                                    color:#666666">
                                                    <span style="font-weight:bold; line-height:150%">
                                                        Mark Backer
                                                    </span>, from Bookkeeping<br>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px;
                            float:right">
                            <tr style="border-collapse:collapse">
                                <td align="left" style="padding:0; Margin:0; width:260px">
                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td align="right" style="padding:0; Margin:0">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:14px;
                                                    font-family:tahoma, verdana, segoe, sans-serif;
                                                    line-height:21px;
                                                    color:#666666">
                                                    November 3, 2017
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table> --}}

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>