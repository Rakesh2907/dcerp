<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_vendor extends CI_Controller{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('apivendor_model');	
        $this->load->model('purchase_model');
        $this->load->model('department_model');	
        $this->load->model('user/user_model'); 	
    }

	
	function vender_details($supplier_id = 0)
	{
		if($supplier_id > 0){

			$this->load->model('purchase_model');
			$supplier_details = $this->purchase_model->get_supplier_details($supplier_id);	

			if(!empty($supplier_details)){
				$result = array(
					'status' => 'success',
					'vendor' => $supplier_details
				); 
			}else{
				$result = array(
					'status' => 'error',
				);
			}
	     }else{
	     	$result = array(
	     			'status' => 'error',	
	     	);
	     }		
		 echo json_encode($result);
	}

	function quotation_request_details($quo_req_id = 0, $vendor_id = 0){

			$this->load->model('purchase_model');

			$where = array('qr.quo_req_id' => $quo_req_id);

			$where = "FIND_IN_SET('".$vendor_id."', qr.supplier_id) AND qr.quo_req_id = ".$quo_req_id."";  

			$quotations = $this->apivendor_model->quotation_listing($where);

			$status_purchase = $quotations[0]['approval_status_purchase'];
			$status_account = $quotations[0]['approval_status_account'];


			if($status_purchase != 'approved' && $status_account != 'approved')
			{
				$mywhere = array('qb.quo_req_id' => $quo_req_id);
				$quotation_details = $this->apivendor_model->get_quotation_request_details($mywhere); 
				$data_result = array(
					    'status' => 'success',
						'quo_req_id' => $quotations[0]['quo_req_id'],
						'quotation_request_number' => $quotations[0]['quotation_request_number'],
						'request_date' => $quotations[0]['request_date'],
						'dep_name' => $quotations[0]['dep_name'],
						'dep_id' => $quotations[0]['dep_id'],
						'quotation_details' => $quotation_details,
				);
			}else{
				$data_result = array(
						'status' => 'error',
						'message' => 'Sorry! Currently not any quotation request from Datar Cancer Genetics Limited'
				);
			}

			echo json_encode($data_result);
	}

	function update_vendor(){
			if(!empty($_POST))
			{
				$supplier_id = $_POST['supplier_id'];
				$post_obj = $_POST;

				$update_data['updated_vendor'] = date('Y-m-d H:i:s');
				$update_data['supp_firm_name'] = trim($post_obj['supp_firm_name']);
				$update_data['supplier_logo'] = trim($post_obj['supplier_logo']);
				$update_data['supp_contact_person'] = trim($post_obj['supp_contact_person']);
				$update_data['supp_address'] = trim($post_obj['supp_address']);
				$update_data['supp_contact_designation'] = trim($post_obj['supp_contact_designation']);
				$update_data['supp_country'] = $post_obj['supp_country'];
				$update_data['supp_state'] = $post_obj['supp_state'];
				$update_data['supp_city'] = trim($post_obj['supp_city']);
				$update_data['supp_pin'] = trim($post_obj['supp_pin']);
				$update_data['supp_phone1'] = trim($post_obj['supp_phone1']);
				$update_data['supp_phone2'] = trim($post_obj['supp_phone2']);
				$update_data['supp_mobile'] = trim($post_obj['supp_mobile']);
				$update_data['supp_mobile2'] = trim($post_obj['supp_mobile2']);
				$update_data['supp_fax'] = trim($post_obj['supp_fax']);
				$update_data['supp_email'] = trim($post_obj['supp_email']);
				$update_data['supp_website'] = trim($post_obj['supp_website']);
				$update_data['supp_description'] = trim($post_obj['supp_description']);

				if($this->purchase_model->update_supplier($update_data,$supplier_id)){
				}
			}
	}


	function add_quotation(){
		if(!empty($_POST))
		{
			$post_obj = $_POST[0];

			//echo "<pre>"; print_r($post_obj); echo "</pre>"; die;

			$quotation_number = $this->apivendor_model->get_quotation_number();
			
			$quotation_number = $quotation_number[0]->quotation_number;
			$quotation_number = explode('/', $quotation_number);
		 	$increment = ($quotation_number[2] + 1);
		 	$quotation_number = $quotation_number[0].'/'.date('Y').'/'.$increment;

			$quotation_data = array(
				'quo_req_id' => $post_obj['quo_req_id'],
				'vendor_panal_quotation_id' => $post_obj['vendor_quotation_id'],
				'quotation_number' => $quotation_number,
				'bid_date' => $post_obj['quo_date'],
				'dep_id' => $post_obj['dep_id'],
				'supplier_id' => $post_obj['erp_vendor_id'],
				'credit_days' => '40',
				'total_price' => $post_obj['total_price'],
				'total_cgst' => $post_obj['total_cgst'],
				'total_sgst' => $post_obj['total_sgst'],
				'total_igst' => $post_obj['total_igst'],
				'other_amt' => $post_obj['other_amt'],
				'total_amt' => $post_obj['total_amt'],
				'created' => date("Y-m-d H:i:s"),
				'created_by_vender' => $post_obj['erp_vendor_id']
			);

			if(isset($post_obj['notes']) && !empty($post_obj['notes'])){
				$quotation_data['note_by_vendor'] = $post_obj['notes'];
			}

			if(isset($post_obj['quotation_file']) && !empty($post_obj['quotation_file'])){
					$quotation_data['quotation_file'] = $post_obj['quotation_file'];
			}


			$quotation_id = $this->apivendor_model->insert_quotation($quotation_data);

			if($quotation_id > 0)
			{
				$quotation_details_id = array();
				foreach ($post_obj['material_list'] as $key => $value) {
					$quotation_details = array(
						'quotation_id' => $quotation_id,
						'quo_req_id' => $post_obj['quo_req_id'],
						'supplier_id' => $post_obj['erp_vendor_id'],
						'unit_id' => 2,
						'mat_id' => $value['mat_id'],
						'availability' => $value['availability'],
						'substitute_material' => $value['substitute_material'],
						'quo_rate' => $value['quo_rate'],
						'quo_qty' => $value['quo_qty'],
						'quo_price' => $value['quo_price'],
						'expire_date' => $value['expire_date'],
						'cgst_per' => $value['cgst_per'],
						'cgst_amt' => $value['cgst_amt'],
						'sgst_per' => $value['sgst_per'],
						'sgst_amt' => $value['sgst_amt'],
						'igst_per' => $value['igst_per'],
						'igst_amt' => $value['igst_amt'],
						'discount' => $value['discount'],
						'discount_per' => $value['discount_per'],
						'created' => date('Y-m-d H:i:s'),
						'created_by_vender' => $post_obj['erp_vendor_id']
					);

					$quotation_details_id[] = $this->apivendor_model->insert_quotation_details($quotation_details);
				}

				if(count($quotation_details_id) > 0){

					$this->apivendor_model->update_quotation_number($quotation_number);
					$this->apivendor_model->update_latest_quotation($quotation_id,$post_obj['quo_req_id']);

					$api_result = array(
						'status' => 'success',
						'message' => 'quotation added'
					); 
				}else{
					$api_result = array(
						'status' => 'error'
					);
				}
			}else{
				$api_result = array(
						'status' => 'error'
				);
			}
		}else{
			$api_result = array(
				'status' => 'error'
			);
		}
		echo json_encode($api_result); exit;
	}

	function get_purchase_order(){

		if(!empty($_POST)){
			 $where = array('po_id' => $_POST['erp_po_id'], 'supplier_id' => $_POST['vendor_id'], 'quotation_id' => $_POST['erp_quotation_id'], 'approval_flag' => 'approved');
 		 	 $purchase_orders = $this->purchase_model->get_purchase_order($where); 
 		 	 
 		 	 if(!empty($purchase_orders))
 		 	 {

 		 	 	$where = array('po.po_id' => $_POST['erp_po_id']);
         		$selected_materials = $this->purchase_model->get_selected_po_material_details($where);


 		 	 	$dep_id = $purchase_orders[0]['dep_id'];

 		 	 	$dep_details = $this->department_model->get_department_details(array('dep_id' => $dep_id));

 		 	 	$quotation_id = $purchase_orders[0]['quotation_id'];

 		 	 	$quotation_details = $this->purchase_model->get_supplier_quotation(array('quotation_id' => $quotation_id));

 		 	 	$created_by = $purchase_orders[0]['created_by'];

 		 	 	$created_user = $this->user_model->get_user_details($created_by);

 		 	 	$approval_by = $purchase_orders[0]['approval_by'];

 		 	 	$approved_user = $this->user_model->get_user_details($approval_by);
 		 	 	
 		 	 	$purchase_orders[0]['po_materials'] = $selected_materials;
 		 	 	$purchase_orders[0]['po_department'] = $dep_details;
 		 	 	$purchase_orders[0]['po_quotation'] = $quotation_details;
 		 	 	$purchase_orders[0]['po_created_by'] = $created_user;
 		 	 	$purchase_orders[0]['po_approval_by'] = $approved_user;
 		 	 	$data_result = array(
 		 	 		'status' => 'success',
 		 	 		'po' => $purchase_orders
 		 	 	);
 		 	 }else{
 		 	 	 $data_result = array(
 		 	 	 	'status' => 'error',
 		 	 	 	'message' => 'Sorry! purchase order not found from Datar Cancer Genetics Limited'
 		 	 	 );
 		 	 }

		}else{
			$data_result = array(
 		 	 	 	'status' => 'error',
 		 	 	 	'message' => 'Sorry! purchase order not found from Datar Cancer Genetics Limited'
 		 	 );
		}
		echo json_encode($data_result); exit;
	}
}
?>