ALTER TABLE `erp_material_inward_details` ADD `qc_accepted_qry` FLOAT(10,2) NULL DEFAULT NULL AFTER `received_qty`;
ALTER TABLE `erp_material_inward_details` ADD `remarks` TEXT NULL DEFAULT NULL AFTER `igst_amt`;
ALTER TABLE `erp_material_inward_details` CHANGE `remarks` `qc_remarks` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `erp_material_inward_details` CHANGE `qc_accepted_qry` `qc_accepted_qty` FLOAT(10) NULL DEFAULT NULL;
ALTER TABLE `erp_material_inward_details` ADD `qc_debit_amt` FLOAT(10,2) NULL DEFAULT NULL AFTER `qc_remarks`; 