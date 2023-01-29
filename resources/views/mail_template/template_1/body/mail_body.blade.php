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
                    <td align="left" style="
                        Margin:0;
                        padding-bottom:25px;
                        padding-top:35px;
                        padding-left:35px;
                        padding-right:35px">

                        <table width="100%" cellspacing="0" cellpadding="0" style="
                            mso-table-lspace:0pt;
                            mso-table-rspace:0pt;
                            border-collapse:collapse;
                            border-spacing:0px">
                            <tr style="border-collapse:collapse">
                                <td valign="top" align="center" style="padding:0; Margin:0; width:530px">

                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="
                                        mso-table-lspace:0pt;
                                        mso-table-rspace:0pt;
                                        border-collapse:collapse;
                                        border-spacing:0px">
                                        {{-- Titulo o tema del correo --}}
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="
                                                padding:0;
                                                Margin:0;
                                                padding-bottom:5px;
                                                padding-top:20px">
                                                <h3 style="
                                                    Margin:0;
                                                    line-height:22px;
                                                    mso-line-height-rule:exactly;
                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                    font-size:18px;
                                                    font-style:normal;
                                                    font-weight:bold;
                                                    color:black">
                                                    {!! $data->mailTitle !!}
                                                </h3>
                                            </td>
                                        </tr>
                                        {{-- Cuerpo o contenido del correo --}}
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0;Margin:0;padding-bottom:10px;padding-top:15px">
                                                <p style="
                                                    Margin:0;
                                                    -webkit-text-size-adjust:none;
                                                    -ms-text-size-adjust:none;
                                                    mso-line-height-rule:exactly;
                                                    font-size:16px;
                                                    font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;
                                                    line-height:24px;
                                                    color:#777777;
                                                    text-align: justify;">
                                                    {!! $data->mailBody !!}
                                                </p>
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