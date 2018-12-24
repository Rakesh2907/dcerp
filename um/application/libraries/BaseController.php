<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 
date_default_timezone_set('Asia/Kolkata');

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $global = array ();
	
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}
	
	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		//$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		$mainSession = $this->session->userdata('um');
        $isLoggedIn = $mainSession['isLoggedIn'];
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			$this->role_id = $mainSession[ 'role_id' ];
			$this->user_id = $mainSession[ 'userId' ];
			$this->name = $mainSession[ 'name' ];

            $this->global ['userId'] = $this->user_id;
            $this->global ['role_id'] = $this->role_id;
            $this->global ['name'] = $this->name;

            if(isset($mainSession['pswd_updated_days']) && !empty($mainSession['pswd_updated_days']) && ($mainSession['pswd_updated_days'] >= PASSWROD_UPDATE_DAYS) && ($this->role_id != ROLE_ADMIN)) {
            	$this->global ['pswd_updated_days'] = $mainSession['pswd_updated_days'];
            	$this->global ['pswd_updated_now'] = "changePassword";
				$segment = $this->uri->segment_array();
				if((!in_array("loadChangePass", $segment)) && (!in_array("changePassword", $segment))){
					//$this->session->set_flashdata('error', "It's being too long that you had updated your password.<br>Please update now.");
					redirect ('user/loadChangePass');
				}
			}
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->role_id != ROLE_ADMIN) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isTicketter() {
		if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$this->global ['pageTitle'] = 'Access Denied';

		$data = $this->global;

		$data['page'] = "access";
        $this->load->view('dashboard/main_dashboard_template',$data);
		
		/*$this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );*/
	}
	
	/**
	 * This function is used to logged out user from system
	 */
	function main_logout() {
		$this->session->sess_destroy ();
		
		redirect ( 'login' );
	}
	
	/**
	 * This function used provide the pagination resources
	 * @param {string} $link : This is page link
	 * @param {number} $count : This is page count
	 * @param {number} $perPage : This is records per page limit
	 * @return {mixed} $result : This is array of records and pagination data
	 */
	function paginationCompress($link, $count, $perPage = 10) {
		$this->load->library ( 'pagination' );
	
		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = SEGMENT;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';
	
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( SEGMENT );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}
}