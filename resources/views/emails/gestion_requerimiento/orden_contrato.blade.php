<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
 <p> Buen día, te informamos que el usuario {{$user_envio}} generó la orden de contratación del candidato {{$candreq->nombres.' '.$candreq->primer_apellido}} con número de identificación {{$candreq->numero_id}}, el cual fue asociado al requerimiento {{$candreq->req_id}} del cliente {{$candreq->nombre_cliente}}, le solicitamos que por favor haga clic en el siguiente enlace para que consulte la orden de contratación del candidato: {{"\n"}}
    <a href="{{route('admin.paquete_contratacion_pdf',['id'=>$req_cand])}}">aqui</a>.</p>
</body>
</html>