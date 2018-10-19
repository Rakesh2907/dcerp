<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_vendor extends CI_Controller{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('apivendor_model');		
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
}
?>