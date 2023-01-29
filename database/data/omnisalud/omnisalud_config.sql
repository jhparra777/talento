CREATE TABLE `omnisalud_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sandbox` enum('enabled','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enabled',
  `endpoint_prod` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endpoint_qa` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth_user` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth_pass` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `omnisalud_config` (sandbox,endpoint_prod,endpoint_qa,auth_user,auth_pass,created_at,updated_at) VALUES
	('enabled','https://yga10.com/omnisalud/api/servicios/','http://yeitest.com/omnisalud/api/servicios/','juan@gmail.com','123456','2022-05-22 20:01:11.0','2022-05-22 20:01:11.0');


ALTER TABLE `sitio_modulos` ADD `omnisalud` enum('enabled','disabled') DEFAULT 'disabled' NOT NULL AFTER `consulta_tusdatos`;