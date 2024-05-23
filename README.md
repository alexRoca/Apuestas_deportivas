Para el acceso a la aplicacion  usar los siguientes usuarios:

USUARIO 01
-------------
correo :alexander.roca@correo.com 
clave : clave_prueba_123


USUARIO 02
-------------
correo : usuario_prueba@correo.com
clave : usuario_prueba.123


Esquema de Base de datos:

![ScreenShot_20240523103305](https://github.com/alexRoca/Apuestas_deportivas/assets/57385171/682dfd59-641d-4a65-9fad-994e635c0583)

Diagrama de flujo :

![ScreenShot_20240523143131](https://github.com/alexRoca/Apuestas_deportivas/assets/57385171/7991c06d-b5f2-4b0c-86f5-2903deed2ae2)

#################################################################################

Script de base de datos:
--------------------------------

[Upload-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-05-2024 a las 19:56:14
-- Versión del servidor: 8.0.21
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apuestatotal_prueba`
--
CREATE DATABASE IF NOT EXISTS `apuestatotal_prueba` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `apuestatotal_prueba`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_get_bank_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_bank_v1` ()  BEGIN	
	
	SELECT 
	t1.id_bank,
	t1.bank 
	FROM t_bank t1;

END$$

DROP PROCEDURE IF EXISTS `sp_get_channel_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_channel_v1` ()  BEGIN	
	
	SELECT 
	t1.id_channel,
	t1.channel  
	FROM t_channel t1;

END$$

DROP PROCEDURE IF EXISTS `sp_get_customer_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_customer_v1` (`p_PlayerID` BIGINT UNSIGNED, `p_document` INT, `p_first_name` VARCHAR(255), `p_last_name` VARCHAR(255))  BEGIN		
	
	SELECT 
	t1.PlayerID, 
	t1.document, 
	t1.first_name, 
	t1.last_name, 
	t1.id_users_modified, 
	t1.timestamp_modified 
	FROM t_customer t1
	WHERE IF(p_PlayerID = 0, 1 = 1, t1.PlayerID = p_PlayerID)
	AND IF(p_document = 0, 1 = 1, t1.document = p_document)
	AND IF(p_first_name = '', 1 = 1, t1.first_name = p_first_name)
	AND IF(p_last_name = '', 1 = 1, t1.last_name = p_last_name);

END$$

DROP PROCEDURE IF EXISTS `sp_get_customer_wallets_movements_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_customer_wallets_movements_v1` (`p_PlayerID` BIGINT UNSIGNED)  BEGIN	
	
	SELECT 
	t2.customer_wallet_movement_type,
	t1.id_recharge,
	t1.amount,
	CONCAT(t3.first_name, ' ', t3.last_name) name_user,
	t1.timestamp_created 
	FROM t_customer_wallets_movements t1
	INNER JOIN t_customer_wallets_movements_types t2 ON t2.id_customer_wallets_movements_types = t1.id_customer_wallets_movements_types 
	INNER JOIN t_users t3 ON t3.id_users = t1.id_users_created 
	WHERE t1.id_customer = p_PlayerID
	ORDER BY t1.timestamp_created DESC;

END$$

DROP PROCEDURE IF EXISTS `sp_get_customer_wallets_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_customer_wallets_v1` (`p_PlayerID` BIGINT UNSIGNED)  BEGIN	
	
	SELECT 
	t1.amount 
	FROM t_customer_wallets t1
	WHERE t1.id_customer = p_PlayerID;

END$$

DROP PROCEDURE IF EXISTS `sp_get_recharge_cancel_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_recharge_cancel_v1` (`p_PlayerID` BIGINT UNSIGNED)  BEGIN		
	
	SELECT 
	t1.id_recharge,
	t2.amount,
	t1.motive,
	CONCAT(t3.first_name, ' ', t3.last_name) name_user,
	t1.timestamp_created
	FROM t_recharge_cancel t1
	INNER JOIN t_recharge t2 ON t2.id_recharge = t1.id_recharge 
	INNER JOIN t_users t3 ON t3.id_users = t1.id_users_created 
	WHERE t2.id_customer = p_PlayerID
	ORDER BY t1.timestamp_created DESC;

END$$

DROP PROCEDURE IF EXISTS `sp_get_recharge_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_recharge_v1` (`p_PlayerID` BIGINT UNSIGNED)  BEGIN	
	
	SELECT 
	t1.id_recharge,
	t4.status,
	t1.id_status,
	t1.id_bank,
	t1.id_channel,
	t1.amount,
	t1.image,
	t2.bank,
	CONCAT(t5.first_name, ' ', t5.last_name) name_user,
	t3.channel,
	t1.timestamp_created,
	t1.timestamp_modified 
	FROM t_recharge t1
	INNER JOIN t_bank t2 ON t2.id_bank = t1.id_bank 
	INNER JOIN t_channel t3 ON t3.id_channel = t1.id_channel 
	INNER JOIN t_status t4 ON t4.id_status = t1.id_status 
	INNER JOIN t_users t5 ON t5.id_users = t1.id_users_modified 
	WHERE t1.id_customer = p_PlayerID
	ORDER BY t1.timestamp_modified DESC;

END$$

DROP PROCEDURE IF EXISTS `sp_get_user_login_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_login_v1` (`p_email` BIGINT UNSIGNED, `p_password` VARCHAR(255))  BEGIN	
	
DECLARE v_id_users BIGINT UNSIGNED;
DECLARE v_first_name VARCHAR(255);
DECLARE v_last_name VARCHAR(255);

IF IFNULL(p_email, '') <> '' AND IFNULL(p_password, '') <> '' THEN

	SELECT 
	t1.id_users, 
	t1.first_name, 
	t1.last_name 
	INTO 
	v_id_users,
	v_first_name,
	v_last_name
	FROM t_users t1
	WHERE t1.email = p_email
	AND t1.password = MD5(p_password);

	IF v_id_users IS NOT NULL THEN
	
		SELECT 
		'true' success, 
		'Se inicio con exito la sesión.' msg, 
		v_id_users id_users,
		v_first_name first_name,
		v_last_name last_name;
	
	ELSE
	
		SELECT 'false' success, 'Los datos no coinciden.' msg;
	
	END IF;

ELSE

	SELECT 'false' success, 'Se cargaron productos no validas.' msg;

END IF;

END$$

DROP PROCEDURE IF EXISTS `sp_post_recharge_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_post_recharge_v1` (`p_id_customer` BIGINT UNSIGNED, `p_id_bank` BIGINT UNSIGNED, `p_id_channel` BIGINT UNSIGNED, `p_amount` DECIMAL(10,2), `p_id_users` BIGINT UNSIGNED)  BEGIN	
	
	INSERT INTO t_recharge (
	id_recharge,
	id_customer,
	id_status,
	id_bank,
	id_channel,
	id_users_created,
	id_users_modified,
	amount,
	image
	)VALUES(
		genera_id(),
		p_id_customer,
		1,
		p_id_bank,
		p_id_channel,
		p_id_users,
		p_id_users,
		p_amount,
		''
	);

END$$

DROP PROCEDURE IF EXISTS `sp_set_anular_recharge_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_set_anular_recharge_v1` (`p_id_recharge` BIGINT UNSIGNED, `p_id_users` BIGINT UNSIGNED, `p_motive` VARCHAR(255))  BEGIN	
	
	DECLARE v_id_customer BIGINT UNSIGNED;
	DECLARE v_amount DECIMAL(10,2);
	DECLARE v_id_status INT;

	SELECT 
	t1.id_customer,
	t1.amount,
	t1.id_status 
	INTO
	v_id_customer,
	v_amount,
	v_id_status
	FROM t_recharge t1
	WHERE t1.id_recharge = p_id_recharge;

	IF v_id_status = 2 THEN
	
		INSERT INTO t_customer_wallets_movements (
		id_customer_wallets_movements,
		id_customer_wallets_movements_types,
		id_customer,
		id_recharge,
		amount,
		id_users_created 
		)VALUES(
			genera_id(),
			-2,
			v_id_customer,
			p_id_recharge,
			- v_amount,
			p_id_users
		);
	
		UPDATE t_customer_wallets t1 
		SET 
		t1.amount = t1.amount - v_amount
		WHERE t1.id_customer = v_id_customer;

	END IF;

	UPDATE t_recharge t1 
	SET
	t1.id_status = -1
	WHERE t1.id_recharge = p_id_recharge;

	INSERT INTO t_recharge_cancel (
	id_recharge,
	id_users_created, 
	motive
	)VALUES(
		p_id_recharge,
		p_id_users,
		p_motive
	);

END$$

DROP PROCEDURE IF EXISTS `sp_set_asignar_recharge_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_set_asignar_recharge_v1` (`p_id_recharge` BIGINT UNSIGNED, `p_id_users` BIGINT UNSIGNED)  BEGIN	
	
	DECLARE v_id_customer BIGINT UNSIGNED;
	DECLARE v_amount DECIMAL(10, 2);

	SELECT 
	t1.id_customer,
	t1.amount 
	INTO
	v_id_customer,
	v_amount
	FROM t_recharge t1
	WHERE t1.id_recharge = p_id_recharge;

	INSERT INTO t_customer_wallets_movements (
	id_customer_wallets_movements,
	id_customer_wallets_movements_types,
	id_customer,
	id_recharge,
	amount,
	id_users_created 
	)VALUES(
		genera_id(),
		1,
		v_id_customer,
		p_id_recharge,
		v_amount,
		p_id_users
	);

	UPDATE t_recharge t1 
	SET
	t1.id_status = 2
	WHERE t1.id_recharge = p_id_recharge;

	UPDATE t_customer_wallets t1 
	SET 
	t1.amount = t1.amount + v_amount
	WHERE t1.id_customer = v_id_customer;

END$$

DROP PROCEDURE IF EXISTS `sp_set_editar_recharge_v1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_set_editar_recharge_v1` (`p_id_recharge` BIGINT UNSIGNED, `p_id_users` BIGINT UNSIGNED, `p_id_bank` BIGINT UNSIGNED, `p_id_channel` BIGINT UNSIGNED, `p_amount` DECIMAL(10,2))  BEGIN	
	
	DECLARE v_id_customer BIGINT UNSIGNED;
	DECLARE v_amount DECIMAL(10,2);
	DECLARE v_id_status INT;

	SELECT 
	t1.id_customer,
	t1.amount,
	t1.id_status 
	INTO
	v_id_customer,
	v_amount,
	v_id_status
	FROM t_recharge t1
	WHERE t1.id_recharge = p_id_recharge;

	UPDATE t_recharge t1 
	SET
	t1.amount = CAST(p_amount AS DECIMAL(10, 2)),
	t1.id_bank = p_id_bank,
	t1.id_channel = p_id_channel
	WHERE t1.id_recharge = p_id_recharge;

	IF v_id_status = 2 THEN
	
		INSERT INTO t_customer_wallets_movements (
		id_customer_wallets_movements,
		id_customer_wallets_movements_types,
		id_customer,
		id_recharge,
		amount,
		id_users_created 
		)VALUES(
			genera_id(),
			-1,
			v_id_customer,
			p_id_recharge,
			- v_amount,
			p_id_users
		);
	
		INSERT INTO t_customer_wallets_movements (
		id_customer_wallets_movements,
		id_customer_wallets_movements_types,
		id_customer,
		id_recharge,
		amount,
		id_users_created 
		)VALUES(
			genera_id(),
			2,
			v_id_customer,
			p_id_recharge,
			p_amount,
			p_id_users
		);
	
		UPDATE t_customer_wallets t1 
		SET 
		t1.amount = t1.amount - v_amount + p_amount
		WHERE t1.id_customer = v_id_customer;

	END IF;

END$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `genera_id`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `genera_id` () RETURNS BIGINT UNSIGNED BEGIN
RETURN (((SYSDATE() + 0) * 100000) + MOD(UUID_SHORT(), 100000));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_bank`
--

DROP TABLE IF EXISTS `t_bank`;
CREATE TABLE IF NOT EXISTS `t_bank` (
  `id_bank` int NOT NULL,
  `bank` varchar(255) NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_bank`),
  KEY `t_bank_bank_IDX` (`bank`) USING BTREE,
  KEY `t_bank_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_bank_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_bank`
--

INSERT INTO `t_bank` (`id_bank`, `bank`, `timestamp_created`) VALUES
(1, 'BCP', '2024-05-22 23:35:11.395639'),
(2, 'BBVA', '2024-05-22 23:35:34.816946'),
(3, 'INTERBANK', '2024-05-22 23:35:34.833292'),
(4, 'SCOTIABANK', '2024-05-22 23:35:54.427656');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_channel`
--

DROP TABLE IF EXISTS `t_channel`;
CREATE TABLE IF NOT EXISTS `t_channel` (
  `id_channel` int NOT NULL,
  `channel` varchar(255) NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_channel`),
  KEY `t_channel_channel_IDX` (`channel`) USING BTREE,
  KEY `t_channel_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_channel_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_channel`
--

INSERT INTO `t_channel` (`id_channel`, `channel`, `timestamp_created`) VALUES
(1, 'WhatsApp', '2024-05-22 23:29:06.294999'),
(2, 'TeleGram', '2024-05-22 23:29:18.894396'),
(3, 'FB Messenger', '2024-05-22 23:29:18.894396');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_customer`
--

DROP TABLE IF EXISTS `t_customer`;
CREATE TABLE IF NOT EXISTS `t_customer` (
  `PlayerID` bigint UNSIGNED NOT NULL,
  `document` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `id_users_created` bigint UNSIGNED NOT NULL,
  `id_users_modified` bigint UNSIGNED NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`PlayerID`),
  UNIQUE KEY `t_customer_un` (`document`),
  KEY `t_customer_first_name_IDX` (`first_name`) USING BTREE,
  KEY `t_customer_last_name_IDX` (`last_name`) USING BTREE,
  KEY `t_customer_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_customer_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE,
  KEY `t_customer_FK` (`id_users_created`),
  KEY `t_customer_FK_1` (`id_users_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_customer`
--

INSERT INTO `t_customer` (`PlayerID`, `document`, `first_name`, `last_name`, `id_users_created`, `id_users_modified`, `timestamp_created`) VALUES
(2024052202115998372, 12345678, 'Roberto', 'Ruiz Martines', 2024052201133098371, 2024052201133098371, '2024-05-22 07:11:59.616585'),
(2024052202145598375, 52145678, 'Carlos Fernando', 'Ramirez Suga', 2024052201133098371, 2024052201133098371, '2024-05-22 07:14:55.711121'),
(2024052202201698377, 1452635, 'Diana Ester', 'Fernandez Perez', 2024052202162098376, 2024052202162098376, '2024-05-22 07:20:16.710218');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_customer_wallets`
--

DROP TABLE IF EXISTS `t_customer_wallets`;
CREATE TABLE IF NOT EXISTS `t_customer_wallets` (
  `id_customer` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_customer_wallets`
--

INSERT INTO `t_customer_wallets` (`id_customer`, `amount`, `timestamp_created`) VALUES
(2024052202115998372, '12.00', '2024-05-23 02:27:11.167023'),
(2024052202145598375, '50.00', '2024-05-23 02:27:24.687522'),
(2024052202201698377, '0.00', '2024-05-23 02:27:49.354555');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_customer_wallets_movements`
--

DROP TABLE IF EXISTS `t_customer_wallets_movements`;
CREATE TABLE IF NOT EXISTS `t_customer_wallets_movements` (
  `id_customer_wallets_movements` bigint UNSIGNED NOT NULL,
  `id_customer_wallets_movements_types` int NOT NULL,
  `id_customer` bigint UNSIGNED NOT NULL,
  `id_recharge` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_users_created` bigint UNSIGNED NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_customer_wallets_movements`),
  KEY `t_users_wallets_movements_FK2` (`id_customer`),
  KEY `t_users_wallets_movements_FK_11` (`id_users_created`),
  KEY `t_users_wallets_movements_FK` (`id_customer_wallets_movements_types`),
  KEY `t_users_wallets_movements_amount_IDX` (`amount`) USING BTREE,
  KEY `t_users_wallets_movements_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_users_wallets_movements_FK_1` (`id_recharge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_customer_wallets_movements`
--

INSERT INTO `t_customer_wallets_movements` (`id_customer_wallets_movements`, `id_customer_wallets_movements_types`, `id_customer`, `id_recharge`, `amount`, `id_users_created`, `timestamp_created`) VALUES
(2024052310343239675, 1, 2024052202145598375, 2024052310342639673, '20.00', 2024052201133098371, '2024-05-23 15:34:32.897537'),
(2024052310353039676, -1, 2024052202145598375, 2024052310342639673, '-20.00', 2024052201133098371, '2024-05-23 15:35:30.277806'),
(2024052310353039677, 2, 2024052202145598375, 2024052310342639673, '25.00', 2024052201133098371, '2024-05-23 15:35:30.280856'),
(2024052310363639679, -2, 2024052202145598375, 2024052310342639673, '-25.00', 2024052201133098371, '2024-05-23 15:36:36.813952'),
(2024052310364539680, 1, 2024052202145598375, 2024052310354139678, '50.00', 2024052201133098371, '2024-05-23 15:36:45.880156'),
(2024052310372939683, 1, 2024052202115998372, 2024052310371739681, '12.00', 2024052201133098371, '2024-05-23 15:37:29.112490'),
(2024052310435839685, 1, 2024052202115998372, 2024052310435739684, '1.00', 2024052201133098371, '2024-05-23 15:43:58.886538'),
(2024052310442239687, -2, 2024052202115998372, 2024052310435739684, '-1.00', 2024052201133098371, '2024-05-23 15:44:22.666616');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_customer_wallets_movements_types`
--

DROP TABLE IF EXISTS `t_customer_wallets_movements_types`;
CREATE TABLE IF NOT EXISTS `t_customer_wallets_movements_types` (
  `id_customer_wallets_movements_types` int NOT NULL,
  `customer_wallet_movement_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_customer_wallets_movements_types`),
  KEY `t_users_wallets_movements_types_user_wallet_movement_type_IDX` (`customer_wallet_movement_type`) USING BTREE,
  KEY `t_users_wallets_movements_types_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_users_wallets_movements_types_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_customer_wallets_movements_types`
--

INSERT INTO `t_customer_wallets_movements_types` (`id_customer_wallets_movements_types`, `customer_wallet_movement_type`, `timestamp_created`) VALUES
(-2, 'anulacion de recarga', '2024-05-22 22:51:09.341477'),
(-1, 'ajuste de recarga - negativo', '2024-05-22 22:52:31.097938'),
(1, 'recarga asignada', '2024-05-22 22:50:53.598504'),
(2, 'ajuste de recarga - positivo', '2024-05-22 22:51:32.920499');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_recharge`
--

DROP TABLE IF EXISTS `t_recharge`;
CREATE TABLE IF NOT EXISTS `t_recharge` (
  `id_recharge` bigint UNSIGNED NOT NULL,
  `id_customer` bigint UNSIGNED NOT NULL,
  `id_status` int NOT NULL,
  `id_bank` int NOT NULL,
  `id_channel` int NOT NULL,
  `id_users_created` bigint UNSIGNED NOT NULL,
  `id_users_modified` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_recharge`),
  KEY `t_recharge_FK` (`id_users_created`),
  KEY `t_recharge_FK_1` (`id_users_modified`),
  KEY `t_recharge_amount_IDX` (`amount`) USING BTREE,
  KEY `t_recharge_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_recharge_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE,
  KEY `t_recharge_FK_2` (`id_customer`),
  KEY `t_recharge_FK_3` (`id_status`),
  KEY `t_recharge_FK_4` (`id_channel`),
  KEY `t_recharge_image_IDX` (`image`) USING BTREE,
  KEY `t_recharge_FK_5` (`id_bank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_recharge`
--

INSERT INTO `t_recharge` (`id_recharge`, `id_customer`, `id_status`, `id_bank`, `id_channel`, `id_users_created`, `id_users_modified`, `amount`, `image`, `timestamp_created`) VALUES
(2024052310342639673, 2024052202145598375, -1, 2, 3, 2024052201133098371, 2024052201133098371, '25.00', '', '2024-05-23 15:34:26.011328'),
(2024052310343139674, 2024052202145598375, -1, 2, 3, 2024052201133098371, 2024052201133098371, '4.00', '', '2024-05-23 15:34:31.320968'),
(2024052310354139678, 2024052202145598375, 2, 2, 3, 2024052201133098371, 2024052201133098371, '50.00', '', '2024-05-23 15:35:41.660734'),
(2024052310371739681, 2024052202115998372, 2, 2, 3, 2024052201133098371, 2024052201133098371, '12.00', '', '2024-05-23 15:37:17.273032'),
(2024052310372439682, 2024052202115998372, -1, 2, 3, 2024052201133098371, 2024052201133098371, '30.80', '', '2024-05-23 15:37:24.612235'),
(2024052310435739684, 2024052202115998372, -1, 2, 3, 2024052201133098371, 2024052201133098371, '1.00', '', '2024-05-23 15:43:57.062523'),
(2024052310440439686, 2024052202115998372, 1, 2, 3, 2024052201133098371, 2024052201133098371, '20.00', '', '2024-05-23 15:44:04.233948');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_recharge_cancel`
--

DROP TABLE IF EXISTS `t_recharge_cancel`;
CREATE TABLE IF NOT EXISTS `t_recharge_cancel` (
  `id_recharge` bigint UNSIGNED NOT NULL,
  `motive` varchar(255) NOT NULL,
  `id_users_created` bigint UNSIGNED NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_recharge`),
  KEY `t_recharge_cancel_motive_IDX` (`motive`) USING BTREE,
  KEY `t_recharge_cancel_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_recharge_cancel_id_users_created_IDX` (`id_users_created`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_recharge_cancel`
--

INSERT INTO `t_recharge_cancel` (`id_recharge`, `motive`, `id_users_created`, `timestamp_created`) VALUES
(2024052310342639673, 'cliente ya no desea el saldo de esta recarga', 2024052201133098371, '2024-05-23 15:36:36.832519'),
(2024052310343139674, 'recarga con error', 2024052201133098371, '2024-05-23 15:35:59.239932'),
(2024052310372439682, 'error con el vaucher', 2024052201133098371, '2024-05-23 15:38:06.106122'),
(2024052310435739684, 'error', 2024052201133098371, '2024-05-23 15:44:22.679096');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_status`
--

DROP TABLE IF EXISTS `t_status`;
CREATE TABLE IF NOT EXISTS `t_status` (
  `id_status` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_status`),
  KEY `t_status_status_IDX` (`status`) USING BTREE,
  KEY `t_status_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_status_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_status`
--

INSERT INTO `t_status` (`id_status`, `status`, `timestamp_created`) VALUES
(-1, 'Anulada', '2024-05-22 23:20:26.891931'),
(1, 'Creada', '2024-05-22 23:20:40.554398'),
(2, 'Asignada', '2024-05-22 23:20:56.836615');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_users`
--

DROP TABLE IF EXISTS `t_users`;
CREATE TABLE IF NOT EXISTS `t_users` (
  `id_users` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp_created` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `timestamp_modified` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `t_users_un` (`email`),
  KEY `t_users_first_name_IDX` (`first_name`) USING BTREE,
  KEY `t_users_last_name_IDX` (`last_name`) USING BTREE,
  KEY `t_users_password_IDX` (`password`) USING BTREE,
  KEY `t_users_timestamp_created_IDX` (`timestamp_created`) USING BTREE,
  KEY `t_users_timestamp_modified_IDX` (`timestamp_modified`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `t_users`
--

INSERT INTO `t_users` (`id_users`, `first_name`, `last_name`, `email`, `password`, `timestamp_created`) VALUES
(2024052201133098371, 'Alexander Lennin', 'Roca Vidal', 'alexander.roca@correo.com', '928cd286b691fca69f16216c80d450c6', '2024-05-22 06:13:30.441150'),
(2024052202162098376, 'Nombre prueba', 'Apellido prueba', 'usuario_prueba@correo.com', 'a9b1a7fee415902e6b289d009d2aa907', '2024-05-22 07:16:20.119406');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t_customer`
--
ALTER TABLE `t_customer`
  ADD CONSTRAINT `t_customer_FK` FOREIGN KEY (`id_users_created`) REFERENCES `t_users` (`id_users`),
  ADD CONSTRAINT `t_customer_FK_1` FOREIGN KEY (`id_users_modified`) REFERENCES `t_users` (`id_users`);

--
-- Filtros para la tabla `t_customer_wallets`
--
ALTER TABLE `t_customer_wallets`
  ADD CONSTRAINT `t_users_wallets_FK` FOREIGN KEY (`id_customer`) REFERENCES `t_customer` (`PlayerID`);

--
-- Filtros para la tabla `t_customer_wallets_movements`
--
ALTER TABLE `t_customer_wallets_movements`
  ADD CONSTRAINT `t_users_wallets_movements_FK` FOREIGN KEY (`id_customer_wallets_movements_types`) REFERENCES `t_customer_wallets_movements_types` (`id_customer_wallets_movements_types`),
  ADD CONSTRAINT `t_users_wallets_movements_FK2` FOREIGN KEY (`id_customer`) REFERENCES `t_customer` (`PlayerID`),
  ADD CONSTRAINT `t_users_wallets_movements_FK_1` FOREIGN KEY (`id_recharge`) REFERENCES `t_recharge` (`id_recharge`),
  ADD CONSTRAINT `t_users_wallets_movements_FK_11` FOREIGN KEY (`id_users_created`) REFERENCES `t_users` (`id_users`);

--
-- Filtros para la tabla `t_recharge`
--
ALTER TABLE `t_recharge`
  ADD CONSTRAINT `t_recharge_FK` FOREIGN KEY (`id_users_created`) REFERENCES `t_users` (`id_users`),
  ADD CONSTRAINT `t_recharge_FK_1` FOREIGN KEY (`id_users_modified`) REFERENCES `t_users` (`id_users`),
  ADD CONSTRAINT `t_recharge_FK_2` FOREIGN KEY (`id_customer`) REFERENCES `t_customer` (`PlayerID`),
  ADD CONSTRAINT `t_recharge_FK_3` FOREIGN KEY (`id_status`) REFERENCES `t_status` (`id_status`),
  ADD CONSTRAINT `t_recharge_FK_4` FOREIGN KEY (`id_channel`) REFERENCES `t_channel` (`id_channel`),
  ADD CONSTRAINT `t_recharge_FK_5` FOREIGN KEY (`id_bank`) REFERENCES `t_bank` (`id_bank`);

--
-- Filtros para la tabla `t_recharge_cancel`
--
ALTER TABLE `t_recharge_cancel`
  ADD CONSTRAINT `t_recharge_cancel_FK` FOREIGN KEY (`id_recharge`) REFERENCES `t_recharge` (`id_recharge`),
  ADD CONSTRAINT `t_recharge_cancel_FK_1` FOREIGN KEY (`id_users_created`) REFERENCES `t_users` (`id_users`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
ing Script de base de datos.sql…]()




