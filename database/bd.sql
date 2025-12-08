-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.4.3 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour edulink
CREATE DATABASE IF NOT EXISTS `edulink` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `edulink`;

-- Listage des données de la table edulink.departements : ~10 rows (environ)
INSERT INTO `departements` (`id`, `id_faculte`, `nom`, `description`, `created_at`, `updated_at`) VALUES
	(12, 1, 'Informatique', 'Département responsable des enseignements et recherches en informatique, systèmes et réseaux.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(13, 1, 'Mathématiques', 'Département des mathématiques fondamentales et appliquées.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(14, 1, 'Génie Électrique', 'Département orienté vers l’électronique, l’électricité et l’automatique.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(15, 1, 'Génie Civil', 'Département dédié aux infrastructures, structures et travaux publics.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(16, 2, 'Gestion', 'Département axé sur la gestion, ressources humaines et management.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(17, 2, 'Comptabilité & Finance', 'Département dédié à la comptabilité, audit et finance.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(18, 2, 'Économie', 'Département des sciences économiques, microéconomie et macroéconomie.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(19, 3, 'Lettres Modernes', 'Département des langues, littérature et communication.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(20, 3, 'Histoire-Géographie', 'Département des sciences historiques et géographiques.', '2025-12-03 14:21:13', '2025-12-03 14:21:13'),
	(21, 3, 'Philosophie', 'Département de philosophie et sciences humaines.', '2025-12-03 14:21:13', '2025-12-03 14:21:13');

-- Listage des données de la table edulink.facultes : ~7 rows (environ)
INSERT INTO `facultes` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Faculté des Sciences et Technologies', NULL, '2025-12-03 12:40:36', '2025-12-03 12:40:36'),
	(2, 'Sciences et Technologies', 'Faculté regroupant les filières scientifiques telles que l’informatique, les mathématiques, le génie électrique et civil.', '2025-12-03 14:21:12', '2025-12-03 14:21:12'),
	(3, 'Sciences Économiques et Gestion', 'Faculté orientée vers l’économie, la gestion, la comptabilité et la finance.', '2025-12-03 14:21:12', '2025-12-03 14:21:12'),
	(4, 'Lettres et Sciences Humaines', 'Faculté dédiée aux lettres, langues, histoire-géographie et philosophie.', '2025-12-03 14:21:12', '2025-12-03 14:21:12'),
	(5, 'Sciences de la Santé', 'Faculté englobant médecine, biologie médicale, pharmacie et soins infirmiers.', '2025-12-03 14:21:12', '2025-12-03 14:21:12'),
	(6, 'Droit et Sciences Juridiques', 'Faculté spécialisée dans le droit privé, droit public et sciences politiques.', '2025-12-03 14:21:12', '2025-12-03 14:21:12'),
	(7, ',vhjv', 'lbjbk', '2025-12-03 13:59:01', '2025-12-03 13:59:01');

-- Listage des données de la table edulink.permissions : ~25 rows (environ)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'gerer_structure_pedagogique', 'web', '2025-12-03 12:40:23', '2025-12-03 12:40:23'),
	(2, 'gerer_enseignants', 'web', '2025-12-03 12:40:23', '2025-12-03 12:40:23'),
	(3, 'lister_etudiants', 'web', '2025-12-03 12:40:23', '2025-12-03 12:40:23'),
	(4, 'creer_etudiant', 'web', '2025-12-03 12:40:24', '2025-12-03 12:40:24'),
	(5, 'modifier_etudiant', 'web', '2025-12-03 12:40:24', '2025-12-03 12:40:24'),
	(6, 'supprimer_etudiant', 'web', '2025-12-03 12:40:24', '2025-12-03 12:40:24'),
	(7, 'consulter_dossier_etudiant', 'web', '2025-12-03 12:40:24', '2025-12-03 12:40:24'),
	(8, 'gerer_candidatures', 'web', '2025-12-03 12:40:25', '2025-12-03 12:40:25'),
	(9, 'gerer_inscriptions', 'web', '2025-12-03 12:40:25', '2025-12-03 12:40:25'),
	(10, 'saisir_notes', 'web', '2025-12-03 12:40:25', '2025-12-03 12:40:25'),
	(11, 'modifier_toutes_les_notes', 'web', '2025-12-03 12:40:26', '2025-12-03 12:40:26'),
	(12, 'consulter_ses_notes', 'web', '2025-12-03 12:40:26', '2025-12-03 12:40:26'),
	(13, 'gerer_stages', 'web', '2025-12-03 12:40:26', '2025-12-03 12:40:26'),
	(14, 'suivre_stages_tuteur', 'web', '2025-12-03 12:40:27', '2025-12-03 12:40:27'),
	(15, 'gerer_son_stage', 'web', '2025-12-03 12:40:27', '2025-12-03 12:40:27'),
	(16, 'gerer_emplois_du_temps', 'web', '2025-12-03 12:40:27', '2025-12-03 12:40:27'),
	(17, 'consulter_son_emploi_du_temps', 'web', '2025-12-03 12:40:28', '2025-12-03 12:40:28'),
	(18, 'gerer_paiements', 'web', '2025-12-03 12:40:28', '2025-12-03 12:40:28'),
	(19, 'consulter_ses_paiements', 'web', '2025-12-03 12:40:28', '2025-12-03 12:40:28'),
	(20, 'voir_roles', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29'),
	(21, 'consulter_stats_generales', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29'),
	(22, 'gerer_parametre_generaux', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29'),
	(23, 'gerer_roles_permissions', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29'),
	(24, 'consulter_journal_activites', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29'),
	(25, 'paramettre_admin', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29');

-- Listage des données de la table edulink.roles : ~8 rows (environ)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'etudiant', 'web', '2025-12-03 12:40:29', '2025-12-03 12:40:29'),
	(2, 'enseignant', 'web', '2025-12-03 12:40:30', '2025-12-03 12:40:30'),
	(3, 'secretaire', 'web', '2025-12-03 12:40:30', '2025-12-03 12:40:30'),
	(4, 'responsable_stage', 'web', '2025-12-03 12:40:30', '2025-12-03 12:40:30'),
	(5, 'responsable_etude', 'web', '2025-12-03 12:40:31', '2025-12-03 12:40:31'),
	(6, 'comptable', 'web', '2025-12-03 12:40:31', '2025-12-03 12:40:31'),
	(7, 'directeur_general', 'web', '2025-12-03 12:40:32', '2025-12-03 12:40:32'),
	(8, 'admin', 'web', '2025-12-03 12:40:32', '2025-12-03 12:40:32');

-- Listage des données de la table edulink.role_has_permissions : ~72 rows (environ)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(7, 1),
	(12, 1),
	(15, 1),
	(17, 1),
	(19, 1),
	(7, 2),
	(10, 2),
	(14, 2),
	(17, 2),
	(3, 3),
	(4, 3),
	(5, 3),
	(7, 3),
	(8, 3),
	(9, 3),
	(17, 3),
	(18, 3),
	(3, 4),
	(7, 4),
	(13, 4),
	(17, 4),
	(1, 5),
	(2, 5),
	(3, 5),
	(5, 5),
	(7, 5),
	(8, 5),
	(9, 5),
	(11, 5),
	(16, 5),
	(17, 5),
	(20, 5),
	(3, 6),
	(7, 6),
	(18, 6),
	(1, 7),
	(2, 7),
	(3, 7),
	(7, 7),
	(8, 7),
	(9, 7),
	(11, 7),
	(16, 7),
	(18, 7),
	(20, 7),
	(21, 7),
	(24, 7),
	(1, 8),
	(2, 8),
	(3, 8),
	(4, 8),
	(5, 8),
	(6, 8),
	(7, 8),
	(8, 8),
	(9, 8),
	(10, 8),
	(11, 8),
	(12, 8),
	(13, 8),
	(14, 8),
	(15, 8),
	(16, 8),
	(17, 8),
	(18, 8),
	(19, 8),
	(20, 8),
	(21, 8),
	(22, 8),
	(23, 8),
	(24, 8),
	(25, 8);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
