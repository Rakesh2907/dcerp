ALTER TABLE `erp_supplier_quotation_bid` ADD `created_by_purchase` INT NULL DEFAULT NULL AFTER `created_by_vender`;
ALTER TABLE `erp_supplier_quotation_bid` CHANGE `note_by_vendor` `note` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;