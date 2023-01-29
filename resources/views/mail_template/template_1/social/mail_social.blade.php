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
                width:600px;
                border-bottom:10px solid {{ $data->configurationTemplate->color_principal }}" 
                cellspacing="0" 
                cellpadding="0" 
                bgcolor="{{ $data->configurationTemplate->color_secundario }}" 
                align="center"
            >
                <tr style="border-collapse:collapse">
                    <td align="left" style="padding:0;Margin:0">

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
                                            <td style="padding:0;Margin:0">

                                                <!-- Lista de redes sociales del correo -->
                                                <table class="es-menu" width="40%" cellspacing="0" cellpadding="0" align="center" role="presentation" style="
                                                    mso-table-lspace:0pt;
                                                    mso-table-rspace:0pt;
                                                    border-collapse:collapse;
                                                    border-spacing:0px">
                                                    <tr class="links-images-top" style="border-collapse:collapse">
                                                        {{-- Facebook --}}
                                                        @if($data->configurationTemplate->social_facebook == 1)
                                                            <td style="
                                                                Margin:0;
                                                                padding-left:5px;
                                                                padding-right:5px;
                                                                padding-top:35px;
                                                                padding-bottom:30px;
                                                                border:0" width="20%" bgcolor="transparent" align="center">
                                                                <a target="_blank" style="
                                                                    -webkit-text-size-adjust:none;
                                                                    -ms-text-size-adjust:none;
                                                                    mso-line-height-rule:exactly;
                                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                                    font-size:24px;
                                                                    text-decoration:none;
                                                                    display:block;
                                                                    color:#FFFFFF" href="#">
                                                                    {{-- <i class="fab fa-facebook-f"></i> --}}
                                                                    <img src="https://img-t3rsc.s3.amazonaws.com/mail-src/facebook.svg" alt="Facebook" width="20">
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Twitter --}}
                                                        @if($data->configurationTemplate->social_twitter == 1)
                                                            <td style="
                                                                Margin:0;
                                                                padding-left:5px;
                                                                padding-right:5px;
                                                                padding-top:35px;
                                                                padding-bottom:30px;
                                                                border:0" width="20%" bgcolor="transparent" align="center">
                                                                <a target="_blank" style="
                                                                    -webkit-text-size-adjust:none;
                                                                    -ms-text-size-adjust:none;
                                                                    mso-line-height-rule:exactly;
                                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                                    font-size:24px;
                                                                    text-decoration:none;
                                                                    display:block;
                                                                    color:#FFFFFF" href="#">
                                                                    {{-- <i class="fab fa-twitter"></i> --}}
                                                                    <img src="https://img-t3rsc.s3.amazonaws.com/mail-src/twitter.svg" alt="Twitter" width="20">
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Linkedin --}}
                                                        @if($data->configurationTemplate->social_linkedin == 1)
                                                            <td style="
                                                                Margin:0;
                                                                padding-left:5px;
                                                                padding-right:5px;
                                                                padding-top:35px;
                                                                padding-bottom:30px;
                                                                border:0" width="20%" bgcolor="transparent" align="center">
                                                                <a target="_blank" style="
                                                                    -webkit-text-size-adjust:none;
                                                                    -ms-text-size-adjust:none;
                                                                    mso-line-height-rule:exactly;
                                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                                    font-size:24px;
                                                                    text-decoration:none;
                                                                    display:block;
                                                                    color:#FFFFFF" href="#">
                                                                    {{-- <i class="fab fa-linkedin-in"></i> --}}
                                                                    <img src="https://img-t3rsc.s3.amazonaws.com/mail-src/linkedin.svg" alt="LinkedIn" width="20">
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Instagram --}}
                                                        @if($data->configurationTemplate->social_instagram == 1)
                                                            <td style="
                                                                Margin:0;
                                                                padding-left:5px;
                                                                padding-right:5px;
                                                                padding-top:35px;
                                                                padding-bottom:30px;
                                                                border:0" width="20%" bgcolor="transparent" align="center">
                                                                <a target="_blank" style="
                                                                    -webkit-text-size-adjust:none;
                                                                    -ms-text-size-adjust:none;
                                                                    mso-line-height-rule:exactly;
                                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                                    font-size:24px;
                                                                    text-decoration:none;
                                                                    display:block;
                                                                    color:#FFFFFF" href="#">
                                                                    {{-- <i class="fab fa-instagram"></i> --}}
                                                                    <img src="https://img-t3rsc.s3.amazonaws.com/mail-src/instagram.svg" alt="Instagram" width="20">
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Whatsapp --}}
                                                        @if($data->configurationTemplate->social_whatsapp == 1)
                                                            <td style="
                                                                Margin:0;
                                                                padding-left:5px;
                                                                padding-right:5px;
                                                                padding-top:35px;
                                                                padding-bottom:30px;
                                                                border:0" width="20%" bgcolor="transparent" align="center">
                                                                <a target="_blank" style="
                                                                    -webkit-text-size-adjust:none;
                                                                    -ms-text-size-adjust:none;
                                                                    mso-line-height-rule:exactly;
                                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                                    font-size:24px;
                                                                    text-decoration:none;
                                                                    display:block;
                                                                    color:#FFFFFF" href="#">
                                                                    {{-- <i class="fab fa-whatsapp"></i> --}}
                                                                    <img src="https://img-t3rsc.s3.amazonaws.com/mail-src/whatsapp.svg" alt="Whatsapp" width="20">
                                                                </a>
                                                            </td>
                                                        @endif
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

        </td>
    </tr>
</table>