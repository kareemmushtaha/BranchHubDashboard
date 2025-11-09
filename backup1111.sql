-- MySQL dump 10.13  Distrib 8.1.0, for macos13 (arm64)
--
-- Host: localhost    Database: branch
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booking_requests`
--

DROP TABLE IF EXISTS `booking_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `requested_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_requests`
--

LOCK TABLES `booking_requests` WRITE;
/*!40000 ALTER TABLE `booking_requests` DISABLE KEYS */;
INSERT INTO `booking_requests` VALUES (1,'سيبسيب','0534645676','daily','sdfsdfsdf','confirmed','2025-09-12 10:00:07','2025-09-12 10:00:07','2025-09-12 12:22:13');
/*!40000 ALTER TABLE `booking_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drinks`
--

DROP TABLE IF EXISTS `drinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `drinks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `size` enum('small','medium','large') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('available','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drinks`
--

LOCK TABLES `drinks` WRITE;
/*!40000 ALTER TABLE `drinks` DISABLE KEYS */;
INSERT INTO `drinks` VALUES (1,'شاي',2.00,'medium','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(2,'قهوة',3.00,'medium','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(3,'عصير برتقال',4.00,'large','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(4,'مياه',1.00,'medium','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(5,'مشروب غازي',2.50,'medium','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(6,'عصير تفاح',3.50,'medium','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(7,'شاي أخضر',2.50,'small','available','2025-08-28 09:17:34','2025-08-28 09:17:34'),(8,'نسكافيه',3.50,'large','available','2025-08-28 09:17:34','2025-08-28 09:17:34');
/*!40000 ALTER TABLE `drinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` enum('bank','cash') COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_user_id_foreign` (`user_id`),
  CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,1.14,'cash','هخهتتتتت',12,'2025-09-12 00:53:14','2025-09-12 00:53:14');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_08_14_161441_create_session_types_table',1),(5,'2025_08_14_161442_create_drinks_table',1),(6,'2025_08_14_161442_create_over_times_table',1),(7,'2025_08_14_161442_create_public_prices_table',1),(8,'2025_08_14_161442_create_sessions_table',1),(9,'2025_08_14_161442_create_subscriptions_table',1),(10,'2025_08_14_161442_create_user_wallets_table',1),(11,'2025_08_14_161443_create_session_drinks_table',1),(12,'2025_08_14_161444_create_session_payments_table',1),(13,'2025_08_14_161509_update_users_table',1),(14,'2025_08_14_175437_add_soft_deletes_to_users_table',1),(15,'2025_08_14_184626_make_email_nullable_in_users_table',1),(16,'2025_08_14_185937_create_wallet_transactions_table',1),(17,'2025_08_14_191811_add_payment_method_to_wallet_transactions_table',1),(18,'2025_08_14_193616_add_soft_deletes_to_user_sessions_table',1),(19,'2025_08_21_180753_add_subscription_start_date_to_users_table',1),(20,'2025_08_21_200039_add_price_to_session_types_table',1),(21,'2025_08_22_035448_remove_subscription_dates_from_users_table',1),(22,'2025_08_22_154147_add_quantity_to_session_drinks_table',1),(23,'2025_08_22_184448_add_custom_internet_cost_to_sessions_table',1),(24,'2025_08_23_025513_add_payment_status_to_session_drinks_table',1),(25,'2025_08_23_033622_add_last_login_at_to_users_table',1),(26,'2025_08_23_033852_update_user_type_enum_in_users_table',1),(27,'2025_08_23_034648_create_session_audit_logs_table',1),(28,'2025_08_28_031557_add_note_to_session_payments_table',1),(29,'2025_08_28_044420_remove_payment_status_from_session_drinks_table',1),(30,'2025_08_28_125424_remove_session_type_id_from_sessions_table',2),(31,'2025_08_28_125447_drop_session_types_table',2),(32,'2025_08_30_035609_add_expected_end_date_to_sessions_table',3),(33,'2025_08_30_043333_remove_prepaid_from_user_type_enum',4),(34,'2025_08_30_043347_remove_prepaid_from_session_category_enum',4),(35,'2025_09_12_023553_add_session_owner_to_sessions_table',5),(36,'2025_09_12_033859_create_expenses_table',6),(37,'2025_09_12_041751_create_booking_requests_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `over_times`
--

DROP TABLE IF EXISTS `over_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `over_times` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `start_at` timestamp NOT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `time_type` enum('morning','night') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'morning',
  `status_paid` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `over_times_user_id_foreign` (`user_id`),
  CONSTRAINT `over_times_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `over_times`
--

LOCK TABLES `over_times` WRITE;
/*!40000 ALTER TABLE `over_times` DISABLE KEYS */;
/*!40000 ALTER TABLE `over_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_prices`
--

DROP TABLE IF EXISTS `public_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `public_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `price_overtime_morning` decimal(8,2) NOT NULL DEFAULT '5.00',
  `price_overtime_night` decimal(8,2) NOT NULL DEFAULT '7.00',
  `hourly_rate` decimal(8,2) NOT NULL DEFAULT '5.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_prices`
--

LOCK TABLES `public_prices` WRITE;
/*!40000 ALTER TABLE `public_prices` DISABLE KEYS */;
INSERT INTO `public_prices` VALUES (1,5.00,7.00,5.00,'2025-08-28 09:17:34','2025-08-28 09:17:34');
/*!40000 ALTER TABLE `public_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_audit_logs`
--

DROP TABLE IF EXISTS `session_audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session_audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_audit_logs_session_id_created_at_index` (`session_id`,`created_at`),
  KEY `session_audit_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `session_audit_logs_action_created_at_index` (`action`,`created_at`),
  KEY `session_audit_logs_created_at_index` (`created_at`),
  CONSTRAINT `session_audit_logs_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `user_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `session_audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_audit_logs`
--

LOCK TABLES `session_audit_logs` WRITE;
/*!40000 ALTER TABLE `session_audit_logs` DISABLE KEYS */;
INSERT INTO `session_audit_logs` VALUES (3,2,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 09:50:39','2025-08-28 09:50:39'),(4,2,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 10:38:22','2025-08-28 10:38:22'),(5,2,12,'add_drink','drink','تم إضافة مشروب شاي (الكمية: 2, السعر: $4)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 10:38:22','2025-08-28 10:38:22'),(6,2,12,'update','payment','تم تحديث SessionPayment','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 7.977110148611111, \"payment_status\": \"pending\", \"remaining_amount\": 7.977110148611111}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 10:38:22','2025-08-28 10:38:22'),(7,2,12,'update','payment','تم تحديث SessionPayment','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"7.98\", \"payment_status\": \"pending\", \"remaining_amount\": \"7.98\"}','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 8.027777777777779, \"payment_status\": \"pending\", \"remaining_amount\": 8.027777777777779}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 10:38:59','2025-08-28 10:38:59'),(8,2,12,'update','payment','تم تحديث SessionPayment','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"8.03\", \"payment_status\": \"pending\", \"remaining_amount\": \"8.03\"}','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": 8.03, \"amount_cash\": 0, \"total_price\": 8.03, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 17:18:34','2025-08-28 17:18:34'),(9,2,12,'update','payment','تم تحديث SessionPayment','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": \"8.03\", \"amount_cash\": \"0.00\", \"total_price\": \"8.03\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 2, \"note\": null, \"session_id\": 2, \"amount_bank\": 0, \"amount_cash\": 8.03, \"total_price\": 8.03, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 17:24:26','2025-08-28 17:24:26'),(10,3,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 17:24:48','2025-08-28 17:24:48'),(11,3,12,'update','payment','تم تحديث SessionPayment','{\"id\": 3, \"note\": null, \"session_id\": 3, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 3, \"note\": null, \"session_id\": 3, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 3.3708333333333336, \"payment_status\": \"pending\", \"remaining_amount\": 3.3708333333333336}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 18:05:15','2025-08-28 18:05:15'),(12,3,12,'update','payment','تم تحديث SessionPayment','{\"id\": 3, \"note\": null, \"session_id\": 3, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"3.37\", \"payment_status\": \"pending\", \"remaining_amount\": \"3.37\"}','{\"id\": 3, \"note\": null, \"session_id\": 3, \"amount_bank\": 55, \"amount_cash\": 0, \"total_price\": 55, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 18:05:28','2025-08-28 18:05:28'),(13,4,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 19:17:19','2025-08-28 19:17:19'),(14,4,12,'update','payment','تم تحديث SessionPayment','{\"id\": 4, \"note\": null, \"session_id\": 4, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 4, \"note\": null, \"session_id\": 4, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 2.651388888888889, \"payment_status\": \"pending\", \"remaining_amount\": 2.651388888888889}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-28 19:49:08','2025-08-28 19:49:08'),(15,5,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:12:15','2025-08-30 00:12:15'),(16,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 840.61, \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:19:17','2025-08-30 00:19:17'),(17,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"840.61\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 840.6070977027777, \"payment_status\": \"pending\", \"remaining_amount\": 840.6070977027777}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:19:17','2025-08-30 00:19:17'),(18,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"840.61\", \"payment_status\": \"pending\", \"remaining_amount\": \"840.61\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 830.62, \"payment_status\": \"pending\", \"remaining_amount\": \"840.61\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:19:29','2025-08-30 00:19:29'),(19,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"830.62\", \"payment_status\": \"pending\", \"remaining_amount\": \"840.61\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 830.6248159708333, \"payment_status\": \"pending\", \"remaining_amount\": 830.6248159708333}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:19:29','2025-08-30 00:19:29'),(20,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"830.62\", \"payment_status\": \"pending\", \"remaining_amount\": \"830.62\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": \"830.62\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:19:37','2025-08-30 00:19:37'),(21,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"830.62\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -9.364351011111111, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:19:37','2025-08-30 00:19:37'),(22,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-9.36\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.12, \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:27:19','2025-08-30 00:27:19'),(23,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.12\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -5.21256796861111, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:27:19','2025-08-30 00:27:19'),(24,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-5.21\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 8.82, \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:27:36','2025-08-30 00:27:36'),(25,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"8.82\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 8.820913019722221, \"payment_status\": \"pending\", \"remaining_amount\": 8.820913019722221}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:27:36','2025-08-30 00:27:36'),(26,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"8.82\", \"payment_status\": \"pending\", \"remaining_amount\": \"8.82\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 15.92, \"payment_status\": \"pending\", \"remaining_amount\": \"8.82\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:28:26','2025-08-30 00:28:26'),(27,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"15.92\", \"payment_status\": \"pending\", \"remaining_amount\": \"8.82\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 15.917656167777778, \"payment_status\": \"pending\", \"remaining_amount\": 15.917656167777778}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:28:26','2025-08-30 00:28:26'),(28,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"15.92\", \"payment_status\": \"pending\", \"remaining_amount\": \"15.92\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 15.926944444444448, \"payment_status\": \"pending\", \"remaining_amount\": 15.926944444444448}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:28:31','2025-08-30 00:28:31'),(29,4,12,'update','payment','تم تحديث SessionPayment','{\"id\": 4, \"note\": null, \"session_id\": 4, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"2.65\", \"payment_status\": \"pending\", \"remaining_amount\": \"2.65\"}','{\"id\": 4, \"note\": null, \"session_id\": 4, \"amount_bank\": 2.65, \"amount_cash\": 0, \"total_price\": 2.65, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:42:17','2025-08-30 00:42:17'),(30,6,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:43:55','2025-08-30 00:43:55'),(31,5,12,'update','payment','تم تحديث SessionPayment','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"15.93\", \"payment_status\": \"pending\", \"remaining_amount\": \"15.93\"}','{\"id\": 5, \"note\": null, \"session_id\": 5, \"amount_bank\": 15.93, \"amount_cash\": 0, \"total_price\": 15.93, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 00:45:43','2025-08-30 00:45:43'),(32,7,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:09:33','2025-08-30 01:09:33'),(33,7,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:38','2025-08-30 01:14:38'),(34,7,12,'add_drink','drink','تم إضافة مشروب شاي (الكمية: 1, السعر: $2)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:38','2025-08-30 01:14:38'),(35,7,12,'update','payment','تم تحديث SessionPayment','{\"id\": 7, \"note\": null, \"session_id\": 7, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 7, \"note\": null, \"session_id\": 7, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 2, \"payment_status\": \"pending\", \"remaining_amount\": 2}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:38','2025-08-30 01:14:38'),(36,7,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:44','2025-08-30 01:14:44'),(37,7,12,'add_drink','drink','تم إضافة مشروب عصير برتقال (الكمية: 1, السعر: $4)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:44','2025-08-30 01:14:44'),(38,7,12,'update','payment','تم تحديث SessionPayment','{\"id\": 7, \"note\": null, \"session_id\": 7, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"2.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"2.00\"}','{\"id\": 7, \"note\": null, \"session_id\": 7, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 6, \"payment_status\": \"pending\", \"remaining_amount\": 6}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:44','2025-08-30 01:14:44'),(39,7,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:48','2025-08-30 01:14:48'),(40,7,12,'add_drink','drink','تم إضافة مشروب عصير تفاح (الكمية: 1, السعر: $3.5)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:48','2025-08-30 01:14:48'),(41,7,12,'update','payment','تم تحديث SessionPayment','{\"id\": 7, \"note\": null, \"session_id\": 7, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"6.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"6.00\"}','{\"id\": 7, \"note\": null, \"session_id\": 7, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 9.5, \"payment_status\": \"pending\", \"remaining_amount\": 9.5}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:14:48','2025-08-30 01:14:48'),(42,8,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:16:51','2025-08-30 01:16:51'),(43,9,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 01:19:53','2025-08-30 01:19:53'),(44,10,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 02:19:01','2025-08-30 02:19:01'),(45,8,12,'update','payment','تم تحديث SessionPayment','{\"id\": 8, \"note\": null, \"session_id\": 8, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 8, \"note\": null, \"session_id\": 8, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 12.823611111111113, \"payment_status\": \"pending\", \"remaining_amount\": 12.823611111111113}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 03:50:44','2025-08-30 03:50:44'),(46,10,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:15:01','2025-08-30 14:15:01'),(47,10,12,'add_drink','drink','تم إضافة مشروب شاي (الكمية: 1, السعر: $2)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:15:01','2025-08-30 14:15:01'),(48,10,12,'update','payment','تم تحديث SessionPayment','{\"id\": 10, \"note\": null, \"session_id\": 10, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 10, \"note\": null, \"session_id\": 10, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 182, \"payment_status\": \"pending\", \"remaining_amount\": 182}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:15:01','2025-08-30 14:15:01'),(49,10,12,'remove_drink','drink','تم حذف مشروب شاي (الكمية: 1, السعر: $2.00)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:15:58','2025-08-30 14:15:58'),(50,10,12,'delete','drink','تم حذف SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:15:58','2025-08-30 14:15:58'),(51,10,12,'update','payment','تم تحديث SessionPayment','{\"id\": 10, \"note\": null, \"session_id\": 10, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"182.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"182.00\"}','{\"id\": 10, \"note\": null, \"session_id\": 10, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 180, \"payment_status\": \"pending\", \"remaining_amount\": 180}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:15:58','2025-08-30 14:15:58'),(52,11,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-30 14:16:30','2025-08-30 14:16:30'),(53,11,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-31 18:14:28','2025-08-31 18:14:28'),(54,11,12,'add_drink','drink','تم إضافة مشروب شاي (الكمية: 1, السعر: $2)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-31 18:14:28','2025-08-31 18:14:28'),(55,11,12,'update','payment','تم تحديث SessionPayment','{\"id\": 11, \"note\": null, \"session_id\": 11, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 11, \"note\": null, \"session_id\": 11, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 182, \"payment_status\": \"pending\", \"remaining_amount\": 182}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-31 18:14:28','2025-08-31 18:14:28'),(56,12,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-08-31 18:14:44','2025-08-31 18:14:44'),(57,12,NULL,'update','payment','تم تحديث SessionPayment','{\"id\": 12, \"note\": null, \"session_id\": 12, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 12, \"note\": null, \"session_id\": 12, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 1200, \"payment_status\": \"pending\", \"remaining_amount\": 1200}','127.0.0.1','Symfony','2025-08-31 18:30:18','2025-08-31 18:30:18'),(59,13,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 11:55:59','2025-09-01 11:55:59'),(60,14,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 11:58:48','2025-09-01 11:58:48'),(61,14,12,'update','payment','تم تحديث SessionPayment','{\"id\": 14, \"note\": null, \"session_id\": 14, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 14, \"note\": null, \"session_id\": 14, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 100, \"payment_status\": \"pending\", \"remaining_amount\": 100}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 11:58:56','2025-09-01 11:58:56'),(62,13,12,'update','payment','تم تحديث SessionPayment','{\"id\": 13, \"note\": null, \"session_id\": 13, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 13, \"note\": null, \"session_id\": 13, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.49722222222222223, \"payment_status\": \"pending\", \"remaining_amount\": 0.49722222222222223}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:01:57','2025-09-01 12:01:57'),(63,15,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:41:13','2025-09-01 12:41:13'),(64,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 5.34, \"payment_status\": \"pending\", \"remaining_amount\": 5.34}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:44:08','2025-09-01 12:44:08'),(65,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"5.34\", \"payment_status\": \"pending\", \"remaining_amount\": \"5.34\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": 0.08}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:44:38','2025-09-01 12:44:38'),(66,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.08\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -4.6135238944444446, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:44:38','2025-09-01 12:44:38'),(67,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-4.61\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": 0.08}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:45:09','2025-09-01 12:45:09'),(68,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.08\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -29.570029397222225, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:45:09','2025-09-01 12:45:09'),(69,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-29.57\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": 0.08}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:45:37','2025-09-01 12:45:37'),(70,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.08\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -29.947697184722223, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:45:37','2025-09-01 12:45:37'),(71,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-29.95\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": 0.08}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:47:54','2025-09-01 12:47:54'),(72,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.08\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -34.757666625, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:47:54','2025-09-01 12:47:54'),(73,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-34.76\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 5.29, \"payment_status\": \"pending\", \"remaining_amount\": 5.29}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:48:30','2025-09-01 12:48:30'),(74,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"5.29\", \"payment_status\": \"pending\", \"remaining_amount\": \"5.29\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": 0.08}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:48:37','2025-09-01 12:48:37'),(75,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.08\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -24.697476433333335, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:48:37','2025-09-01 12:48:37'),(76,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-24.70\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.08, \"payment_status\": \"pending\", \"remaining_amount\": 0.08}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:53:08','2025-09-01 12:53:08'),(77,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.08\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.08\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": -4.322159006944444, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:53:08','2025-09-01 12:53:08'),(78,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"-4.32\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.69, \"payment_status\": \"pending\", \"remaining_amount\": 0.69}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 12:53:16','2025-09-01 12:53:16'),(79,15,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:10:13','2025-09-01 13:10:13'),(80,15,12,'add_drink','drink','تم إضافة مشروب شاي (الكمية: 2, السعر: $4)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:10:13','2025-09-01 13:10:13'),(81,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.69\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.69\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 6.101674575, \"payment_status\": \"pending\", \"remaining_amount\": 6.101674575}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:10:13','2025-09-01 13:10:13'),(82,15,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:10:25','2025-09-01 13:10:25'),(83,15,12,'add_drink','drink','تم إضافة مشروب عصير برتقال (الكمية: 1, السعر: $4)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:10:25','2025-09-01 13:10:25'),(84,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"6.10\", \"payment_status\": \"pending\", \"remaining_amount\": \"6.10\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 10.119172655555555, \"payment_status\": \"pending\", \"remaining_amount\": 10.119172655555555}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:10:25','2025-09-01 13:10:25'),(85,15,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:11:52','2025-09-01 13:11:52'),(86,15,12,'add_drink','drink','تم إضافة مشروب مشروب غازي (الكمية: 3, السعر: $7.5)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:11:52','2025-09-01 13:11:52'),(87,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"10.12\", \"payment_status\": \"pending\", \"remaining_amount\": \"10.12\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 17.73995254861111, \"payment_status\": \"pending\", \"remaining_amount\": 17.73995254861111}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:11:52','2025-09-01 13:11:52'),(88,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"17.74\", \"payment_status\": \"pending\", \"remaining_amount\": \"17.74\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 1415.5, \"payment_status\": \"pending\", \"remaining_amount\": 1415.5}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:31:43','2025-09-01 13:31:43'),(89,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"1415.50\", \"payment_status\": \"pending\", \"remaining_amount\": \"1415.50\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": 1400, \"amount_cash\": 15.5, \"total_price\": 1415.5, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:32:45','2025-09-01 13:32:45'),(90,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"1400.00\", \"amount_cash\": \"15.50\", \"total_price\": \"1415.50\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": 1400, \"amount_cash\": 15, \"total_price\": 1415.5, \"payment_status\": \"partial\", \"remaining_amount\": 0.5}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:33:11','2025-09-01 13:33:11'),(91,15,12,'update','payment','تم تحديث SessionPayment','{\"id\": 15, \"note\": null, \"session_id\": 15, \"amount_bank\": \"1400.00\", \"amount_cash\": \"15.00\", \"total_price\": \"1415.50\", \"payment_status\": \"partial\", \"remaining_amount\": \"0.50\"}','{\"id\": 15, \"note\": \"الزبون محمد عبد الرحمن له مبلغ مستحق\", \"session_id\": 15, \"amount_bank\": 1400, \"amount_cash\": 100, \"total_price\": 1415.5, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:33:50','2025-09-01 13:33:50'),(92,16,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:40:31','2025-09-01 13:40:31'),(93,16,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:41:33','2025-09-01 13:41:33'),(94,16,12,'add_drink','drink','تم إضافة مشروب شاي (الكمية: 2, السعر: $4)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:41:33','2025-09-01 13:41:33'),(95,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 4.086407968055555, \"payment_status\": \"pending\", \"remaining_amount\": 4.086407968055555}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:41:33','2025-09-01 13:41:33'),(96,16,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:42:09','2025-09-01 13:42:09'),(97,16,12,'add_drink','drink','تم إضافة مشروب قهوة (الكمية: 3, السعر: $9)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:42:09','2025-09-01 13:42:09'),(98,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"4.09\", \"payment_status\": \"pending\", \"remaining_amount\": \"4.09\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 13.136389741666669, \"payment_status\": \"pending\", \"remaining_amount\": 13.136389741666669}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:42:09','2025-09-01 13:42:09'),(99,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"13.14\", \"payment_status\": \"pending\", \"remaining_amount\": \"13.14\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 14.45138888888889, \"payment_status\": \"pending\", \"remaining_amount\": 14.45138888888889}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 13:57:56','2025-09-01 13:57:56'),(100,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"14.45\", \"payment_status\": \"pending\", \"remaining_amount\": \"14.45\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 813, \"payment_status\": \"pending\", \"remaining_amount\": 813}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:00:50','2025-09-01 14:00:50'),(101,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"813.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"813.00\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 15, \"payment_status\": \"pending\", \"remaining_amount\": 15}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:01:14','2025-09-01 14:01:14'),(102,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"15.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"15.00\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 913, \"payment_status\": \"pending\", \"remaining_amount\": 913}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:01:22','2025-09-01 14:01:22'),(103,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"913.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"913.00\"}','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": 900, \"amount_cash\": 13, \"total_price\": 913, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:03:35','2025-09-01 14:03:35'),(104,17,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:03:58','2025-09-01 14:03:58'),(105,17,12,'update','payment','تم تحديث SessionPayment','{\"id\": 17, \"note\": null, \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 17, \"note\": null, \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 190, \"payment_status\": \"pending\", \"remaining_amount\": 190}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:04:06','2025-09-01 14:04:06'),(106,17,12,'create','drink','تم إنشاء SessionDrink',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:04:10','2025-09-01 14:04:10'),(107,17,12,'add_drink','drink','تم إضافة مشروب عصير برتقال (الكمية: 1, السعر: $4)',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:04:10','2025-09-01 14:04:10'),(108,17,12,'update','payment','تم تحديث SessionPayment','{\"id\": 17, \"note\": null, \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"190.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"190.00\"}','{\"id\": 17, \"note\": null, \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 194, \"payment_status\": \"pending\", \"remaining_amount\": 194}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:04:10','2025-09-01 14:04:10'),(109,17,12,'update','payment','تم تحديث SessionPayment','{\"id\": 17, \"note\": null, \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"194.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"194.00\"}','{\"id\": 17, \"note\": \"انا مومن : متبقي لساجد عبد الرحمن مبلغ 6 شيكل\", \"session_id\": 17, \"amount_bank\": 0, \"amount_cash\": 200, \"total_price\": 194, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:05:25','2025-09-01 14:05:25'),(110,18,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:20:02','2025-09-01 14:20:02'),(111,19,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 14:36:47','2025-09-01 14:36:47'),(112,17,12,'update','payment','تم تحديث SessionPayment','{\"id\": 17, \"note\": \"انا مومن : متبقي لساجد عبد الرحمن مبلغ 6 شيكل\", \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"200.00\", \"total_price\": \"194.00\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 17, \"note\": \"انا مومن : متبقي لساجد عبد الرحمن مبلغ 6 شيكل\", \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"200.00\", \"total_price\": \"194.00\", \"payment_status\": \"cancelled\", \"remaining_amount\": \"0.00\"}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 15:40:05','2025-09-01 15:40:05'),(113,17,12,'session_cancelled','session','تم إلغاء الجلسة بواسطة المدير','\"{\\\"session_status\\\":\\\"completed\\\",\\\"payment_status\\\":\\\"cancelled\\\"}\"','\"{\\\"session_status\\\":\\\"cancelled\\\",\\\"payment_status\\\":\\\"cancelled\\\"}\"',NULL,NULL,'2025-09-01 15:40:05','2025-09-01 15:40:05'),(114,20,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 21:28:51','2025-09-01 21:28:51'),(115,20,12,'update','payment','تم تحديث SessionPayment','{\"id\": 20, \"note\": null, \"session_id\": 20, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 20, \"note\": null, \"session_id\": 20, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 100, \"payment_status\": \"pending\", \"remaining_amount\": 100}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 21:29:06','2025-09-01 21:29:06'),(116,20,12,'update','payment','تم تحديث SessionPayment','{\"id\": 20, \"note\": null, \"session_id\": 20, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"100.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"100.00\"}','{\"id\": 20, \"note\": \"انا كريم يستحق للشخص هذا المبلغ\", \"session_id\": 20, \"amount_bank\": 150, \"amount_cash\": 0, \"total_price\": 100, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 21:32:25','2025-09-01 21:32:25'),(117,17,12,'update','payment','تم تحديث SessionPayment','{\"id\": 17, \"note\": \"انا مومن : متبقي لساجد عبد الرحمن مبلغ 6 شيكل\", \"session_id\": 17, \"amount_bank\": \"0.00\", \"amount_cash\": \"200.00\", \"total_price\": \"194.00\", \"payment_status\": \"cancelled\", \"remaining_amount\": \"0.00\"}','{\"id\": 17, \"note\": \"انا مومن : متبقي لساجد عبد الرحمن مبلغ 6 شيكل\", \"session_id\": 17, \"amount_bank\": 0, \"amount_cash\": 194, \"total_price\": 194, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 22:58:00','2025-09-01 22:58:00'),(118,16,12,'update','payment','تم تحديث SessionPayment','{\"id\": 16, \"note\": null, \"session_id\": 16, \"amount_bank\": \"900.00\", \"amount_cash\": \"13.00\", \"total_price\": \"913.00\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 16, \"note\": \"z\", \"session_id\": 16, \"amount_bank\": 900, \"amount_cash\": 20, \"total_price\": 913, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-01 23:05:17','2025-09-01 23:05:17'),(119,21,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-02 12:06:42','2025-09-02 12:06:42'),(120,21,12,'update','payment','تم تحديث SessionPayment','{\"id\": 21, \"note\": null, \"session_id\": 21, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 21, \"note\": null, \"session_id\": 21, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-02 12:08:29','2025-09-02 12:08:29'),(121,21,12,'update','payment','تم تحديث SessionPayment','{\"id\": 21, \"note\": null, \"session_id\": 21, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 21, \"note\": null, \"session_id\": 21, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 275, \"payment_status\": \"pending\", \"remaining_amount\": 275}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-02 12:09:25','2025-09-02 12:09:25'),(122,22,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-02 12:27:23','2025-09-02 12:27:23'),(123,22,12,'update','payment','تم تحديث SessionPayment','{\"id\": 22, \"note\": null, \"session_id\": 22, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 22, \"note\": null, \"session_id\": 22, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-02 12:27:59','2025-09-02 12:27:59'),(124,22,12,'update','payment','تم تحديث SessionPayment','{\"id\": 22, \"note\": null, \"session_id\": 22, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"paid\", \"remaining_amount\": \"0.00\"}','{\"id\": 22, \"note\": null, \"session_id\": 22, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 275, \"payment_status\": \"pending\", \"remaining_amount\": 275}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','2025-09-02 12:28:58','2025-09-02 12:28:58'),(125,23,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:27:21','2025-09-11 23:27:21'),(126,23,12,'update','payment','تم تحديث SessionPayment','{\"id\": 23, \"note\": null, \"session_id\": 23, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 23, \"note\": null, \"session_id\": 23, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 0.02638888888888889, \"payment_status\": \"pending\", \"remaining_amount\": 0.02638888888888889}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:27:40','2025-09-11 23:27:40'),(127,23,12,'update','payment','تم تحديث SessionPayment','{\"id\": 23, \"note\": null, \"session_id\": 23, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.03\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.03\"}','{\"id\": 23, \"note\": null, \"session_id\": 23, \"amount_bank\": 0.03, \"amount_cash\": 0, \"total_price\": 0.03, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:28:48','2025-09-11 23:28:48'),(128,24,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:38:44','2025-09-11 23:38:44'),(129,19,12,'update','payment','تم تحديث SessionPayment','{\"id\": 19, \"note\": null, \"session_id\": 19, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 19, \"note\": null, \"session_id\": 19, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 1245.9791666666663, \"payment_status\": \"pending\", \"remaining_amount\": 1245.9791666666663}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:48:32','2025-09-11 23:48:32'),(130,24,12,'update','payment','تم تحديث SessionPayment','{\"id\": 24, \"note\": null, \"session_id\": 24, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 24, \"note\": null, \"session_id\": 24, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": 1.4833333333333334, \"payment_status\": \"pending\", \"remaining_amount\": 1.4833333333333334}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:56:32','2025-09-11 23:56:32'),(131,24,12,'update','payment','تم تحديث SessionPayment','{\"id\": 24, \"note\": null, \"session_id\": 24, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"1.48\", \"payment_status\": \"pending\", \"remaining_amount\": \"1.48\"}','{\"id\": 24, \"note\": null, \"session_id\": 24, \"amount_bank\": 1.48, \"amount_cash\": 0, \"total_price\": 1.48, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:56:41','2025-09-11 23:56:41'),(132,25,12,'create','payment','تم إنشاء SessionPayment',NULL,NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-11 23:57:14','2025-09-11 23:57:14'),(133,25,12,'update','payment','تم تحديث SessionPayment','{\"id\": 25, \"note\": null, \"session_id\": 25, \"amount_bank\": \"0.00\", \"amount_cash\": \"0.00\", \"total_price\": \"0.00\", \"payment_status\": \"pending\", \"remaining_amount\": \"0.00\"}','{\"id\": 25, \"note\": null, \"session_id\": 25, \"amount_bank\": 0, \"amount_cash\": 0, \"total_price\": 0, \"payment_status\": \"paid\", \"remaining_amount\": 0}','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','2025-09-12 00:01:39','2025-09-12 00:01:39');
/*!40000 ALTER TABLE `session_audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_drinks`
--

DROP TABLE IF EXISTS `session_drinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session_drinks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `drink_id` bigint unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `status` enum('ordered','served','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ordered',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_drinks_session_id_foreign` (`session_id`),
  KEY `session_drinks_drink_id_foreign` (`drink_id`),
  CONSTRAINT `session_drinks_drink_id_foreign` FOREIGN KEY (`drink_id`) REFERENCES `drinks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `session_drinks_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `user_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_drinks`
--

LOCK TABLES `session_drinks` WRITE;
/*!40000 ALTER TABLE `session_drinks` DISABLE KEYS */;
INSERT INTO `session_drinks` VALUES (1,2,1,4.00,2,'ordered',NULL,'2025-08-28 10:38:22','2025-08-28 10:38:22'),(2,7,1,2.00,1,'ordered',NULL,'2025-08-30 01:14:38','2025-08-30 01:14:38'),(3,7,3,4.00,1,'ordered',NULL,'2025-08-30 01:14:44','2025-08-30 01:14:44'),(4,7,6,3.50,1,'ordered',NULL,'2025-08-30 01:14:48','2025-08-30 01:14:48'),(6,11,1,2.00,1,'ordered',NULL,'2025-08-31 18:14:28','2025-08-31 18:14:28'),(7,15,1,4.00,2,'ordered',NULL,'2025-09-01 13:10:13','2025-09-01 13:10:13'),(8,15,3,4.00,1,'ordered',NULL,'2025-09-01 13:10:25','2025-09-01 13:10:25'),(9,15,5,7.50,3,'ordered',NULL,'2025-09-01 13:11:52','2025-09-01 13:11:52'),(10,16,1,4.00,2,'ordered',NULL,'2025-09-01 13:41:33','2025-09-01 13:41:33'),(11,16,2,9.00,3,'ordered',NULL,'2025-09-01 13:42:09','2025-09-01 13:42:09'),(12,17,3,4.00,1,'ordered',NULL,'2025-09-01 14:04:10','2025-09-01 14:04:10');
/*!40000 ALTER TABLE `session_drinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_payments`
--

DROP TABLE IF EXISTS `session_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `amount_bank` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('pending','paid','partial','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remaining_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_payments_session_id_foreign` (`session_id`),
  CONSTRAINT `session_payments_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `user_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_payments`
--

LOCK TABLES `session_payments` WRITE;
/*!40000 ALTER TABLE `session_payments` DISABLE KEYS */;
INSERT INTO `session_payments` VALUES (2,2,8.03,0.00,8.03,'paid',0.00,NULL,'2025-08-28 09:50:39','2025-08-28 17:24:26'),(3,3,55.00,55.00,0.00,'paid',0.00,NULL,'2025-08-28 17:24:48','2025-08-28 18:05:28'),(4,4,2.65,2.65,0.00,'paid',0.00,NULL,'2025-08-28 19:17:19','2025-08-30 00:42:17'),(5,5,15.93,15.93,0.00,'paid',0.00,NULL,'2025-08-30 00:12:15','2025-08-30 00:45:43'),(6,6,0.00,0.00,0.00,'pending',0.00,NULL,'2025-08-30 00:43:55','2025-08-30 00:43:55'),(7,7,9.50,0.00,0.00,'pending',9.50,NULL,'2025-08-30 01:09:33','2025-08-30 01:14:48'),(8,8,12.82,0.00,0.00,'pending',12.82,NULL,'2025-08-30 01:16:51','2025-08-30 03:50:44'),(9,9,0.00,0.00,0.00,'pending',0.00,NULL,'2025-08-30 01:19:53','2025-08-30 01:19:53'),(10,10,180.00,0.00,0.00,'pending',180.00,NULL,'2025-08-30 02:19:01','2025-08-30 14:15:58'),(11,11,182.00,0.00,0.00,'pending',182.00,NULL,'2025-08-30 14:16:30','2025-08-31 18:14:28'),(12,12,1200.00,0.00,0.00,'pending',1200.00,NULL,'2025-08-31 18:14:44','2025-08-31 18:30:18'),(13,13,0.50,0.00,0.00,'pending',0.50,NULL,'2025-09-01 11:55:59','2025-09-01 12:01:57'),(14,14,100.00,0.00,0.00,'pending',100.00,NULL,'2025-09-01 11:58:48','2025-09-01 11:58:56'),(15,15,1415.50,1400.00,100.00,'paid',0.00,'الزبون محمد عبد الرحمن له مبلغ مستحق','2025-09-01 12:41:13','2025-09-01 13:33:50'),(16,16,913.00,900.00,20.00,'paid',0.00,'z','2025-09-01 13:40:31','2025-09-01 23:05:17'),(17,17,194.00,0.00,194.00,'paid',0.00,'انا مومن : متبقي لساجد عبد الرحمن مبلغ 6 شيكل','2025-09-01 14:03:58','2025-09-01 22:58:00'),(18,18,0.00,0.00,0.00,'pending',0.00,NULL,'2025-09-01 14:20:02','2025-09-01 14:20:02'),(19,19,1245.98,0.00,0.00,'pending',1245.98,NULL,'2025-09-01 14:36:47','2025-09-11 23:48:32'),(20,20,100.00,150.00,0.00,'paid',0.00,'انا كريم يستحق للشخص هذا المبلغ','2025-09-01 21:28:51','2025-09-01 21:32:25'),(21,21,275.00,0.00,0.00,'pending',275.00,NULL,'2025-09-02 12:06:42','2025-09-02 12:09:25'),(22,22,275.00,0.00,0.00,'pending',275.00,NULL,'2025-09-02 12:27:23','2025-09-02 12:28:58'),(23,23,0.03,0.03,0.00,'paid',0.00,NULL,'2025-09-11 23:27:21','2025-09-11 23:28:48'),(24,24,1.48,1.48,0.00,'paid',0.00,NULL,'2025-09-11 23:38:44','2025-09-11 23:56:41'),(25,25,0.00,0.00,0.00,'paid',0.00,NULL,'2025-09-11 23:57:14','2025-09-12 00:01:39');
/*!40000 ALTER TABLE `session_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('dHxi2px5XMCKIfur0bUtErSxCIpxjT79uezJ913v',12,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFp1ZHBjSGlUQWEyMkdVS3JFR2JWT2ZKSkZBeER1cTZ3bU1taGthayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ib29raW5nLXJlcXVlc3RzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==',1757685771);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `subscription_type` enum('weekly','monthly') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','expired','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_user_id_foreign` (`user_id`),
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `start_at` timestamp NOT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `expected_end_date` timestamp NULL DEFAULT NULL,
  `session_status` enum('active','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `session_category` enum('hourly','subscription','overtime') COLLATE utf8mb4_unicode_ci DEFAULT 'hourly',
  `user_id` bigint unsigned NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `session_owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_internet_cost` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_sessions_user_id_foreign` (`user_id`),
  CONSTRAINT `user_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sessions`
--

LOCK TABLES `user_sessions` WRITE;
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` VALUES (2,'2025-08-28 09:50:39','2025-08-28 10:38:59',NULL,'completed','hourly',15,NULL,NULL,4.01,'2025-08-28 09:50:39','2025-09-01 08:49:27','2025-09-01 08:49:27'),(3,'2025-08-28 17:24:48','2025-08-28 18:05:15',NULL,'completed','hourly',15,NULL,NULL,55.00,'2025-08-28 17:24:48','2025-09-01 08:49:27','2025-09-01 08:49:27'),(4,'2025-08-28 19:17:19','2025-08-28 19:49:08',NULL,'completed','hourly',15,NULL,NULL,NULL,'2025-08-28 19:17:19','2025-09-01 08:49:27','2025-09-01 08:49:27'),(5,'2025-08-29 22:12:00','2025-08-30 00:28:31',NULL,'completed','overtime',15,NULL,NULL,NULL,'2025-08-30 00:12:15','2025-09-01 08:49:27','2025-09-01 08:49:27'),(6,'2025-08-30 00:43:55','2025-09-23 22:08:00','2025-09-30 00:43:00','completed','subscription',15,NULL,NULL,NULL,'2025-08-30 00:43:55','2025-09-01 08:49:27','2025-09-01 08:49:27'),(7,'2025-08-30 01:09:33','2025-09-10 01:13:00','2025-09-10 01:09:00','completed','subscription',15,NULL,NULL,NULL,'2025-08-30 01:09:33','2025-09-01 08:49:27','2025-09-01 08:49:27'),(8,'2025-08-30 01:16:51','2025-08-30 03:50:44',NULL,'completed','hourly',15,NULL,NULL,NULL,'2025-08-30 01:16:51','2025-09-01 08:49:27','2025-09-01 08:49:27'),(9,'2025-08-30 01:19:53','2025-08-30 01:57:00','2025-08-30 01:20:00','completed','subscription',16,NULL,NULL,550.00,'2025-08-30 01:19:53','2025-09-01 08:49:27','2025-09-01 08:49:27'),(10,'2025-08-30 02:19:01','2025-08-30 03:12:00',NULL,'completed','subscription',55,NULL,NULL,180.00,'2025-08-30 02:19:01','2025-09-01 08:49:27','2025-09-01 08:49:27'),(11,'2025-08-30 14:16:30','2025-08-31 18:14:00',NULL,'completed','subscription',55,NULL,NULL,180.00,'2025-08-30 14:16:30','2025-09-01 08:49:27','2025-09-01 08:49:27'),(12,'2025-08-31 18:14:44','2025-08-31 18:16:00',NULL,'completed','subscription',55,NULL,NULL,1200.00,'2025-08-31 18:14:44','2025-09-01 08:49:27','2025-09-01 08:49:27'),(13,'2025-09-01 11:55:59','2025-09-01 12:01:57',NULL,'completed','hourly',15,NULL,NULL,NULL,'2025-09-01 11:55:59','2025-09-01 12:02:11','2025-09-01 12:02:11'),(14,'2025-09-01 11:58:48',NULL,NULL,'active','hourly',16,NULL,NULL,100.00,'2025-09-01 11:58:48','2025-09-01 11:59:29','2025-09-01 11:59:29'),(15,'2025-09-01 12:45:00','2025-09-01 13:32:03',NULL,'completed','hourly',15,'test',NULL,1400.00,'2025-09-01 12:41:13','2025-09-01 13:34:14','2025-09-01 13:34:14'),(16,'2025-09-01 13:40:31','2025-09-01 13:57:56',NULL,'completed','hourly',15,'انس',NULL,900.00,'2025-09-01 13:40:31','2025-09-01 14:01:22',NULL),(17,'2025-09-01 14:03:58','2025-09-01 14:04:22',NULL,'cancelled','hourly',15,NULL,NULL,190.00,'2025-09-01 14:03:58','2025-09-01 15:40:05',NULL),(18,'2025-09-01 14:20:02',NULL,NULL,'active','subscription',57,'test',NULL,NULL,'2025-09-01 14:20:02','2025-09-01 14:20:02',NULL),(19,'2025-09-01 14:36:47','2025-09-11 23:48:32',NULL,'completed','hourly',15,NULL,NULL,NULL,'2025-09-01 14:36:47','2025-09-11 23:48:32',NULL),(20,'2025-09-01 21:28:51','2025-09-01 21:29:10',NULL,'completed','hourly',16,NULL,NULL,100.00,'2025-09-01 21:28:51','2025-09-01 21:29:10',NULL),(21,'2025-09-01 05:00:00','2025-09-02 12:10:00','2025-09-15 05:00:00','completed','subscription',58,NULL,NULL,275.00,'2025-09-02 12:06:42','2025-09-02 12:10:54',NULL),(22,'2025-09-01 17:00:00',NULL,'2025-09-15 17:00:00','active','subscription',58,NULL,NULL,275.00,'2025-09-02 12:27:23','2025-09-02 12:28:58',NULL),(23,'2025-09-11 23:27:21','2025-09-11 23:27:40',NULL,'completed','hourly',16,NULL,NULL,NULL,'2025-09-11 23:27:21','2025-09-11 23:27:40',NULL),(24,'2025-09-11 23:38:44','2025-09-11 23:56:32',NULL,'completed','hourly',16,NULL,'هبة الطناني',NULL,'2025-09-11 23:38:44','2025-09-11 23:56:32',NULL),(25,'2025-09-11 23:57:14',NULL,NULL,'active','hourly',15,NULL,NULL,NULL,'2025-09-11 23:57:14','2025-09-11 23:57:14',NULL);
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_wallets`
--

DROP TABLE IF EXISTS `user_wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_wallets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_wallets_user_id_foreign` (`user_id`),
  CONSTRAINT `user_wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_wallets`
--

LOCK TABLES `user_wallets` WRITE;
/*!40000 ALTER TABLE `user_wallets` DISABLE KEYS */;
INSERT INTO `user_wallets` VALUES (1,14,0.00,'2025-08-28 09:31:22','2025-08-28 09:31:22'),(2,55,0.00,'2025-08-29 23:28:38','2025-08-29 23:28:38'),(3,57,0.00,'2025-09-01 13:37:53','2025-09-01 13:37:53'),(4,58,0.00,'2025-09-02 12:06:34','2025-09-02 12:06:34');
/*!40000 ALTER TABLE `user_wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` enum('hourly','subscription','admin','manager') COLLATE utf8mb4_unicode_ci DEFAULT 'hourly',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (12,'مدير النظام','admin@branchhub.com',NULL,'$2y$12$XPhXIFPS.hF2OEMH.rDGoOzhVZpfAWHjMUBJQklouRfVBXCF6FCay',NULL,'2025-08-28 09:26:20','2025-09-12 14:01:56','admin','0500000000','active','2025-09-12 14:01:56',NULL),(13,'مستخدم إداري','manager@branchhub.com',NULL,'$2y$12$F8KvVaMH9CK0oR5wInqee.0.NQCXLuq05NRaHr6cLEauD9WKoEe3y',NULL,'2025-08-28 09:26:20','2025-08-28 09:26:20','manager','0500000001','active',NULL,NULL),(14,'ضضض','aaaaa@gmail.com',NULL,'$2y$12$9ZyF/zatxKvOEZTH8ZKunOt74/NcUaYXn4gCKsbVYRLIwgfa6iOpO',NULL,'2025-08-28 09:31:22','2025-08-28 09:31:37','hourly','1232323','inactive',NULL,'2025-08-28 09:31:37'),(15,'Branch1','Branch1@gmail.com',NULL,'$2y$12$6xyIwqQg3tXKPooDyLZ/5us3BekLbLpL3huDBACb.xClxI7eb4AAm',NULL,'2025-08-28 09:33:11','2025-08-28 09:33:11','hourly','11111111111','active',NULL,NULL),(16,'Branch2','Branch2@gmail.com',NULL,'$2y$12$O0Wq6s8.we2ohSjojrmgdeXuYUf50HcOckSBXr.3w.U2tNgE.al7O',NULL,'2025-08-28 09:33:12','2025-08-28 09:33:12','hourly','11111111111','active',NULL,NULL),(17,'Branch3','Branch3@gmail.com',NULL,'$2y$12$v0Zh1zIuYfHm28c4fYlCsOlRE6YF2sOz6z/xpdCK2gU6Ci98MI4vq',NULL,'2025-08-28 09:33:12','2025-08-28 09:33:12','hourly','11111111111','active',NULL,NULL),(18,'Branch4','Branch4@gmail.com',NULL,'$2y$12$qdH93Fo7khAbqNpSlKaMxOY.j1ZrAq9W6Y8L4DUibIrGmQuZkGVty',NULL,'2025-08-28 09:33:12','2025-08-28 09:33:12','hourly','11111111111','active',NULL,NULL),(19,'Branch5','Branch5@gmail.com',NULL,'$2y$12$aVuWDoZyKKRuGSGPkjK4b.PqzHhnkMTsq/Z6noHxOCRc9Aex3RDqy',NULL,'2025-08-28 09:33:13','2025-08-28 09:33:13','hourly','11111111111','active',NULL,NULL),(20,'Branch6','Branch6@gmail.com',NULL,'$2y$12$18eeoiXDtfQLYePNh1A0.Ow0Lkb81OT1XQXp/.g/dlBP58JoHnhrC',NULL,'2025-08-28 09:33:13','2025-08-28 09:33:13','hourly','11111111111','active',NULL,NULL),(21,'Branch7','Branch7@gmail.com',NULL,'$2y$12$crL45PYuObwxKhAuYTlk3eR00RojBHVFTwJwXXpgXm9TiHDHSViQ.',NULL,'2025-08-28 09:33:14','2025-08-28 09:33:14','hourly','11111111111','active',NULL,NULL),(22,'Branch8','Branch8@gmail.com',NULL,'$2y$12$8lAc4PcYf4jYFBYl4SSwBuECEZZnXqv6Oh9kDifoaIz3K.UL/G4Z.',NULL,'2025-08-28 09:33:14','2025-08-28 09:33:14','hourly','11111111111','active',NULL,NULL),(23,'Branch9','Branch9@gmail.com',NULL,'$2y$12$IosrZOZ81GIhJaO/XrKbn./KN6pPxNSh2/ZMr8rqfpSoYABL6FPOu',NULL,'2025-08-28 09:33:14','2025-08-28 09:33:14','hourly','11111111111','active',NULL,NULL),(24,'Branch10','Branch10@gmail.com',NULL,'$2y$12$gwy4MQnTxK4BLHyntBlNiODFzUXtYrZHUECm56LCLGIvPn/3L9dj2',NULL,'2025-08-28 09:33:14','2025-08-28 09:33:14','hourly','11111111111','active',NULL,NULL),(25,'Branch11','Branch11@gmail.com',NULL,'$2y$12$lI/PEKnwjamkJgLKmFTnFO0vzApOQ1nJuXA7u/G/Uw8K.DGeimyu2',NULL,'2025-08-28 09:33:15','2025-08-28 09:33:15','hourly','11111111111','active',NULL,NULL),(26,'Branch12','Branch12@gmail.com',NULL,'$2y$12$hDY1qtizgXlySKNd8UteuOq1zzoQ/HhbLbjekZZ0t2iyis5WFn.AO',NULL,'2025-08-28 09:33:15','2025-08-28 09:33:15','hourly','11111111111','active',NULL,NULL),(27,'Branch13','Branch13@gmail.com',NULL,'$2y$12$h584NkflWT3GglfUU7GCMOuRK7r2S4f/uymIqNK/cowlDqw6V31km',NULL,'2025-08-28 09:33:16','2025-08-28 09:33:16','hourly','11111111111','active',NULL,NULL),(28,'Branch14','Branch14@gmail.com',NULL,'$2y$12$kXt2awQadWguKjCutgZnneHJCT3ASomhDbXVwzfTO.qC2aNrO39AS',NULL,'2025-08-28 09:33:16','2025-08-28 09:33:16','hourly','11111111111','active',NULL,NULL),(29,'Branch15','Branch15@gmail.com',NULL,'$2y$12$HKzQu1pUSEdCH0Dm3ct.Y.Ds8mLQjyyf5x6Ea5SdvV.GQjNOlw.LW',NULL,'2025-08-28 09:33:16','2025-08-28 09:33:16','hourly','11111111111','active',NULL,NULL),(30,'Branch16','Branch16@gmail.com',NULL,'$2y$12$8Vhyv8mpttuGVeihBxjKJu4nVHQCsgT7bVtN043argsvZsOAW6hoe',NULL,'2025-08-28 09:33:16','2025-08-28 09:33:16','hourly','11111111111','active',NULL,NULL),(31,'Branch17','Branch17@gmail.com',NULL,'$2y$12$6eyxQXKSufG9.CbF5SlvduuUaap2anjvCkN5WKzp8BZmj3mF039Qq',NULL,'2025-08-28 09:33:17','2025-08-28 09:33:17','hourly','11111111111','active',NULL,NULL),(32,'Branch18','Branch18@gmail.com',NULL,'$2y$12$6eM1wWofFfbi.1nCrlk7w.TVXKXtTcWdEhswcQ8sR38kpM04g2zli',NULL,'2025-08-28 09:33:17','2025-08-28 09:33:17','hourly','11111111111','active',NULL,NULL),(33,'Branch19','Branch19@gmail.com',NULL,'$2y$12$KZAHd7XzJs2O5xtXNMnSNeDSD04yDMI6TjeauPHRxR2NMPf0aodjm',NULL,'2025-08-28 09:33:17','2025-08-28 09:33:17','hourly','11111111111','active',NULL,NULL),(34,'Branch20','Branch20@gmail.com',NULL,'$2y$12$S4QHUTOyhMAT8biGSCqkvOnz245LA9bHFh8Dqdbxv3BrFHCFE1hyy',NULL,'2025-08-28 09:33:17','2025-08-28 09:33:17','hourly','11111111111','active',NULL,NULL),(35,'Branch21','Branch21@gmail.com',NULL,'$2y$12$6318DXeCo/mMHLe1DVpPeOAtfbvt5ChKiq4kUcmFqsoiwKUUxUWuW',NULL,'2025-08-28 09:33:18','2025-08-28 09:33:18','hourly','11111111111','active',NULL,NULL),(36,'Branch22','Branch22@gmail.com',NULL,'$2y$12$KebuML0FK6HvAzCpx.QC9.2R70YvmB2nHy6HrO.M.T1mKIyaEBD0m',NULL,'2025-08-28 09:33:18','2025-08-28 09:33:18','hourly','11111111111','active',NULL,NULL),(37,'Branch23','Branch23@gmail.com',NULL,'$2y$12$oU5Gn/EAPgh8G0SwUwyjSO0BPOjqNscEZv1vuB9Eq6xlzN/YuiBc.',NULL,'2025-08-28 09:33:18','2025-08-28 09:33:18','hourly','11111111111','active',NULL,NULL),(38,'Branch24','Branch24@gmail.com',NULL,'$2y$12$NLx2vutZn3g1stZfBfsjk.vv9vnX2GDDeXOC89ic/xeVSIxBMcXyS',NULL,'2025-08-28 09:33:19','2025-08-28 09:33:19','hourly','11111111111','active',NULL,NULL),(39,'Branch25','Branch25@gmail.com',NULL,'$2y$12$.vrGieQUUEgXzguaI4xZQuZOmfK3Lgjf6/iS/mECS6QnOyrwLQBuy',NULL,'2025-08-28 09:33:19','2025-08-28 09:33:19','hourly','11111111111','active',NULL,NULL),(40,'Branch26','Branch26@gmail.com',NULL,'$2y$12$Jf5atd7vg0I1tIniyJOBO.lViv4IyDbfOwbi7wDijkLVFBUhxGlRW',NULL,'2025-08-28 09:33:19','2025-08-28 09:33:19','hourly','11111111111','active',NULL,NULL),(41,'Branch27','Branch27@gmail.com',NULL,'$2y$12$2cJZ6ediJWnQ7DBBm61H9OnNC3jwbqlGlq2NKNy81I8wFYt6HnFdC',NULL,'2025-08-28 09:33:20','2025-08-28 09:33:20','hourly','11111111111','active',NULL,NULL),(42,'Branch28','Branch28@gmail.com',NULL,'$2y$12$OTUEWnX99c52yTLodqx/e.LoxF8dccqJDfctZdbOrTZQZ2EHY/REm',NULL,'2025-08-28 09:33:20','2025-08-28 09:33:20','hourly','11111111111','active',NULL,NULL),(43,'Branch29','Branch29@gmail.com',NULL,'$2y$12$KetyyszBwCxz7rC99Iz/uu4CY9CQg.vJRzFaaEi4ywqp4Wkby3RXW',NULL,'2025-08-28 09:33:20','2025-08-28 09:33:20','hourly','11111111111','active',NULL,NULL),(44,'Branch30','Branch30@gmail.com',NULL,'$2y$12$ycdJ3zIgf9etZjHmhR.m1OIDow6v/lnCHv.R7Xe3BQaQwtnlP7MUe',NULL,'2025-08-28 09:33:20','2025-08-28 09:33:20','hourly','11111111111','active',NULL,NULL),(45,'Branch31','Branch31@gmail.com',NULL,'$2y$12$lfSMNXcuA4QXMDa5lU7l7u5RhW7kIoVgyMeBBEj8j.j2gdjYQZ6Ha',NULL,'2025-08-28 09:33:21','2025-08-28 09:33:21','hourly','11111111111','active',NULL,NULL),(46,'Branch32','Branch32@gmail.com',NULL,'$2y$12$mUmAH2ZdOBbKqMXwPe9OFuLB80X8vvMBlXCqKatdY7Rfo6dVyNAku',NULL,'2025-08-28 09:33:21','2025-08-28 09:33:21','hourly','11111111111','active',NULL,NULL),(47,'Branch33','Branch33@gmail.com',NULL,'$2y$12$OklZ9fK3q6CwVBtBCwgLBOqm43rBJkextvEVMzdEI.lAPnWqFQ0wu',NULL,'2025-08-28 09:33:21','2025-08-28 09:33:21','hourly','11111111111','active',NULL,NULL),(48,'Branch34','Branch34@gmail.com',NULL,'$2y$12$Su49C3n/zFyTzhxLECM02uacq5HmMUyQgmahxSW3q38NyksMF9x.K',NULL,'2025-08-28 09:33:22','2025-08-28 09:33:22','hourly','11111111111','active',NULL,NULL),(49,'Branch35','Branch35@gmail.com',NULL,'$2y$12$FuoZW8vosI.8xFLcqpoRF.Z/Ke/WUBXaiu.9yZws58aPSE4BNOLxa',NULL,'2025-08-28 09:33:22','2025-08-28 09:33:22','hourly','11111111111','active',NULL,NULL),(50,'Branch36','Branch36@gmail.com',NULL,'$2y$12$RXuQ90FwLB.bCTnVz3q5..4um/.gnn820v882yulNFvbsAYupVnXC',NULL,'2025-08-28 09:33:22','2025-08-28 09:33:22','hourly','11111111111','active',NULL,NULL),(51,'Branch37','Branch37@gmail.com',NULL,'$2y$12$AukcEoNP55ArxAcpdG3n/ed5iV8Ai/UPhFixpWQw20.DXtOXKAWA6',NULL,'2025-08-28 09:33:22','2025-08-28 09:33:22','hourly','11111111111','active',NULL,NULL),(52,'Branch38','Branch38@gmail.com',NULL,'$2y$12$zmuNY3IlWykDYLFtXSDKm.HTAgdOiy5PxZDkywtPhTPc28wyq3tCm',NULL,'2025-08-28 09:33:23','2025-08-28 09:33:23','hourly','11111111111','active',NULL,NULL),(53,'Branch39','Branch39@gmail.com',NULL,'$2y$12$O3KHrZ/eMrTUvhA9evBspumDQZoTXT4ltt56js7afrHCuy6KZqe7O',NULL,'2025-08-28 09:33:23','2025-08-28 09:33:23','hourly','11111111111','active',NULL,NULL),(54,'Branch40','Branch40@gmail.com',NULL,'$2y$12$DkFvy9CmIUjV9kePNxOOpO1av.pMUwzxe3Sf1tgT3.1jMnSHwFHmy',NULL,'2025-08-28 09:33:23','2025-08-28 09:33:23','hourly','11111111111','active',NULL,NULL),(55,'حسام حماد','HousamHammad@gmail.com',NULL,'$2y$12$ofGvEOkEZFXqh09xrMZrvO.ZESN3h8KLNhiesbKqlo2NhmGnzMhQ6',NULL,'2025-08-29 23:28:38','2025-08-29 23:28:38','subscription','0234234234234','active',NULL,NULL),(57,'ساجد','sajed@gmail.com',NULL,'$2y$12$F1Hmz.ZLDbRV.Gs0Z2jHheJ9eN05p40US7JjZuARTMPmmM3Lg/eJO',NULL,'2025-09-01 13:37:53','2025-09-01 13:37:53','subscription','9720595661906','active',NULL,NULL),(58,'Osama Abo Saif','osama@branchhub.com',NULL,'$2y$12$XCNk8gU5rDAlHoLEXLXg7e5x8./IsOeH/PBJgpwoMvVq33bpXUX1i',NULL,'2025-09-02 12:06:34','2025-09-02 12:06:34','subscription','+972 59-288-3906','active',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('charge','deduct','refund') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'charge',
  `payment_method` enum('cash','bank_transfer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `amount` decimal(10,2) NOT NULL,
  `balance_before` decimal(10,2) NOT NULL,
  `balance_after` decimal(10,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-12 17:05:45
