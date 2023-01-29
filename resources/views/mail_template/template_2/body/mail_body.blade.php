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
                    <td align="left" style="padding:0; Margin:0; padding-top:40px; padding-left:40px; padding-right:40px">

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
                                            <td align="left" style="
                                                padding:0;
                                                Margin:0;
                                                padding-top:5px;
                                                padding-bottom:15px">
                                                <h2 style="
                                                    Margin:0;
                                                    line-height:24px;
                                                    mso-line-height-rule:exactly;
                                                    font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;
                                                    font-size:20px;
                                                    font-style:normal;
                                                    font-weight:bold;
                                                    color:#333333">
                                                    {!! $data->mailTitle !!}
                                                </h2>
                                            </td>
                                        </tr>

                                        {{-- <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0; padding-bottom:10px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:15px;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    line-height:23px;
                                                    color:#555555">
                                                    <strong>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                                    </strong>
                                                </p>
                                            </td>
                                        </tr> --}}

                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="
                                                padding:0;
                                                Margin:0;
                                                padding-top:10px;
                                                padding-bottom:10px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:15px;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    line-height:23px;
                                                    color:#555555;
                                                    text-align: justify;">
                                                    {!! $data->mailBody !!}
                                                </p>

                                                <br>
                                            </td>
                                        </tr>

                                        {{-- Botón del correo --}}
                                        @if(!empty($data->mailButton))
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="
                                                    padding:0;
                                                    Margin:0;
                                                    padding-top:10px;
                                                    padding-bottom:10px;
                                                    text-align: center;">
                                                    
                                                        <span class="es-button-border" style="
                                                            border-style:solid;
                                                            border-color:{{ $data->configurationTemplate->color_principal }};
                                                            background:#FFFFFF none repeat scroll 0% 0%;
                                                            border-width:0px;
                                                            display:inline-block;
                                                            border-radius:50px;
                                                            width:auto">

                                                            <a href="{{ $data->mailButton->buttonRoute }}" class="es-button" target="_blank" style="
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
                                                                {{ $data->mailButton->buttonText }}
                                                            </a>

                                                        </span>

                                                    <br>
                                                    <br>
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0; padding-top:10px; padding-bottom:10px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:15px;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    line-height:23px;
                                                    color:#555555">
                                                    Yours sincerely,
                                                </p>
                                            </td>
                                        </tr> --}}

                                    </table>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                {{-- <tr style="border-collapse:collapse">
                    <td align="left" style="Margin:0; padding-top:10px; padding-bottom:40px; padding-left:40px; padding-right:40px">

                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px;
                            float:left">
                            <tr style="border-collapse:collapse">
                                <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0; Margin:0; width:40px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0; font-size:0">
                                                <img src="https://eupjaq.stripocdn.email/content/guids/CABINET_85e4431b39e3c4492fca561009cef9b5/images/29241521207598269.jpg" alt style="
                                                    display:block;
                                                    border:0;
                                                    outline:none;
                                                    text-decoration:none;
                                                    -ms-interpolation-mode:bicubic" width="40" height="40">
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <table cellspacing="0" cellpadding="0" align="right" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px">
                            <tr style="border-collapse:collapse">
                                <td align="left" style="padding:0; Margin:0; width:460px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0; Margin:0; padding-top:10px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:14px;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    line-height:21px;
                                                    color:#222222">
                                                    <strong>Anna Bella</strong>
                                                    <br>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0;Margin:0">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:14px;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    line-height:21px;
                                                    color:#666666">
                                                    CEO | Vision
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr> --}}
            </table>

        </td>
    </tr>
</table>