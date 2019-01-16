ALTER TABLE `users` ADD `erp_user_role_id` INT NULL DEFAULT NULL AFTER `role_id`;

INSERT INTO `erp_users_role` (`erp_user_role_id`, `user_role`, `permission`, `created`, `updated`, `is_deleted`) VALUES (NULL, 'admin', NULL, '2019-01-12 00:00:00', '2019-01-12 00:00:00', '0');