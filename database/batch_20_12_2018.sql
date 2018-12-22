ALTER TABLE `erp_material_outward_batchwise` CHANGE `cgst_amt` `cgst_amt_per` FLOAT(10,2) NOT NULL DEFAULT '0.00';
ALTER TABLE `erp_material_outward_batchwise` CHANGE `sgst_amt` `sgst_amt_per` FLOAT(10,2) NOT NULL DEFAULT '0.00';
ALTER TABLE `erp_material_outward_batchwise` CHANGE `igst_amt` `igst_amt_per` FLOAT(10,2) NOT NULL DEFAULT '0.00';

ALTER TABLE `erp_material_requisition_details` CHANGE `received_qty` `received_qty` FLOAT(10,2) NULL DEFAULT '0.00';

ALTER TABLE `erp_material_requisition_details` CHANGE `require_qty` `require_qty` FLOAT(10,2) NULL DEFAULT '0.00' 