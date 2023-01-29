-- db_dev.omnisalud_clientes definition

CREATE TABLE `omnisalud_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_logo_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `omnisalud_clientes` (`descripcion`, `empresa_logo_id`, `active`, `created_at`, `updated_at`)
VALUES ('T3RS', 1, 1, current_timestamp(), current_timestamp());

