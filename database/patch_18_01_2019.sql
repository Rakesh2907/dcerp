ALTER TABLE `users` ADD `under_maintenance` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `prevent_f12`;