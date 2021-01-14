# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.10.10 (MySQL 5.7.32-0ubuntu0.18.04.1)
# Database: jobsitychatbot
# Generation Time: 2020-12-16 08:12:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table currencies
# ------------------------------------------------------------

CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;

INSERT INTO `currencies` (`id`, `code`, `symbol`, `description`)
VALUES
	(1,'ALL','Lek','Albanian Lek'),
	(2,'XCD','$','East Caribbean Dollar'),
	(3,'EUR','€','Euro'),
	(4,'BBD','$','Barbadian Dollar'),
	(5,'BTN','','Bhutanese Ngultrum'),
	(6,'BND','$','Brunei Dollar'),
	(7,'XAF','','Central African CFA Franc'),
	(8,'CUP','$','Cuban Peso'),
	(9,'USD','$','United States Dollar'),
	(10,'FKP','£','Falkland Islands Pound'),
	(11,'GIP','£','Gibraltar Pound'),
	(12,'HUF','Ft','Hungarian Forint'),
	(13,'IRR','﷼','Iranian Rial'),
	(14,'JMD','J$','Jamaican Dollar'),
	(15,'AUD','$','Australian Dollar'),
	(16,'LAK','₭','Lao Kip'),
	(17,'LYD','','Libyan Dinar'),
	(18,'MKD','ден','Macedonian Denar'),
	(19,'XOF','','West African CFA Franc'),
	(20,'NZD','$','New Zealand Dollar'),
	(21,'OMR','﷼','Omani Rial'),
	(22,'PGK','','Papua New Guinean Kina'),
	(23,'RWF','','Rwandan Franc'),
	(24,'WST','','Samoan Tala'),
	(25,'RSD','Дин.','Serbian Dinar'),
	(26,'SEK','kr','Swedish Krona'),
	(27,'TZS','TSh','Tanzanian Shilling'),
	(28,'AMD','','Armenian Dram'),
	(29,'BSD','$','Bahamian Dollar'),
	(30,'BAM','KM','Bosnia And Herzegovina Konvertibilna Marka'),
	(31,'CVE','','Cape Verdean Escudo'),
	(32,'CNY','¥','Chinese Yuan'),
	(33,'CRC','₡','Costa Rican Colon'),
	(34,'CZK','Kč','Czech Koruna'),
	(35,'ERN','','Eritrean Nakfa'),
	(36,'GEL','','Georgian Lari'),
	(37,'HTG','','Haitian Gourde'),
	(38,'INR','₹','Indian Rupee'),
	(39,'JOD','','Jordanian Dinar'),
	(40,'KRW','₩','South Korean Won'),
	(41,'LBP','£','Lebanese Lira'),
	(42,'MWK','','Malawian Kwacha'),
	(43,'MRO','','Mauritanian Ouguiya'),
	(44,'MZN','','Mozambican Metical'),
	(45,'ANG','ƒ','Netherlands Antillean Gulden'),
	(46,'PEN','S/.','Peruvian Nuevo Sol'),
	(47,'QAR','﷼','Qatari Riyal'),
	(48,'STD','','Sao Tome And Principe Dobra'),
	(49,'SLL','','Sierra Leonean Leone'),
	(50,'SOS','S','Somali Shilling'),
	(51,'SDG','','Sudanese Pound'),
	(52,'SYP','£','Syrian Pound'),
	(53,'AOA','','Angolan Kwanza'),
	(54,'AWG','ƒ','Aruban Florin'),
	(55,'BHD','','Bahraini Dinar'),
	(56,'BZD','BZ$','Belize Dollar'),
	(57,'BWP','P','Botswana Pula'),
	(58,'BIF','','Burundi Franc'),
	(59,'KYD','$','Cayman Islands Dollar'),
	(60,'COP','$','Colombian Peso'),
	(61,'DKK','kr','Danish Krone'),
	(62,'GTQ','Q','Guatemalan Quetzal'),
	(63,'HNL','L','Honduran Lempira'),
	(64,'IDR','Rp','Indonesian Rupiah'),
	(65,'ILS','₪','Israeli New Sheqel'),
	(66,'KZT','лв','Kazakhstani Tenge'),
	(67,'KWD','','Kuwaiti Dinar'),
	(68,'LSL','','Lesotho Loti'),
	(69,'MYR','RM','Malaysian Ringgit'),
	(70,'MUR','₨','Mauritian Rupee'),
	(71,'MNT','₮','Mongolian Tugrik'),
	(72,'MMK','','Myanma Kyat'),
	(73,'NGN','₦','Nigerian Naira'),
	(74,'PAB','B/.','Panamanian Balboa'),
	(75,'PHP','₱','Philippine Peso'),
	(76,'RON','lei','Romanian Leu'),
	(77,'SAR','﷼','Saudi Riyal'),
	(78,'SGD','$','Singapore Dollar'),
	(79,'ZAR','R','South African Rand'),
	(80,'SRD','$','Surinamese Dollar'),
	(81,'TWD','NT$','New Taiwan Dollar'),
	(82,'TOP','','Paanga'),
	(83,'VEF','','Venezuelan Bolivar'),
	(84,'DZD','','Algerian Dinar'),
	(85,'ARS','$','Argentine Peso'),
	(86,'AZN','ман','Azerbaijani Manat'),
	(87,'BYR','p.','Belarusian Ruble'),
	(88,'BOB','$b','Bolivian Boliviano'),
	(89,'BGN','лв','Bulgarian Lev'),
	(90,'CAD','$','Canadian Dollar'),
	(91,'CLP','$','Chilean Peso'),
	(92,'CDF','','Congolese Franc'),
	(93,'DOP','RD$','Dominican Peso'),
	(94,'FJD','$','Fijian Dollar'),
	(95,'GMD','','Gambian Dalasi'),
	(96,'GYD','$','Guyanese Dollar'),
	(97,'ISK','kr','Icelandic Króna'),
	(98,'IQD','','Iraqi Dinar'),
	(99,'JPY','¥','Japanese Yen'),
	(100,'KPW','₩','North Korean Won'),
	(101,'LVL','Ls','Latvian Lats'),
	(102,'CHF','Fr.','Swiss Franc'),
	(103,'MGA','','Malagasy Ariary'),
	(104,'MDL','','Moldovan Leu'),
	(105,'MAD','','Moroccan Dirham'),
	(106,'NPR','₨','Nepalese Rupee'),
	(107,'NIO','C$','Nicaraguan Cordoba'),
	(108,'PKR','₨','Pakistani Rupee'),
	(109,'PYG','Gs','Paraguayan Guarani'),
	(110,'SHP','£','Saint Helena Pound'),
	(111,'SCR','₨','Seychellois Rupee'),
	(112,'SBD','$','Solomon Islands Dollar'),
	(113,'LKR','₨','Sri Lankan Rupee'),
	(114,'THB','฿','Thai Baht'),
	(115,'TRY','','Turkish New Lira'),
	(116,'AED','','UAE Dirham'),
	(117,'VUV','','Vanuatu Vatu'),
	(118,'YER','﷼','Yemeni Rial'),
	(119,'AFN','؋','Afghan Afghani'),
	(120,'BDT','','Bangladeshi Taka'),
	(121,'BRL','R$','Brazilian Real'),
	(122,'KHR','៛','Cambodian Riel'),
	(123,'KMF','','Comorian Franc'),
	(124,'HRK','kn','Croatian Kuna'),
	(125,'DJF','','Djiboutian Franc'),
	(126,'EGP','£','Egyptian Pound'),
	(127,'ETB','','Ethiopian Birr'),
	(128,'XPF','','CFP Franc'),
	(129,'GHS','','Ghanaian Cedi'),
	(130,'GNF','','Guinean Franc'),
	(131,'HKD','$','Hong Kong Dollar'),
	(132,'XDR','','Special Drawing Rights'),
	(133,'KES','KSh','Kenyan Shilling'),
	(134,'KGS','лв','Kyrgyzstani Som'),
	(135,'LRD','$','Liberian Dollar'),
	(136,'MOP','','Macanese Pataca'),
	(137,'MVR','','Maldivian Rufiyaa'),
	(138,'MXN','$','Mexican Peso'),
	(139,'NAD','$','Namibian Dollar'),
	(140,'NOK','kr','Norwegian Krone'),
	(141,'PLN','zł','Polish Zloty'),
	(142,'RUB','руб','Russian Ruble'),
	(143,'SZL','','Swazi Lilangeni'),
	(144,'TJS','','Tajikistani Somoni'),
	(145,'TTD','TT$','Trinidad and Tobago Dollar'),
	(146,'UGX','USh','Ugandan Shilling'),
	(147,'UYU','$U','Uruguayan Peso'),
	(148,'VND','₫','Vietnamese Dong'),
	(149,'TND','','Tunisian Dinar'),
	(150,'UAH','₴','Ukrainian Hryvnia'),
	(151,'UZS','лв','Uzbekistani Som'),
	(152,'TMT','','Turkmenistan Manat'),
	(153,'GBP','£','British Pound'),
	(154,'ZMW','','Zambian Kwacha'),
	(155,'BTC','BTC','Bitcoin'),
	(156,'BYN','p.','New Belarusian Ruble'),
	(157,'BMD','','Bermudan Dollar'),
	(158,'GGP','','Guernsey Pound'),
	(159,'CLF','','Chilean Unit Of Account'),
	(160,'CUC','','Cuban Convertible Peso'),
	(161,'IMP','','Manx pound'),
	(162,'JEP','','Jersey Pound'),
	(163,'SVC','','Salvadoran Colón'),
	(164,'ZMK','','Old Zambian Kwacha'),
	(165,'XAG','','Silver (troy ounce)'),
	(166,'ZWL','','Zimbabwean Dollar');

/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table transactions
# ------------------------------------------------------------

CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `base_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_type` enum('Deposit','Withdraw','Show') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(19,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
