<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
    border-collapse:collapse;
    border-spacing:0px;
    table-layout:fixed !important;
    width:100%">
    <tr style="border-collapse:collapse">
        <td align="center" style="padding:0;Margin:0">

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
                    <td align="left" style="Margin:0; padding-top:30px; padding-bottom:30px; padding-left:40px; padding-right:40px">
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
                                            <td align="center" style="padding:0; Margin:0; font-size:0">

                                                <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="
                                                    mso-table-lspace:0pt;
                                                    mso-table-rspace:0pt;
                                                    border-collapse:collapse;
                                                    border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                        {{-- Facebook --}}
                                                        @if($data->configurationTemplate->social_facebook == 1)
                                                            <td valign="top" align="center" style="
                                                                padding:0;
                                                                Margin:0;
                                                                padding-right:10px">
                                                                <a href="#" target="_blank">
                                                                    <img
                                                                        title="Facebook"
                                                                        src="https://img-t3rsc.s3.amazonaws.com/mail-src/facebook.svg"
                                                                        width="20"
                                                                        height="20"
                                                                        style="
                                                                            display:block;
                                                                            border:0;
                                                                            outline:none;
                                                                            text-decoration:none;
                                                                            -ms-interpolation-mode:bicubic"
                                                                    >
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Twitter --}}
                                                        @if($data->configurationTemplate->social_twitter == 1)
                                                            <td valign="top" align="center" style="
                                                                padding:0;
                                                                Margin:0;
                                                                padding-right:10px">
                                                                <a href="#" target="_blank">
                                                                    <img
                                                                        title="Twitter"
                                                                        src="https://img-t3rsc.s3.amazonaws.com/mail-src/twitter.svg"
                                                                        width="20"
                                                                        height="20"
                                                                        style="
                                                                            display:block;
                                                                            border:0;
                                                                            outline:none;
                                                                            text-decoration:none;
                                                                            -ms-interpolation-mode:bicubic"
                                                                    >
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Linkedin --}}
                                                        @if($data->configurationTemplate->social_linkedin == 1)
                                                            <td valign="top" align="center" style="
                                                                padding:0;
                                                                Margin:0;
                                                                padding-right:10px">
                                                                <a href="#" target="_blank">
                                                                    <img
                                                                        title="Linkedin"
                                                                        src="https://img-t3rsc.s3.amazonaws.com/mail-src/linkedin.svg"
                                                                        width="20"
                                                                        height="20"
                                                                        style="
                                                                            display:block;
                                                                            border:0;
                                                                            outline:none;
                                                                            text-decoration:none;
                                                                            -ms-interpolation-mode:bicubic"
                                                                    >
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Instagram --}}
                                                        @if($data->configurationTemplate->social_instagram == 1)
                                                            <td valign="top" align="center" style="
                                                                padding:0;
                                                                Margin:0;
                                                                padding-right:10px">
                                                                <a href="#" target="_blank">
                                                                    <img
                                                                        title="Instagram"
                                                                        src="https://img-t3rsc.s3.amazonaws.com/mail-src/instagram.svg"
                                                                        width="20"
                                                                        height="20"
                                                                        style="
                                                                            display:block;
                                                                            border:0;
                                                                            outline:none;
                                                                            text-decoration:none;
                                                                            -ms-interpolation-mode:bicubic"
                                                                    >
                                                                </a>
                                                            </td>
                                                        @endif

                                                        {{-- Whatsapp --}}
                                                        @if($data->configurationTemplate->social_whatsapp == 1)
                                                            <td valign="top" align="center" style="
                                                                padding:0;
                                                                Margin:0;
                                                                padding-right:10px">
                                                                <a href="#" target="_blank">
                                                                    <img
                                                                        title="Whatsapp"
                                                                        src="https://img-t3rsc.s3.amazonaws.com/mail-src/whatsapp.svg"
                                                                        width="20"
                                                                        height="20"
                                                                        style="
                                                                            display:block;
                                                                            border:0;
                                                                            outline:none;
                                                                            text-decoration:none;
                                                                            -ms-interpolation-mode:bicubic"
                                                                    >
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