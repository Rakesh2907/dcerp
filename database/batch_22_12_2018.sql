ALTER TABLE `erp_material_master` ADD `dep_id` INT NULL DEFAULT NULL AFTER `no_of_reaction`;
ALTER TABLE `erp_material_quotation_draft` ADD `is_deleted` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `mat_req_id`;
ALTER TABLE `erp_material_inward_details` ADD `is_deleted` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `updated_by` 