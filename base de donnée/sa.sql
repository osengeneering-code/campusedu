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


-- Listage de la structure de la base pour gestauto
CREATE DATABASE IF NOT EXISTS `gestauto` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestauto`;

-- Listage des données de la table gestauto.clients : ~2 rows (environ)
INSERT INTO `clients` (`id`, `entreprise_id`, `type_client`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `adresse_facturation`, `notes`, `logo`, `fiche_circuit_path`, `est_assure`, `numero_assurance_personnel`, `document_assurance_personnel_path`, `identifiant_piece`, `type_piece_client`, `chemin_piece_client`, `chemin_fiche_circuit`, `chemin_piece_dg`, `date_enregistrement`, `created_at`, `updated_at`) VALUES
	(1, 1, 'particulier', 'Methe', 'Lorna', 'lornaessono@gmail.com', '074896032', 'Libreville', NULL, NULL, NULL, NULL, 0, NULL, NULL, '25446F77G888B', 'Permis de conduire', 'client_documents/pjH4UMvOl9K8WdW0bI4U9rd1qOdroahpD4S7doX6.png', NULL, NULL, '2025-11-21', '2025-11-21 20:40:40', '2025-11-21 20:40:40'),
	(2, 1, 'particulier', 'Abeme Nzue', 'Paul', 'abemnzue@gmail.com', '074896032', 'Libreville', NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ZE39420398', 'Permis de conduire', 'client_documents/GJ0VncMiZkd6SI39H5AKAIfvgV25IaTs1UNreIj5.pdf', NULL, NULL, '2025-11-22', '2025-11-22 12:59:34', '2025-11-22 12:59:34');

-- Listage des données de la table gestauto.entreprises : ~1 rows (environ)
INSERT INTO `entreprises` (`id`, `uuid`, `nom`, `adresse`, `email`, `telephone`, `numero_identification`, `logo`, `created_at`, `updated_at`) VALUES
	(1, 'a0a1a2a3-b4b5-c6c7-d8d9-e0e1e2e3e4e5', 'AutoParc', '456 Avenue de l\'Innovation', 'contact@autopac.com', '(+241) 65 11 06 42', 'OSIT123456789', 'logos/q2l2DifMJH9zboNEWB4EfMMtV5cJZnJfcsFy2YUE.png', '2025-11-21 16:27:37', '2025-11-21 19:50:56');

-- Listage des données de la table gestauto.marques : ~25 rows (environ)
INSERT INTO `marques` (`id`, `nom`, `logo`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Toyota', 'marques_logos/EYeQGDRiXeg4jFh8cD0JKYrvGvtNZF8ZDsVAiQ9M.png', 'Toyota, leader en Afrique pour sa fiabilité et disponibilité des pièces.', '2025-11-12 12:36:38', '2025-11-12 11:39:06'),
	(2, 'Hyundai', 'marques_logos/jsKWuhjERSFeZSoI9v74on82vmMVy0wjz2DhQj2H.png', 'Hyundai, populaire pour ses modèles abordables et économiques.', '2025-11-12 12:36:38', '2025-11-12 11:39:33'),
	(3, 'Nissan', 'marques_logos/fD0C26ldfjjiHhj8aTt6W3Su8rlAk5tFDlYUptda.png', 'Nissan, très utilisé pour les pick-ups et SUV.', '2025-11-12 12:36:38', '2025-11-12 11:40:00'),
	(4, 'Kia', 'marques_logos/iQ22BF7QkiFrrb6spEIFcc1fp1fB8FbC0dfJWtUg.png', 'Kia, connu pour ses voitures compactes et fiables.', '2025-11-12 12:36:38', '2025-11-12 11:40:18'),
	(5, 'Suzuki', 'marques_logos/62vSuP7V24OjX4vXHnc3dkgYNM1UmbR1JK4HQpVx.png', 'Suzuki, adapté aux petits budgets et véhicules urbains.', '2025-11-12 12:36:38', '2025-11-12 12:00:38'),
	(6, 'Honda', 'marques_logos/pACgcQSKnuScd2iv7mzjxawY3O8NnEjpKoiYdo3t.png', 'Honda, réputé pour sa durabilité et ses moteurs fiables.', '2025-11-12 12:36:38', '2025-11-12 12:06:09'),
	(7, 'Ford', 'marques_logos/NdqK5pqOloTDB7I150yRyanPEDamq7RJf69h7O2K.png', 'Ford, populaire pour les utilitaires et pick-ups.', '2025-11-12 12:36:38', '2025-11-12 12:05:26'),
	(8, 'Mitsubishi', 'marques_logos/URWQbrUC0t22UvJKp3pdsoWUEGj9jlm6qrnk29or.png', 'Mitsubishi, apprécié pour ses 4x4 et pick-ups.', '2025-11-12 12:36:38', '2025-11-12 12:05:08'),
	(9, 'Mazda', 'marques_logos/izOwps17zYuElGcRNT6uuWIwBEccMqVjSvQEtsXZ.png', 'Mazda, connu pour les berlines et SUV sportifs.', '2025-11-12 12:36:38', '2025-11-12 12:04:52'),
	(10, 'Isuzu', 'marques_logos/3Y40vV8A03qaprpzFKnie68DQLQnjB9drhDgGILh.png', 'Isuzu, leader sur le marché des utilitaires légers.', '2025-11-12 12:36:38', '2025-11-12 12:04:30'),
	(11, 'Peugeot', 'marques_logos/q0oEYfDs3GcxoNDftJh2RAoZJxo2lrn5Rpb0DSaG.png', 'Peugeot, marque française très répandue pour ses citadines.', '2025-11-12 12:36:38', '2025-11-12 11:53:11'),
	(12, 'Renault', 'marques_logos/u4MvG92QwhaoYGLqX5j6mVM9q95bsLczMlYuxdMF.png', 'Renault, connue pour ses voitures économiques et durables.', '2025-11-12 12:36:38', '2025-11-12 12:03:12'),
	(13, 'Mercedes-Benz', 'marques_logos/sl46lH9snqgjIxKQQaQcpRaEA7DibX42Q4SwYVfA.png', 'Mercedes-Benz, symbole de luxe et confort.', '2025-11-12 12:36:38', '2025-11-12 11:41:38'),
	(14, 'BMW', 'marques_logos/dKOh98dqnQpA6IgfQ5bOBnuZ9rm6UEM2Kopw3TkQ.png', 'BMW, voitures premium pour les amateurs de performance.', '2025-11-12 12:36:38', '2025-11-12 12:02:48'),
	(15, 'Volkswagen', 'marques_logos/l86bdBrUipRs7zhDRMOMDzVQfFGy8YWezpFGbHzf.png', 'Volkswagen, fiable et populaire sur le marché africain.', '2025-11-12 12:36:38', '2025-11-12 12:02:27'),
	(16, 'Chevrolet', 'uploads/logos/chevrolet.png', 'Chevrolet, pour SUV et pick-ups robustes.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(17, 'Land Rover', 'uploads/logos/landrover.png', 'Land Rover, spécialiste des 4x4 tout-terrain.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(18, 'Tata Motors', 'uploads/logos/tata.png', 'Tata Motors, économique et robuste pour utilitaires.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(19, 'Changan', 'uploads/logos/changan.png', 'Changan, constructeur chinois en expansion en Afrique.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(20, 'Great Wall', 'uploads/logos/greatwall.png', 'Great Wall Motors, SUV et pick-ups chinois populaires.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(21, 'Geely', 'uploads/logos/geely.png', 'Geely, marque chinoise récente mais en croissance.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(22, 'BYD', 'uploads/logos/byd.png', 'BYD, spécialiste des voitures électriques et hybrides.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(23, 'Haval', 'uploads/logos/haval.png', 'Haval, SUV chinois moderne et abordable.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(24, 'Dongfeng', 'uploads/logos/dongfeng.png', 'Dongfeng, constructeur chinois pour véhicules utilitaires.', '2025-11-12 12:36:38', '2025-11-12 12:36:38'),
	(25, 'Chery', 'uploads/logos/chery.png', 'Chery, voitures chinoises économiques et fiables.', '2025-11-12 12:36:38', '2025-11-12 12:36:38');

-- Listage des données de la table gestauto.partenaires : ~3 rows (environ)
INSERT INTO `partenaires` (`id`, `logo`, `nom_partenaire`, `adresse`, `contact`, `nombre_agents`, `type_partenaires`, `statut`, `created_at`, `updated_at`) VALUES
	(1, 'partenaire_logos/AImQH5n8sNp5nHIaG73ozme1ulUZuGFz3cd47WnD.png', 'SUNU', 'Siège social\r\n\r\nAvenue du Colonel Parant\r\nBP 915 Libreville\r\nE-mail : gabon.vie@sunu-group.com\r\nTél. : (+241) 11 74 34 34\r\n \r\n\r\nInformations Juridiques\r\n\r\nCapital social : FCFA 3 000 000 000\r\nForme juridique : Société anonyme\r\nRegistre de Commerce : Libreville N° 2003B02977\r\nEntreprise régie par le Code des Assurances CIMA', '(+241) 11 74 34 34', 2, 'Partenaires institutionnels', 'actif', '2025-11-21 19:34:54', '2025-11-21 19:34:54'),
	(2, 'partenaire_logos/LNHbNHtB4Kx9PXlqt75sTkBVmJqTjPlKGjWEcwI0.png', 'Gabon Spriint Auto', 'Siège social\r\n\r\nZone Industrielle d\'Oloumi (En face du Lycée)\r\nBP 2961 Libreville Gabon\r\nEmail : contact@gr-gsa.com', '+241 11 72 25 16', 4, 'Partenaires techniques', 'actif', '2025-11-21 19:38:53', '2025-11-21 19:38:54'),
	(3, 'partenaire_logos/xhavrL588k6wt9fTQEDsAYSZ7665Dd0SbCgb1ogu.png', 'UBA Gabon', 'Agences :\r\nNos agences sont situées à Libreville (Immeuble panoramique à Rénovation, à Oloumi, Owendo, PK12, Boulevard, Akanda, la Gare routière) et à Port-Gentil (au Centre-ville).\r\n\r\nAgences ouvertes de 7h45 à 16h00 du Lundi au Vendredi. Seule les agences Panoramique, Gare Routiere, et PK12 sont ouvertes de 9h00 à 12h00 le samedi.\r\n\r\nSERVICE CLIENTS\r\nTéléphone :  (+241) 011 48 66 00 (Disponible aux heures d’agences du lundi au vendredi)\r\n\r\nEmail:cfcgabon@ubagroup.com ou digitalbanking-gabon@ubagroup.com\r\n\r\nSIGNALER UNE SITUATION\r\nWhistleblowing Numéro de Téléphone:  (+241)  011 48 66 23\r\n\r\nWhistleblowing sur Whatsapp Exclusivement: (+241) 65 11 06 42\r\n\r\nEmail:whistleblowinggab@ubagroup.com', '(+241) 65 11 06 42', 6, 'Partenaires institutionnels', 'actif', '2025-11-21 19:43:41', '2025-11-21 19:43:42');

-- Listage des données de la table gestauto.vehicles : ~0 rows (environ)
INSERT INTO `vehicles` (`id`, `entreprise_id`, `vehicle_type_id`, `vin`, `immatriculation`, `carte_grise_numero`, `modele`, `annee`, `couleur`, `statut_disponibilite`, `assurance_numero`, `assurance_date_debut`, `assurance_date_fin`, `document_assurance_path`, `document_carte_grise_path`, `document_fiche_technique_path`, `prix_journalier`, `prix_km`, `prix_journalier_avec_chauffeur`, `carburant`, `photo_principale`, `date_acquisition`, `date_derniere_vidange`, `date_derniere_visite_technique`, `created_at`, `updated_at`, `assurance_partenaire_id`, `marque_id`) VALUES
	(1, 1, 1, '748 564 6409', 'AA J58 LBV', '437H 401Y 4327 1234', 'I30 N PERFORMANCE 2.0 T-GDI 120', '2024', 'NOIRE', 'disponible', '235E 680D 43R6 5681', '2025-11-01', '2025-11-30', 'vehicle_documents/ThHyDFXtZqBag4e7P2BzLzu5ySy6LFTT2b6td2op.pdf', 'vehicle_documents/NfDaQv0mLrXjQnoxmzK8HWNhgcVYDtR1yDIBFPXU.pdf', 'vehicle_documents/JZJJr4wRhXIpYZmBDonhftXWSLOMcRkAFnKS7wc9.pdf', 5000.00, 3000.00, 6000.00, 'essence', 'vehicle_photos/DdBwABMpu03nboCtQblyfU9wc4SWQy4mN0Wgw81N.jpg', '2025-11-26', '2025-11-10', '2025-11-11', '2025-11-21 20:39:11', '2025-11-21 20:39:11', 1, 2),
	(2, 1, 3, '356403DHD', '2536TRY83', '2343 U474 4563 4840', 'Classe G', '2024', 'Blanche', 'disponible', '253H 568D 84GT 230R', '2025-11-22', '2025-11-30', 'vehicle_documents/3WozLzXT1vOiUoqrsGaoB4Kwck75IXuXqNHewA9O.pdf', 'vehicle_documents/8W4OSNcMHGUYdVzWe4W3Ry3opbnauEPGLTKNXOvf.pdf', 'vehicle_documents/P9Cry0nmOFPS08CqshhL3YJltHVjnBTl4hEMGSxR.pdf', 150000.00, 80000.00, 200000.00, 'essence', 'vehicle_photos/toGB0CNFii2iSmchfflHGKMgNw8KhfwXoKRs9EPN.jpg', '2025-11-22', '2025-11-19', '2025-11-28', '2025-11-22 12:57:54', '2025-11-22 12:57:54', 1, 13);

-- Listage des données de la table gestauto.vehicle_photos : ~0 rows (environ)
INSERT INTO `vehicle_photos` (`id`, `vehicle_id`, `path`, `is_logo`, `description`, `created_at`, `updated_at`) VALUES
	(81, 3, 'vehicle_photos/3UO0ZV0aElSnmuYWDJkWF5iyLfqU6LqD4aSPWWhw.jpg', 0, NULL, '2025-11-12 13:18:13', '2025-11-12 13:18:13'),
	(82, 3, 'vehicle_photos/N73e7shXUzOjzLuv5wsaBFOrq4PatWVXf79d6mMP.jpg', 0, NULL, '2025-11-12 13:18:13', '2025-11-12 13:18:13'),
	(83, 3, 'vehicle_photos/hPBZhzyH85dsePgJilArLPggXKQV0KlBFfZ7rInA.jpg', 0, NULL, '2025-11-12 13:18:13', '2025-11-12 13:18:13'),
	(84, 3, 'vehicle_photos/21LAjtXzfPfk2bXejjpRFxbsZLooHQqOZP7VHVtd.jpg', 0, NULL, '2025-11-12 13:18:14', '2025-11-12 13:18:14'),
	(85, 3, 'vehicle_photos/DvsxruJ3jdfQer8XllePVW449vCp6d3c4WHj2fKd.jpg', 0, NULL, '2025-11-12 13:18:14', '2025-11-12 13:18:14'),
	(86, 3, 'vehicle_photos/Ybz8hLDvwnWDAN7L0020AeQMut9pUFlBk1lNCXIL.jpg', 0, NULL, '2025-11-12 13:18:14', '2025-11-12 13:18:14'),
	(87, 3, 'vehicle_photos/2lxCLJAOZKYmMLrwkOkOzZz7UFShcwtS6DU7h8di.jpg', 0, NULL, '2025-11-12 13:18:14', '2025-11-12 13:18:14'),
	(88, 3, 'vehicle_photos/jGgla3VBu1tAMJltd9Owg6gZEoZkL6Xk2iycazYv.jpg', 0, NULL, '2025-11-12 13:18:14', '2025-11-12 13:18:14'),
	(89, 4, 'vehicle_photos/OAArvGluFnEizlS5WUON558xj1Lrcb2TGhlzN6qW.jpg', 0, NULL, '2025-11-13 08:46:29', '2025-11-13 08:46:29'),
	(90, 4, 'vehicle_photos/8DVg5QMAC1KhgPhtkFqz01KROjcCKtSFBboZa2No.jpg', 0, NULL, '2025-11-13 08:46:30', '2025-11-13 08:46:30'),
	(91, 4, 'vehicle_photos/eOIhlgcaPeeWtaK61m12QB0Puch5Ep9ERYmAKDcY.jpg', 0, NULL, '2025-11-13 08:46:30', '2025-11-13 08:46:30'),
	(92, 4, 'vehicle_photos/TKlW3e82F51VupeVaBerRdOUEcNqInBGxTrPdbNG.jpg', 0, NULL, '2025-11-13 08:46:30', '2025-11-13 08:46:30'),
	(93, 4, 'vehicle_photos/Z5vkkdc7bYdXq2YCn2558h9TUSnUfz0CWuSWygYu.jpg', 0, NULL, '2025-11-13 08:46:30', '2025-11-13 08:46:30'),
	(94, 4, 'vehicle_photos/aBaVnzpV3TTciH3N1rYrLcMg49FOF7hlj5uCZQlc.jpg', 0, NULL, '2025-11-13 08:46:30', '2025-11-13 08:46:30'),
	(95, 4, 'vehicle_photos/jMVsqMIxFWyImyTEKof5DyyelbXoljEXrZuFMhWt.jpg', 0, NULL, '2025-11-13 08:46:31', '2025-11-13 08:46:31'),
	(96, 4, 'vehicle_photos/5vsGlsWoQPB5yBXZB93THWjdCsRdd6ow5b9OnJEI.jpg', 0, NULL, '2025-11-13 08:46:31', '2025-11-13 08:46:31'),
	(97, 4, 'vehicle_photos/w2FBrWBCUWzrlng9nAejyugSV2Sy8vbFujloQsm6.jpg', 0, NULL, '2025-11-13 08:46:31', '2025-11-13 08:46:31'),
	(98, 4, 'vehicle_photos/9QpUmhFHPxGLtARUPSLVzvfxsu497gwCBD4T9ypZ.jpg', 0, NULL, '2025-11-13 08:46:31', '2025-11-13 08:46:31'),
	(99, 4, 'vehicle_photos/egOqYkJRsPvrXeEI8TGmHgGgxIZa2shmQGucNVOA.jpg', 0, NULL, '2025-11-13 08:46:31', '2025-11-13 08:46:31'),
	(100, 4, 'vehicle_photos/v0RfY1nRxBmwN9eggugO017J0GtXldWGR8Cc2EzV.jpg', 0, NULL, '2025-11-13 08:46:31', '2025-11-13 08:46:31'),
	(101, 1, 'vehicle_photos/N1vNw7dYLQ4K4SF8t0uBS3skWa0uC5TqvbDdMpzz.jpg', 0, NULL, '2025-11-21 20:39:12', '2025-11-21 20:39:12'),
	(102, 1, 'vehicle_photos/abIzCU0betgeJf3kI0sk9r1REGW7g7mfYBFPzAAd.jpg', 0, NULL, '2025-11-21 20:39:12', '2025-11-21 20:39:12'),
	(103, 2, 'vehicle_photos/4wl6By04o92Uk8u9vVZLZET45STHG1wz0sJdMamq.jpg', 0, NULL, '2025-11-22 12:57:55', '2025-11-22 12:57:55'),
	(104, 2, 'vehicle_photos/XFRDtqWByqUaA1CVRxIQPLpnPR9UqyvWrmz0ce0X.jpg', 0, NULL, '2025-11-22 12:57:55', '2025-11-22 12:57:55'),
	(105, 2, 'vehicle_photos/Dj4GUHAt9fctgpGJpnEgpcZKLSFxmoEboy7ImvWD.jpg', 0, NULL, '2025-11-22 12:57:55', '2025-11-22 12:57:55'),
	(106, 2, 'vehicle_photos/mdLP0LfkGaT7bEJqm2o90nruH17wkiBztHWJkvT8.jpg', 0, NULL, '2025-11-22 12:57:56', '2025-11-22 12:57:56'),
	(107, 2, 'vehicle_photos/9E9vJkj0WLGASregv8rURFFIRqFjMlniugSxmjHa.jpg', 0, NULL, '2025-11-22 12:57:56', '2025-11-22 12:57:56');

-- Listage des données de la table gestauto.vehicle_types : ~0 rows (environ)
INSERT INTO `vehicle_types` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Citadine', 'Véhicule compact idéal pour la ville et les petits trajets.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(2, 'Berline', 'Voiture confortable à 4 ou 5 places adaptée aux longs trajets.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(3, 'SUV', 'Véhicule tout-terrain spacieux et puissant, adapté à tous types de routes.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(4, '4x4', 'Véhicule à quatre roues motrices pour terrains difficiles ou zones rurales.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(5, 'Pickup', 'Véhicule utilitaire avec benne arrière pour transport de marchandises.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(6, 'Camionnette', 'Petit utilitaire pour le transport de biens et services.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(7, 'Camion', 'Véhicule de grande capacité utilisé pour le transport lourd.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(8, 'Minibus', 'Véhicule de transport collectif de 8 à 20 places.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(9, 'Moto', 'Deux-roues motorisé pour livraison rapide ou déplacement urbain.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(10, 'Tricycle', 'Véhicule à trois roues utilisé pour le transport de personnes ou de marchandises.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(11, 'Bus', 'Véhicule de transport public ou privé de grande capacité.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(12, 'Remorque', 'Équipement tracté utilisé pour le transport supplémentaire de biens.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(13, 'Engin de chantier', 'Matériel lourd comme bulldozer, pelleteuse ou grue.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(14, 'Véhicule de luxe', 'Voiture haut de gamme destinée aux clients VIP.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(15, 'Véhicule électrique', 'Voiture ou moto fonctionnant à l’énergie électrique.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(16, 'Véhicule hybride', 'Véhicule combinant moteur thermique et électrique.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(17, 'Bateau', 'Engin nautique utilisé pour le transport fluvial ou maritime.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(18, 'Jet-ski', 'Petit engin nautique de loisir motorisé.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(19, 'Tracteur', 'Engin agricole ou industriel pour travaux lourds.', '2025-11-10 16:41:18', '2025-11-10 16:41:18'),
	(20, 'Autre', 'Catégorie générique pour tout type de véhicule non listé.', '2025-11-10 16:41:18', '2025-11-10 16:41:18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
