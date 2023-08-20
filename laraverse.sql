-- -------------------------------------------------------------
-- TablePlus 5.3.8(500)
--
-- https://tableplus.com/
--
-- Database: laraverse
-- Generation Time: 2023-08-20 22:57:27.0470
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `category_item`;
CREATE TABLE `category_item` (
  `item_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  KEY `category_item_item_id_foreign` (`item_id`),
  KEY `category_item_category_id_foreign` (`category_id`),
  CONSTRAINT `category_item_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `category_item_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
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

DROP TABLE IF EXISTS `github_organizations`;
CREATE TABLE `github_organizations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `github_owners`;
CREATE TABLE `github_owners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `github_repo_github_tag`;
CREATE TABLE `github_repo_github_tag` (
  `github_repo_id` bigint unsigned NOT NULL,
  `github_tag_id` bigint unsigned NOT NULL,
  KEY `github_repo_github_tag_github_repo_id_foreign` (`github_repo_id`),
  KEY `github_repo_github_tag_github_tag_id_foreign` (`github_tag_id`),
  CONSTRAINT `github_repo_github_tag_github_repo_id_foreign` FOREIGN KEY (`github_repo_id`) REFERENCES `github_repos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `github_repo_github_tag_github_tag_id_foreign` FOREIGN KEY (`github_tag_id`) REFERENCES `github_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `github_repos`;
CREATE TABLE `github_repos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `github_organization_id` bigint unsigned NOT NULL,
  `github_owner_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `github_repos_github_organization_id_foreign` (`github_organization_id`),
  KEY `github_repos_github_owner_id_foreign` (`github_owner_id`),
  CONSTRAINT `github_repos_github_organization_id_foreign` FOREIGN KEY (`github_organization_id`) REFERENCES `github_organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `github_repos_github_owner_id_foreign` FOREIGN KEY (`github_owner_id`) REFERENCES `github_owners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `github_tags`;
CREATE TABLE `github_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `item_platform`;
CREATE TABLE `item_platform` (
  `platform_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  KEY `item_platform_platform_id_foreign` (`platform_id`),
  KEY `item_platform_item_id_foreign` (`item_id`),
  CONSTRAINT `item_platform_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_platform_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `item_relation_types`;
CREATE TABLE `item_relation_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `item_relations`;
CREATE TABLE `item_relations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `item_relation_type_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_relations_item_id_foreign` (`item_id`),
  KEY `item_relations_item_relation_type_id_foreign` (`item_relation_type_id`),
  CONSTRAINT `item_relations_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_relations_item_relation_type_id_foreign` FOREIGN KEY (`item_relation_type_id`) REFERENCES `item_relation_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `item_stack`;
CREATE TABLE `item_stack` (
  `stack_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  KEY `item_stack_stack_id_foreign` (`stack_id`),
  KEY `item_stack_item_id_foreign` (`item_id`),
  CONSTRAINT `item_stack_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_stack_stack_id_foreign` FOREIGN KEY (`stack_id`) REFERENCES `stacks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `item_tag`;
CREATE TABLE `item_tag` (
  `tag_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  KEY `item_tag_tag_id_foreign` (`tag_id`),
  KEY `item_tag_item_id_foreign` (`item_id`),
  CONSTRAINT `item_tag_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `item_types`;
CREATE TABLE `item_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latest_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versions` json DEFAULT NULL,
  `vendor_id` bigint unsigned NOT NULL,
  `itemType_id` bigint unsigned NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `popularity` int NOT NULL,
  `rating` int DEFAULT NULL,
  `rating_data` json DEFAULT NULL,
  `health` int DEFAULT NULL,
  `health_data` json DEFAULT NULL,
  `github_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_stars` int DEFAULT NULL,
  `packagist_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packagist_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packagist_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packagist_downloads` int DEFAULT NULL,
  `packagist_favers` int DEFAULT NULL,
  `npm_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_maintainers` int DEFAULT NULL,
  `github_repo_id` bigint unsigned DEFAULT NULL,
  `npm_package_id` bigint unsigned DEFAULT NULL,
  `packagist_package_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_vendor_id_foreign` (`vendor_id`),
  KEY `items_itemtype_id_foreign` (`itemType_id`),
  KEY `items_github_repo_id_foreign` (`github_repo_id`),
  KEY `items_npm_package_id_foreign` (`npm_package_id`),
  KEY `items_packagist_package_id_foreign` (`packagist_package_id`),
  CONSTRAINT `items_github_repo_id_foreign` FOREIGN KEY (`github_repo_id`) REFERENCES `github_repos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `items_itemtype_id_foreign` FOREIGN KEY (`itemType_id`) REFERENCES `item_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `items_npm_package_id_foreign` FOREIGN KEY (`npm_package_id`) REFERENCES `npm_packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `items_packagist_package_id_foreign` FOREIGN KEY (`packagist_package_id`) REFERENCES `packagist_packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `items_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `npm_packages`;
CREATE TABLE `npm_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `packagist_packages`;
CREATE TABLE `packagist_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `platforms`;
CREATE TABLE `platforms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `post_types`;
CREATE TABLE `post_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `data` json DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned DEFAULT NULL,
  `stack_id` bigint unsigned DEFAULT NULL,
  `post_type_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_item_id_foreign` (`item_id`),
  KEY `posts_stack_id_foreign` (`stack_id`),
  KEY `posts_post_type_id_foreign` (`post_type_id`),
  CONSTRAINT `posts_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_post_type_id_foreign` FOREIGN KEY (`post_type_id`) REFERENCES `post_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_stack_id_foreign` FOREIGN KEY (`stack_id`) REFERENCES `stacks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
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

DROP TABLE IF EXISTS `stack_user`;
CREATE TABLE `stack_user` (
  `user_id` bigint unsigned NOT NULL,
  `stack_id` bigint unsigned NOT NULL,
  KEY `stack_user_user_id_foreign` (`user_id`),
  KEY `stack_user_stack_id_foreign` (`stack_id`),
  CONSTRAINT `stack_user_stack_id_foreign` FOREIGN KEY (`stack_id`) REFERENCES `stacks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stack_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `stacks`;
CREATE TABLE `stacks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `build` json DEFAULT NULL,
  `public` tinyint(1) NOT NULL,
  `major` tinyint(1) DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stacks_user_id_foreign` (`user_id`),
  CONSTRAINT `stacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `github` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `packagist` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `item_relation_types` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Composer require', 'composer_require', '<p>This PHP package is required by Composer.</p>', '2023-08-20 11:12:47', '2023-08-20 11:12:47'),
(2, 'Composer require dev', 'composer_require_dev', '<p>This PHP package is required by Composer for development.</p>', '2023-08-20 11:13:21', '2023-08-20 11:13:21'),
(3, 'Composer conflict', 'composer_conflict', '<p>This PHP package is marked as conflict by Composer.</p>', '2023-08-20 18:05:37', '2023-08-20 18:05:37'),
(4, 'Composer replace', 'composer_replace', '<p>This PHP package is marked as replacement by Composer.</p>', '2023-08-20 18:06:18', '2023-08-20 18:06:18'),
(5, 'Composer provide', 'composer_provide', '<p>This PHP package is marked as provided by Composer.</p>', '2023-08-20 18:07:19', '2023-08-20 18:07:19'),
(6, 'Composer suggest', 'composer_suggest', '<p>This PHP package is suggested by Composer.</p>', '2023-08-20 18:07:42', '2023-08-20 18:07:42'),
(7, 'NPM dependency', 'npm_dependency', '<p>This NPM package is a dependency.</p>', '2023-08-20 18:08:19', '2023-08-20 18:08:19'),
(8, 'NPM dev dependency', 'npm_dev_dependency', '<p>This NPM package is a dev dependency.</p>', '2023-08-20 19:10:53', '2023-08-20 19:10:53'),
(9, 'NPM peer dependency', 'npm_peer_dependency', '<p>This NPM package is a peer dependency.</p>', '2023-08-20 19:11:24', '2023-08-20 19:11:24'),
(10, 'is dependency', 'is_dependency', '<p>This package is a (manually set) dependency.</p>', '2023-08-20 19:13:20', '2023-08-20 20:42:36'),
(11, 'is related', 'is_related', '<p>This package is a (manually set) relation.</p>', '2023-08-20 19:13:52', '2023-08-20 20:42:30'),
(12, 'is predecessor', 'is_predecessor', '<p>This package is a (manually set) predecessor.</p>', '2023-08-20 19:14:14', '2023-08-20 20:42:21'),
(13, 'is successor', 'is_successor', '<p>This package is a (manually set) successor.</p>', '2023-08-20 19:14:33', '2023-08-20 20:42:14'),
(14, 'is alternative', 'is_alternative', '<p>This package is a (manually set) alternative.</p>', '2023-08-20 19:14:55', '2023-08-20 20:42:07'),
(15, 'is release', 'is_release', '<p>This package is a (manually set) release.</p>', '2023-08-20 19:15:38', '2023-08-20 20:41:59');

INSERT INTO `item_types` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'PHP Framework', 'php-framework', '<p>A PHP framework to build awesome things.</p>', '2023-08-20 20:11:28', '2023-08-20 20:11:28'),
(2, 'PHP Skeleton', 'php-skeleton', '<p>This is a PHP skeleton, i.e. a preset for a PHP framework.</p>', '2023-08-20 20:13:33', '2023-08-20 20:13:33'),
(3, 'PHP App', 'php-app', '<p>A PHP app, most probably build with a PHP framework.</p>', '2023-08-20 20:14:13', '2023-08-20 20:14:13'),
(4, 'IDE Extension', 'ide-extension', '<p>An IDE Extension adds features to your editor.</p>', '2023-08-20 20:15:34', '2023-08-20 20:17:44'),
(5, 'Desktop App', 'desktop-app', '<p>This is a Desktop app for Windows, Mac or Linux.</p>', '2023-08-20 20:44:08', '2023-08-20 20:44:08'),
(6, 'PHP Extension', 'php-extension', '<p>An extension that needs to be loaded with PHP.</p>', '2023-08-20 20:45:57', '2023-08-20 20:45:57');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_08_03_000001_create_categories_table', 1),
(6, '2023_08_03_000002_create_category_item_table', 1),
(7, '2023_08_03_000003_create_github_organizations_table', 1),
(8, '2023_08_03_000003_create_items_table', 1),
(9, '2023_08_03_000004_create_github_owners_table', 1),
(10, '2023_08_03_000005_create_github_repos_table', 1),
(11, '2023_08_03_000005_create_item_platform_table', 1),
(12, '2023_08_03_000006_create_github_tags_table', 1),
(13, '2023_08_03_000006_create_item_stack_table', 1),
(14, '2023_08_03_000007_create_github_repo_github_tag_table', 1),
(15, '2023_08_03_000007_create_item_tag_table', 1),
(16, '2023_08_03_000008_create_item_relations_table', 1),
(17, '2023_08_03_000008_create_item_types_table', 1),
(18, '2023_08_03_000008_create_npm_packages_table', 1),
(19, '2023_08_03_000008_create_platforms_table', 1),
(20, '2023_08_03_000009_create_item_relation_types_table', 1),
(21, '2023_08_03_000009_create_packagist_packages_table', 1),
(22, '2023_08_03_000009_create_stacks_table', 1),
(23, '2023_08_03_000010_create_posts_table', 1),
(24, '2023_08_03_000010_create_stack_user_table', 1),
(25, '2023_08_03_000010_create_tags_table', 1),
(26, '2023_08_03_000011_create_post_types_table', 1),
(27, '2023_08_03_000012_create_vendors_table', 1),
(28, '2023_08_03_009001_add_foreigns_to_category_item_table', 1),
(29, '2023_08_03_009002_add_foreigns_to_github_repos_table', 1),
(30, '2023_08_03_009002_add_foreigns_to_items_table', 1),
(31, '2023_08_03_009003_add_foreigns_to_github_repo_github_tag_table', 1),
(32, '2023_08_03_009004_add_foreigns_to_item_platform_table', 1),
(33, '2023_08_03_009004_add_foreigns_to_item_relations_table', 1),
(34, '2023_08_03_009005_add_foreigns_to_item_stack_table', 1),
(35, '2023_08_03_009006_add_foreigns_to_item_tag_table', 1),
(36, '2023_08_03_009007_add_foreigns_to_posts_table', 1),
(37, '2023_08_03_009007_add_foreigns_to_stacks_table', 1),
(38, '2023_08_03_009008_add_foreigns_to_stack_user_table', 1),
(39, '2023_08_20_110644_create_sessions_table', 1),
(40, '2023_08_20_110708_create_permission_tables', 1);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'list categories', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(2, 'view categories', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(3, 'create categories', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(4, 'update categories', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(5, 'delete categories', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(6, 'list githuborganizations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(7, 'view githuborganizations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(8, 'create githuborganizations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(9, 'update githuborganizations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(10, 'delete githuborganizations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(11, 'list githubowners', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(12, 'view githubowners', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(13, 'create githubowners', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(14, 'update githubowners', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(15, 'delete githubowners', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(16, 'list githubrepos', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(17, 'view githubrepos', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(18, 'create githubrepos', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(19, 'update githubrepos', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(20, 'delete githubrepos', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(21, 'list githubtags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(22, 'view githubtags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(23, 'create githubtags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(24, 'update githubtags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(25, 'delete githubtags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(26, 'list items', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(27, 'view items', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(28, 'create items', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(29, 'update items', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(30, 'delete items', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(31, 'list itemrelations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(32, 'view itemrelations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(33, 'create itemrelations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(34, 'update itemrelations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(35, 'delete itemrelations', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(36, 'list itemrelationtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(37, 'view itemrelationtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(38, 'create itemrelationtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(39, 'update itemrelationtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(40, 'delete itemrelationtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(41, 'list itemtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(42, 'view itemtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(43, 'create itemtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(44, 'update itemtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(45, 'delete itemtypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(46, 'list npmpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(47, 'view npmpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(48, 'create npmpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(49, 'update npmpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(50, 'delete npmpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(51, 'list packagistpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(52, 'view packagistpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(53, 'create packagistpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(54, 'update packagistpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(55, 'delete packagistpackages', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(56, 'list platforms', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(57, 'view platforms', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(58, 'create platforms', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(59, 'update platforms', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(60, 'delete platforms', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(61, 'list posts', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(62, 'view posts', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(63, 'create posts', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(64, 'update posts', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(65, 'delete posts', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(66, 'list posttypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(67, 'view posttypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(68, 'create posttypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(69, 'update posttypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(70, 'delete posttypes', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(71, 'list stacks', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(72, 'view stacks', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(73, 'create stacks', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(74, 'update stacks', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(75, 'delete stacks', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(76, 'list tags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(77, 'view tags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(78, 'create tags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(79, 'update tags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(80, 'delete tags', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(81, 'list vendors', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(82, 'view vendors', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(83, 'create vendors', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(84, 'update vendors', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(85, 'delete vendors', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(86, 'list roles', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(87, 'view roles', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(88, 'create roles', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(89, 'update roles', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(90, 'delete roles', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(91, 'list permissions', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(92, 'view permissions', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(93, 'create permissions', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(94, 'update permissions', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(95, 'delete permissions', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(96, 'list users', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(97, 'view users', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(98, 'create users', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(99, 'update users', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(100, 'delete users', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11');

INSERT INTO `platforms` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Linux Server', 'linux-server', '<p>Runs on Linux without GUI.</p>', '2023-08-20 20:31:34', '2023-08-20 20:31:34'),
(2, 'Windows Server', 'windows-server', '<p>Runs on Windows (Server) without GUI.</p>', '2023-08-20 20:32:02', '2023-08-20 20:32:02'),
(3, 'Linux Desktop', 'linux-desktop', '<p>Runs on Linux as a Desktop software.</p>', '2023-08-20 20:32:49', '2023-08-20 20:32:49'),
(4, 'MacOS', 'macos', '<p>Runs on MacOS.</p>', '2023-08-20 20:33:07', '2023-08-20 20:33:07'),
(5, 'Windows', 'windows', '<p>Runs on Windows (Desktop).</p>', '2023-08-20 20:33:30', '2023-08-20 20:33:30'),
(6, 'Webserver', 'webserver', '<p>Runs on a webserver like Apache or Nginx.</p>', '2023-08-20 20:34:14', '2023-08-20 20:34:14'),
(7, 'Web', 'web', '<p>Runs in the web, probably a SaaS platform.</p>', '2023-08-20 20:34:39', '2023-08-20 20:34:39'),
(8, 'PHP Applikation', 'php-app', '<p>An application running on PHP.</p>', '2023-08-20 20:36:23', '2023-08-20 20:36:23'),
(9, 'PHP package', 'php-package', '<p>A PHP package usually required using Composer.</p>', '2023-08-20 20:37:29', '2023-08-20 20:37:29'),
(10, 'NPM package', 'npm-package', '<p>A NPM package.</p>', '2023-08-20 20:37:57', '2023-08-20 20:37:57'),
(11, 'Android App', 'android-app', '<p>App for Android phones and tablets.</p>', '2023-08-20 20:38:27', '2023-08-20 20:38:27'),
(12, 'iOS App', 'ios-app', '<p>A mobile App for iPhone or iPad.</p>', '2023-08-20 20:39:02', '2023-08-20 20:39:02'),
(13, 'Browser', 'browser', '<p>Running in the Browser, most possibly a browser extension.</p>', '2023-08-20 20:39:36', '2023-08-20 20:39:36'),
(14, 'IDE', 'ide', '<p>Running in the IDE, most probably an IDE extension.</p>', '2023-08-20 20:39:57', '2023-08-20 20:39:57'),
(15, 'Other', 'other', '<p>I don\'t know.</p>', '2023-08-20 20:40:11', '2023-08-20 20:40:11'),
(16, 'PHP Extension', 'php-extension', '<p>An official PHP extension.</p>', '2023-08-20 20:52:43', '2023-08-20 20:52:43'),
(17, 'Web API', 'web-api', '<p>A Web API, normally ReST or GraphQL.</p>', '2023-08-20 20:53:30', '2023-08-20 20:53:30'),
(18, 'PHP Skeleton', 'php-skeleton', '<p>A PHP-Skeleton, that normally runs with a framework.</p>', '2023-08-20 20:54:09', '2023-08-20 20:54:09'),
(19, 'GitHub Action', 'github-action', '<p>A GitHub action to automate things.</p>', '2023-08-20 20:54:39', '2023-08-20 20:54:39'),
(20, 'Bash-Scripts', 'bash-scripts', '<p>Things that runs in bash.</p>', '2023-08-20 20:55:22', '2023-08-20 20:55:22'),
(21, 'Python', 'python', '<p>Things that run with Python.</p>', '2023-08-20 20:55:43', '2023-08-20 20:55:43'),
(22, 'NodeJS', 'nodejs', '<p>Things that run with NodeJS.</p>', '2023-08-20 20:56:04', '2023-08-20 20:56:04');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(66, 1),
(66, 2),
(67, 1),
(67, 2),
(68, 1),
(68, 2),
(69, 1),
(69, 2),
(70, 1),
(70, 2),
(71, 1),
(71, 2),
(72, 1),
(72, 2),
(73, 1),
(73, 2),
(74, 1),
(74, 2),
(75, 1),
(75, 2),
(76, 1),
(76, 2),
(77, 1),
(77, 2),
(78, 1),
(78, 2),
(79, 1),
(79, 2),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(84, 1),
(84, 2),
(85, 1),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2);

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11'),
(2, 'super-admin', 'web', '2023-08-20 11:09:11', '2023-08-20 11:09:11');

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('c3gqsdDqUAEIenDjYvsoxesTCLpiBVBGetvUKjcT', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZkZDUWNJdHUzRVM0ZExOOGo5eWdhZ2FqekpLYUxxRTJZckhrQ0tRVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwczovL2xhcmF2ZXJzZS50ZXN0L2FkbWluIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJHVlRmhtcFdPN0RYRHN5djZIS0lPN09QRDJ4R0wuUnh2L0NHNkg1UlI4a1BIV0trbEFOLmZtIjtzOjg6ImZpbGFtZW50IjthOjA6e319', 1692565006);

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Alf Drollinger', 'alf@drollinger.info', '2023-08-20 11:09:11', '$2y$10$ueFhmpWO7DXDsyv6HKIO7OPD2xGL.Rxv/CG6H5RR8kPHWKklAN.fm', 'p0fiNpLk5y', '2023-08-20 11:09:11', '2023-08-20 11:10:50');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;