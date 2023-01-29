CREATE TABLE `omnisalud_ciudades_atencion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Planes de atención';

INSERT INTO `omnisalud_ciudades_atencion` (codigo,descripcion,active,created_at,updated_at) VALUES
	 ('MEDELLIN','MEDELLIN',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('BOGOTA','BOGOTA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('CALI','CALI',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('PALMIRA','PALMIRA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('BARRANCABERMEJA','BARRANCABERMEJA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('PEREIRA','PEREIRA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('IBAGUE','IBAGUE',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('RIONEGRO','RIONEGRO',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('SOACHA','SOACHA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('BARRANQUILLA','BARRANQUILLA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0'),
	 ('CARTAGENA','CARTAGENA',1,'2022-05-20 17:51:15.0','2022-05-20 17:51:15.0');
