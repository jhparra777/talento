<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    </head>
    <body style="background-color: #225ea0; color: #555555; font-family: helvetica; text-align: justify; font-size: 0.9em;">
        <table width="100%" border="0" bgcolor="#f1f1f1" cellspacing="0" cellpadding="0" style="color:#666666;font-family:Segoe UI,Arial,Verdana;font-size:15px">  
            <tbody><tr>  
                    <td>  
                        <table width="700" bgcolor="#ffffff" align="center" style="border:1px solid #cccccc;margin:20px auto;color:#666666;font-family:Segoe UI,Arial,Verdana;font-size:15px">  
                            <tbody>
                                <tr>
                                    <td>
                                        <table border="0" cellspacing="0" cellpadding="0" style="padding:20px">
                                            <tbody><tr>
                                                    <td width="180" valign="top"><a target="_blank" style="margin:0;padding:0" href="{{route("login")}}"><img width="150" border="0" src="{{$message->embed("img/logo_soluciones.png")}}" class="CToWUd"></a></td>
                                                    <td width="500" valign="middle" style="border-top:1px solid #e5e5e5;border-bottom:1px solid #e5e5e5">


                                                    </td>
                                                </tr>
                                            </tbody></table>

                                        <table border="0" cellspacing="0" cellpadding="0" style="padding:20px">
                                            <tbody><tr>
                                                    <td width="160" valign="top" align="right">
                                                        <div style="padding:3px 10px;background:#225ea0;border:1px solid #f1f1f1">
                                                            <font face="Segoe UI,Arial,Verdana" color="#ffffff" style="font-size:20px"><b></b></font>

                                                        </div>
                                                    </td>
                                                    <td width="30" valign="top"></td>
                                                    <td width="490" valign="top" style="padding-top:5px">
                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:15px">
                                                        <p>Hola, {{$data["nombre"]}}</p>
                                                        <p>Estas son nuevas ofertas que se ajustan a tu perfilamiento en Desarrollo.</p>


                                                        @foreach($data["ofertas"] as $oferta)
                                                        <table style="width: 100%;color:#353e4a;font-family:Arial,sans-serif;margin:auto;background-color:#fafafa;border-bottom:1px solid #cccccc">
                                                            <tr>
                                                                <td colspan="2">{{$oferta->descripcion."- ".$oferta->cargo_especifico}}</td>

                                                            </tr>
                                                            <tr>
                                                                <td>{{$oferta->nombre_cliente}}</td>
                                                                <td><a target="_blank" href="{{route("home.detalle_oferta",["oferta_id"=>$oferta->req_id])}}" >Ver Oferta</a></td>
                                                            </tr>
                                                        </table>
                                                        @endforeach



                                                        </font>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellspacing="0" cellpadding="0" style="padding:0 20px 20px">
                                            <tbody><tr>
                                                    <td width="160" valign="top" align="right">
                                                        <div style="padding:3px 10px;background:#225ea0;border:1px solid #f1f1f1">
                                                            <font face="Segoe UI,Arial,Verdana" color="#ffffff" style="font-size:20px"><b>Contáctanos</b></font>
                                                        </div>

                                                    </td>
                                                    <td width="30" valign="top"></td>
                                                    <td width="490" valign="top" style="padding:15px 0;border-top:1px solid #e5e5e5;border-bottom:1px solid #e5e5e5">


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <table border="0" cellspacing="0" cellpadding="0" style="padding:0 20px 20px">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px"><b>Bogotá :</b></font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Transv. 6 No. 27-10 piso 4</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Oficina 401</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Edificio Antares</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">PBX:(1)742 0777</font>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px"><b>Cali :</b></font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Av. 5AN No. 17-98</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Oficinas. 503-504-505</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Edificio Núcleo Profesional</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">PBX:(2)489 7909</font>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px"><b>Medellín :</b></font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Cll 53 No. 45-1112 Piso 1</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Oficina. 1001</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Edificio Colseguros</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">PBX:(4)293 0888</font>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px"><b>Barranquilla :</b></font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Cra 54 No. 74-134</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Oficina. 204</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Edificio centro bancario</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">PBX:(5)368 4714</font>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px"><b>Cartagena :</b></font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">La matuna cll 32 No. 9-45 piso 15</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Oficina 15-03</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Edificio banco del estado</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">PBX:(5)660 0917-6700481</font>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px"><b>Sabana :</b></font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Km 4 Autop. Medellin</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Centro Empresarial san insidro</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">Módulo 3 piso 2</font>
                                                                    </td>
                                                                    <td>
                                                                        <font face="Segoe UI,Arial,Verdana" color="#666666" style="font-size:11px">PBX:(1)896 6616</font>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody></table>                	
                                    </td></tr>  
                            </tbody></table>  
                    </td>  
                </tr>  
            </tbody></table>

    </body>
</html>
