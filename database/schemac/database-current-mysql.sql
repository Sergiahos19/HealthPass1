-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: healthpass1
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `analyse`
--

DROP TABLE IF EXISTS `analyse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analyse` (
  `id_analyse` varchar(191) NOT NULL,
  `date_analyse` date NOT NULL,
  `type_analyse` text NOT NULL,
  `prescription` text DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `statut` text NOT NULL,
  `priorite` text NOT NULL,
  `id_patient` varchar(191) NOT NULL,
  `id_docteur` varchar(191) NOT NULL,
  `id_service` varchar(191) NOT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `id_rendez_vous` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_analyse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analyse`
--

LOCK TABLES `analyse` WRITE;
/*!40000 ALTER TABLE `analyse` DISABLE KEYS */;
/*!40000 ALTER TABLE `analyse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `expiration` int(11) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` text NOT NULL,
  `expiration` int(11) NOT NULL,
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
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation` (
  `id_consultation` varchar(191) NOT NULL,
  `date_consultation` date NOT NULL,
  `heure` time DEFAULT NULL,
  `motif` text DEFAULT NULL,
  `symptomes` text DEFAULT NULL,
  `diagnostic` text DEFAULT NULL,
  `traitement` text DEFAULT NULL,
  `observation_medicale` text DEFAULT NULL,
  `id_patient` varchar(191) NOT NULL,
  `id_docteur` varchar(191) NOT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `id_rendez_vous` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_consultation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultation`
--

LOCK TABLES `consultation` WRITE;
/*!40000 ALTER TABLE `consultation` DISABLE KEYS */;
INSERT INTO `consultation` VALUES ('2e29df57-cada-48ed-b548-41a569dd6e74','2026-08-28','11:28:14','Fi??vre','Yeux jaunes','Fi??vre typho??de','A revoir','Etat critique','patient-sergio-exauce-demo','doctor-demo','etab-demo',NULL,NULL,NULL),('ed8e8a7c-ef99-448b-a20d-271a9499a009','2026-08-28','14:41:36','D??mangeaisons','Boutons\nAcn??e','Rougeole','Analyses',NULL,'a8addbc1-60c6-40dd-893b-cb6c333a74bf','doctor-demo','etab-demo',NULL,NULL,NULL);
/*!40000 ALTER TABLE `consultation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demande_analyse`
--

DROP TABLE IF EXISTS `demande_analyse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demande_analyse` (
  `id_demande` varchar(191) NOT NULL,
  `id_patient` varchar(191) NOT NULL,
  `id_docteur` text DEFAULT NULL,
  `id_service` varchar(191) NOT NULL,
  `id_format` varchar(191) NOT NULL,
  `priorite` text NOT NULL,
  `statut` text NOT NULL,
  `prescription` text DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `resultat` text DEFAULT NULL,
  `fichier_resultat` text DEFAULT NULL,
  `demande_at` datetime NOT NULL,
  `traitee_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_demande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande_analyse`
--

LOCK TABLES `demande_analyse` WRITE;
/*!40000 ALTER TABLE `demande_analyse` DISABLE KEYS */;
INSERT INTO `demande_analyse` VALUES ('6cb8a87c-9067-40ef-a1e0-01465014ed8b','a8addbc1-60c6-40dd-893b-cb6c333a74bf','doctor-demo','service-demo','80282810-5ff6-461b-bf0c-278ca303511b','Normale','Termin??','A voir','Prise en charge','PCR N??gative : Infection peu probable. Cependant, une PCR n??gative n\'exclut pas totalement la rougeole si le pr??l??vement a ??t?? r??alis?? trop tardivement (id??alement ?? faire dans les 3 ?? 10 jours apr??s le d??but de l\'??ruption).',NULL,'2026-08-28 14:47:15','2026-08-28 14:52:59','2026-08-28 14:47:15','2026-08-28 14:52:59'),('d23a6b97-10c8-4d78-90bb-cb9368919e76','patient-sergio-exauce-demo','doctor-demo','service-demo','c23798a7-5b9b-4092-94c1-f7d161c16070','Urgente','Termin??','ty','hg','Positif',NULL,'2026-08-28 11:55:59','2026-08-28 12:30:29','2026-08-28 11:55:59','2026-08-28 12:30:29');
/*!40000 ALTER TABLE `demande_analyse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docteur`
--

DROP TABLE IF EXISTS `docteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docteur` (
  `id_docteur` varchar(191) NOT NULL,
  `nom` text DEFAULT NULL,
  `prenom` text DEFAULT NULL,
  `specialite` text DEFAULT NULL,
  `telephone` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `mot_de_passe` text DEFAULT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `rpps_number` text DEFAULT NULL,
  `id_user` text DEFAULT NULL,
  `est_approuve` int(11) NOT NULL,
  PRIMARY KEY (`id_docteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docteur`
--

LOCK TABLES `docteur` WRITE;
/*!40000 ALTER TABLE `docteur` DISABLE KEYS */;
INSERT INTO `docteur` VALUES ('doctor-demo','Exaucé','Sergio','Médecine Générale','+229 01 56 03 68 00','medecin@healthpass.test','$2y$12$ZNK/BW.ngIjJxc0y6u5jCu8bKNSmd8jpOMYR93nojBu6PRc.VY4Xa','etab-demo',NULL,'user-doctor-demo',1);
/*!40000 ALTER TABLE `docteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etablissement`
--

DROP TABLE IF EXISTS `etablissement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etablissement` (
  `id_etablissement` varchar(191) NOT NULL,
  `nom_etablissement` text NOT NULL,
  `adresse` text NOT NULL,
  `telephone` text DEFAULT NULL,
  `email_etablissement` text DEFAULT NULL,
  `numero_ifu` text NOT NULL,
  `est_approuve` int(11) NOT NULL,
  PRIMARY KEY (`id_etablissement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etablissement`
--

LOCK TABLES `etablissement` WRITE;
/*!40000 ALTER TABLE `etablissement` DISABLE KEYS */;
INSERT INTO `etablissement` VALUES ('etab-demo','Etablissement HealthPass.Test','Cotonou','+229 01 56 03 68 00','healthpass19@gmail.com','IFU-DEMO-001',1);
/*!40000 ALTER TABLE `etablissement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facture` (
  `id_facture` varchar(42) NOT NULL,
  `numero_facture` varchar(60) NOT NULL,
  `id_patient` varchar(42) NOT NULL,
  `id_consultation` varchar(42) DEFAULT NULL,
  `id_caissier` varchar(42) DEFAULT NULL,
  `montant` decimal(12,2) NOT NULL,
  `devise` varchar(3) NOT NULL DEFAULT 'XOF',
  `statut` varchar(30) NOT NULL DEFAULT 'emise',
  `mode_paiement` varchar(40) DEFAULT NULL,
  `date_facture` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_facture`),
  UNIQUE KEY `facture_numero_facture_unique` (`numero_facture`),
  KEY `facture_id_consultation_foreign` (`id_consultation`),
  KEY `facture_id_caissier_foreign` (`id_caissier`),
  KEY `facture_id_patient_date_facture_index` (`id_patient`,`date_facture`),
  KEY `facture_statut_index` (`statut`),
  CONSTRAINT `facture_id_caissier_foreign` FOREIGN KEY (`id_caissier`) REFERENCES `utilisateur` (`id_user`) ON DELETE SET NULL,
  CONSTRAINT `facture_id_consultation_foreign` FOREIGN KEY (`id_consultation`) REFERENCES `consultation` (`id_consultation`) ON DELETE SET NULL,
  CONSTRAINT `facture_id_patient_foreign` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`id_patient`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facture`
--

LOCK TABLES `facture` WRITE;
/*!40000 ALTER TABLE `facture` DISABLE KEYS */;
INSERT INTO `facture` VALUES ('985214d3-bbf9-4046-9c49-8305958d3aba','HP-20260909163417-Z4GH','a8addbc1-60c6-40dd-893b-cb6c333a74bf',NULL,'user-cashier-demo',12233.00,'XOF','emise','Mobile money','2026-09-09','FGDFFG','2026-09-09 14:34:17','2026-09-09 14:34:17');
/*!40000 ALTER TABLE `facture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` text NOT NULL,
  `exception` text NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
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
-- Table structure for table `format`
--

DROP TABLE IF EXISTS `format`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `format` (
  `id_format` varchar(191) NOT NULL,
  `libelle_format` text NOT NULL,
  `type_examen` text DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `id_service` varchar(191) NOT NULL,
  PRIMARY KEY (`id_format`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `format`
--

LOCK TABLES `format` WRITE;
/*!40000 ALTER TABLE `format` DISABLE KEYS */;
INSERT INTO `format` VALUES ('80282810-5ff6-461b-bf0c-278ca303511b','D??tection virale par RT-PCR','D??tection virale par RT-PCR',NULL,'service-demo'),('c23798a7-5b9b-4092-94c1-f7d161c16070','Glyc??mie','Glyc??mie',NULL,'service-demo');
/*!40000 ALTER TABLE `format` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` text NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` text NOT NULL,
  `options` text DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queue` text NOT NULL,
  `payload` text NOT NULL,
  `attempts` int(11) NOT NULL,
  `reserved_at` int(11) DEFAULT NULL,
  `available_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` text NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_24_000003_create_healthpass_auth_tables',1),(5,'2026_08_24_000004_add_establishment_to_patients',1),(6,'2026_08_24_000005_add_patient_health_and_emergency_fields',1),(7,'2026_08_24_000006_create_appointments_table',1),(8,'2026_08_24_000007_create_services_table',1),(9,'2026_08_24_000008_create_waiting_room_entries_table',1),(10,'2026_08_24_000009_add_rpps_to_doctors_table',1),(11,'2026_08_24_000010_add_service_registration_fields',1),(12,'2026_08_24_000011_link_service_accounts',1),(13,'2026_08_27_000001_add_doctor_accounts_and_approval',1),(14,'2026_08_27_000002_repair_demo_doctor_account',1),(15,'2026_08_27_000003_create_doctor_clinical_tables',1),(16,'2026_08_27_000004_create_prescriptions_table',2),(17,'2026_08_27_000012_create_analysis_requests_table',3),(18,'2026_08_28_000001_add_super_admin_demo_account',4),(19,'2026_08_28_000002_create_password_reset_tokens_table',5),(20,'2026_08_30_000013_add_service_approval_fields',6),(21,'2026_09_09_000001_fix_sessions_user_id_type',6),(22,'2026_09_09_000002_simplify_to_single_establishment_and_add_billing',6),(23,'2026_09_09_000003_add_first_login_password_change',7),(24,'2026_09_09_000004_add_user_active_status',8),(25,'2026_09_09_000005_remove_super_admin_role',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
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
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `id_patient` varchar(191) NOT NULL,
  `id_user` varchar(42) DEFAULT NULL,
  `npi` text DEFAULT NULL,
  `nom` text DEFAULT NULL,
  `prenom` text DEFAULT NULL,
  `sexe` text DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `email` text DEFAULT NULL,
  `telephone` text DEFAULT NULL,
  `empreinte_digitale` text DEFAULT NULL,
  `id_etablissement` text DEFAULT NULL,
  `taille` decimal(12,4) DEFAULT NULL,
  `poids` decimal(12,4) DEFAULT NULL,
  `groupe_sanguin` text DEFAULT NULL,
  `contact_urgence_nom` text DEFAULT NULL,
  `contact_urgence_lien` text DEFAULT NULL,
  `contact_urgence_telephone` text DEFAULT NULL,
  `contact_urgence_email` text DEFAULT NULL,
  `contact_urgence_adresse` text DEFAULT NULL,
  PRIMARY KEY (`id_patient`),
  UNIQUE KEY `patient_id_user_unique` (`id_user`),
  CONSTRAINT `patient_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES ('a8addbc1-60c6-40dd-893b-cb6c333a74bf',NULL,NULL,'Kelly','Exaucé','M','2004-05-21','exaucehamelo219@gmail.com','01 62 09 75 08',NULL,'etab-demo',1.8000,50.0000,'O-','Ahossi Sergio','Ami','0156036800','ahossisergio19@gmail.com','Bohicon'),('patient-sergio-exauce-demo',NULL,'NPI-BJ-DEMO-0001','SERGIO','Exaucé','M','1992-05-14','sergioahossi19@gmail.com','+229 97 45 18 62',NULL,'etab-demo',1.7400,72.0000,'O+','Afi Sergio','Sœur','+229 96 32 74 11','afi.sergio@healthpass.test','Abomey-Calavi, Bénin');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescription` (
  `id_prescription` varchar(191) NOT NULL,
  `id_patient` varchar(191) NOT NULL,
  `id_docteur` varchar(191) NOT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `medicament` text NOT NULL,
  `dosage` text DEFAULT NULL,
  `duree_jours` int(11) DEFAULT NULL,
  `frequence` text DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_prescription` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_prescription`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescription`
--

LOCK TABLES `prescription` WRITE;
/*!40000 ALTER TABLE `prescription` DISABLE KEYS */;
INSERT INTO `prescription` VALUES ('1b418724-9558-4d68-a0a9-1a8a7b5504ff','a8addbc1-60c6-40dd-893b-cb6c333a74bf','doctor-demo','etab-demo','Priorix','750 mg',3,'2x/j',2,'2026-08-28','2026-08-28 14:43:17','2026-08-28 14:43:17'),('c07cb78d-c394-4fc4-a956-22613b3cc21c','patient-sergio-exauce-demo','doctor-demo','etab-demo','Cipronat','750 mg',7,NULL,14,'2026-08-28','2026-08-28 11:29:59','2026-08-28 11:29:59');
/*!40000 ALTER TABLE `prescription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rendez_vous`
--

DROP TABLE IF EXISTS `rendez_vous`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rendez_vous` (
  `id_rendez_vous` varchar(191) NOT NULL,
  `id_patient` varchar(191) NOT NULL,
  `id_docteur` varchar(191) NOT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `date_rdv` date NOT NULL,
  `heure_rdv` time NOT NULL,
  `motif` text DEFAULT NULL,
  `statut` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rendez_vous`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rendez_vous`
--

LOCK TABLES `rendez_vous` WRITE;
/*!40000 ALTER TABLE `rendez_vous` DISABLE KEYS */;
INSERT INTO `rendez_vous` VALUES ('75e6acd2-2c43-43a7-b705-623c744a3fe0','a8addbc1-60c6-40dd-893b-cb6c333a74bf','doctor-demo','etab-demo','2026-08-28','14:38:00','Premi??re consultation','Planifi??','2026-08-28 14:35:10','2026-08-28 14:35:10'),('81bafdbe-ff4c-4665-b1fa-85f1ec817c3e','a8addbc1-60c6-40dd-893b-cb6c333a74bf','doctor-demo','etab-demo','2026-09-09','17:56:00','Première consultation','Planifié','2026-09-09 16:56:52','2026-09-09 16:56:52'),('rdv-sergio-exauce-demo','patient-sergio-exauce-demo','doctor-demo','etab-demo','2026-09-09','14:00:00','Première consultation','Planifié',NULL,'2026-09-09 16:57:09');
/*!40000 ALTER TABLE `rendez_vous` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id_role` varchar(191) NOT NULL,
  `libelle_role` text NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES ('role-admin','administrateur'),('role-cashier','caissier / facturation'),('role-doctor','medecin'),('role-patient','patient'),('role-service','service');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salle_attente`
--

DROP TABLE IF EXISTS `salle_attente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salle_attente` (
  `id_attente` varchar(191) NOT NULL,
  `id_patient` varchar(191) NOT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `arrivee_at` datetime NOT NULL,
  `statut` text NOT NULL,
  PRIMARY KEY (`id_attente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salle_attente`
--

LOCK TABLES `salle_attente` WRITE;
/*!40000 ALTER TABLE `salle_attente` DISABLE KEYS */;
/*!40000 ALTER TABLE `salle_attente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id_service` varchar(191) NOT NULL,
  `nom_service` text NOT NULL,
  `type_service` text DEFAULT NULL,
  `telephone` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `id_etablissement` varchar(191) NOT NULL,
  `est_approuve` tinyint(1) NOT NULL DEFAULT 0,
  `est_actif` tinyint(1) NOT NULL DEFAULT 0,
  `batiment` text DEFAULT NULL,
  `etage` text DEFAULT NULL,
  `chef_prenom` text DEFAULT NULL,
  `chef_nom` text DEFAULT NULL,
  `mot_de_passe` text DEFAULT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES ('service-demo','Laboratoire Central','Laboratoire','+229 21 00 00 00','laboratoire@healthpass.test','etab-demo',1,0,'Pavillon A','1er étage','','Kelly','$2y$12$fL7kdxmSQCRCLaaA8udD5uwR4ig.6ktkLV7yLQm/6AnwRDQ2G7126');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` varchar(191) DEFAULT NULL,
  `ip_address` text DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('lqsL253Q6lsLohIWXzaaEKIR4loU8SVduwlh63kU',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJNaW16SWdGbW1pQ055RnNWWUZDR2NDcWVOUlVxdnk2bWxLNTk0dDdwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=',1788971715);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` text NOT NULL,
  `remember_token` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id_user` varchar(191) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` varchar(191) NOT NULL,
  `mot_de_passe` text NOT NULL,
  `id_role` varchar(191) NOT NULL,
  `id_etablissement` text DEFAULT NULL,
  `id_service` text DEFAULT NULL,
  `doit_changer_mot_de_passe` tinyint(1) NOT NULL DEFAULT 0,
  `est_actif` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES ('user-admin-demo','Sergio.Kelly','Admin','admin@healthpass.test','$2y$12$vlee.QtlZPn1tUz2k833zuVfAPeuMSVsmrwptkFcW4Zoe0I5x2kXi','role-admin','etab-demo',NULL,0,1),('user-cashier-demo','Caissier','Demo','caissier@healthpass.test','$2y$12$b7eGUF9BhDdTnJdRybYy6OyPfCRDDn4ETL9GxiWd5rwl6shSHdp8y','role-cashier','etab-demo',NULL,0,1),('user-doctor-demo','Exaucé','Sergio','medecin@healthpass.test','$2y$12$xCWUpD69yZsO9Wh9xbZEJ.CwixQZPk/ByAG7T1qkNnL4NPWv1UCKK','role-doctor','etab-demo',NULL,0,1),('user-service-demo','Kelly','','laboratoire@healthpass.test','$2y$12$8laTPAQHIctvkQ4LZnOacuIBPFRymbbIENcfKfZFayISfuY9JshRu','role-service','etab-demo','service-demo',0,1);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'healthpass1'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-09 18:40:55
