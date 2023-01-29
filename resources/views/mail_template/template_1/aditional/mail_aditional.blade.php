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
                background-color:transparent;
                width:600px" cellspacing="0" cellpadding="0" align="center">
                <tr style="border-collapse:collapse">
                    <td align="left" style="
                        Margin:0;
                        padding-left:20px;
                        padding-right:20px;
                        padding-top:30px;
                        padding-bottom:30px">

                        <table width="100%" cellspacing="0" cellpadding="0" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px">
                            <tr style="border-collapse:collapse">
                                <td valign="top" align="center" style="padding:0; Margin:0; width:560px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td class="es-infoblock made_with" style="
                                                padding:0;
                                                Margin:0;
                                                line-height:120%;
                                                font-size:0;
                                                color:#CCCCCC" align="center">
                                                <p style="-webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    font-size:12px;
                                                    margin-bottom: 1.5rem;
                                                    color:#666666">
                                                    <b>Esta es una notificación automática, por favor NO RESPONDA este mensaje.</b>
                                                </p>
                                            </td>
                                        </tr>

                                        <tr style="border-collapse:collapse">
                                            {{-- 
                                                <td class="es-infoblock made_with" style="
                                                    padding:0;
                                                    Margin:0;
                                                    line-height:120%;
                                                    font-size:0;
                                                    color:#CCCCCC" align="center">
                                                    <a target="_blank" href="https://t3rsc.co" style="
                                                        -webkit-text-size-adjust:none;
                                                        -ms-text-size-adjust:none;
                                                        mso-line-height-rule:exactly;
                                                        font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                        font-size:12px;
                                                        text-decoration:none;
                                                        color:#CCCCCC">
                                                        <img 
                                                            src="{{ $data->configurationTemplate->imagen_sub_footer }}" 
                                                            alt 
                                                            width="125" 
                                                            style="
                                                                display:block;
                                                                border:0;
                                                                outline:none;
                                                                text-decoration:none;
                                                                -ms-interpolation-mode:bicubic;
                                                                filter: grayscale(100%);"
                                                        >
                                                    </a>
                                                </td>
                                             --}}
                                            <td class="es-infoblock made_with" style="
                                                padding:0;
                                                Margin:0;
                                                line-height:120%;
                                                font-size:0;
                                                color:#CCCCCC" align="center">
                                                <a 
                                                    target="_blank" 
                                                    class="unsubscribe" 
                                                    href="{{ route('cancelar_suscripcion', ['user_id' => \Crypt::encrypt($data->userId)]) }}" 
                                                    style="
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;
                                                    font-size:12px;
                                                    text-decoration:underline;
                                                    color:#666666">
                                                    Cancelar suscripción a correos
                                                </a>
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