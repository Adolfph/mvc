
/**
 * Author:  Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 * Created: 13 sep. 2021
 */
CREATE DATABASE  IF NOT EXISTS `bd_menus` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `bd_menus`;

DROP TABLE IF EXISTS `app_menus`;
CREATE TABLE `app_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_menu_padre` int(11) DEFAULT NULL,
  `fecha_de_registro` datetime NOT NULL,
  `fecha_de_edicion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

