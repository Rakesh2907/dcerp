ALTER TABLE `erp_material_outward_batchwise` ADD `rate` FLOAT(10,2) NOT NULL DEFAULT '0.00' AFTER `remark`;
ALTER TABLE `erp_material_outward_batchwise` ADD `discount_per` FLOAT(10,2) NOT NULL DEFAULT '0.00' AFTER `rate`;
ALTER TABLE `erp_material_outward_batchwise` ADD `discount` FLOAT(10,2) NOT NULL DEFAULT '0.00' AFTER `discount_per`;

ALTER TABLE `erp_material_outward_batchwise` ADD `cgst_amt` FLOAT(10,2) NOT NULL DEFAULT '0.00' AFTER `discount`;

ALTER TABLE `erp_material_outward_batchwise` ADD `sgst_amt` FLOAT(10,2) NOT NULL DEFAULT '0.00' AFTER `cgst_amt`;

ALTER TABLE `erp_material_outward_batchwise` ADD `igst_amt` FLOAT(10,2) NOT NULL DEFAULT '0.00' AFTER `sgst_amt`;