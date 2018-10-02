INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'material-add_new_material'), (NULL, 'material-delete_material');

INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'vendor-add_new_vendor'), (NULL, 'vendor-export_details');
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'vendor-edit_vendor'), (NULL, 'vendor-delete_vendor');
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'vendor-quotation_tab'), (NULL, 'vendor-purchase_order_tab');
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'vendor-material_tab'), (NULL, 'vendor-payments_tab');
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'material_requisition-add_new'), (NULL, 'material_requisition-pending_requisation');
UPDATE `erp_permission_keys` SET `permission_keys` = 'material_requisition-pending_requisition' WHERE `erp_permission_keys`.`id` = 22;
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'material_requisition-approved_requisition'), (NULL, 'material_requisition-completed_requisition');
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'material_requisition-view_edit'), (NULL, 'material_requisition-view_materials');
INSERT INTO `erp_permission_keys` (`id`, `permission_keys`) VALUES (NULL, 'material_requisition-material_notes_view_edit');