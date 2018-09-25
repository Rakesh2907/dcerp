<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
date_default_timezone_set('Asia/Kolkata');

/**
 * Class : BaseController
 * Base Class to control over all the classes
 */
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $user_permissions = array();
	protected $global = array ();
	protected $patient_id = '';

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
		$user_data = $this->session->userdata('resilient');
		$isLoggedIn = $user_data['isLoggedIn'];
		//echo "<pre>";print_r($user_data);echo "</pre>";exit;

		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {			
			$request_url = $this->uri->uri_string();
			$this->session->set_userdata('request_url', $request_url);
			//echo $request_url;exit;
            $this->load->model('login_model');
            $ip = get_client_ip();
            $this->login_model->logoutUser(null,$ip);
            $this->session->sess_destroy();
			redirect (base_url().'login' );
        }else{
            $this->load->model('user/user_model');
            $this->user_model->updateUserVerification($user_data);

            $this->name = $user_data['name'];
            $this->vendorId = $user_data['userId'];
            $this->role = $user_data['role'];
            $this->roleText = $user_data['roleText'];
            $this->user_permissions = $user_data['permissions'];
            if(isset($user_data['patient_id']) && !empty($user_data['patient_id'])){
            	$this->patient_id = $user_data['patient_id'];
            }

            $this->global['name'] = $this->name;
            $this->global['userId'] = $this->vendorId;
            $this->global['role_id'] = $this->role;
            $this->global['role'] = $this->roleText;
            $this->global ['access'] = array();
            if(!empty($this->user_permissions)){
            	$this->global ['access'] = json_decode($this->user_permissions);
            }

            if($this->session->userdata ( 'request_url' )){
            	$url = $this->session->userdata ( 'request_url' );
            	$this->session->unset_userdata('request_url');
            	redirect($url);
            }
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->role != ROLE_ADMIN) {
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

	function checkPermissions($permission_title) {
        $data = $this->global;
        if(($data['role'] === '1') && ($data['role_text'] === 'System Administrator')){
        	return true;
        }else{
        	if(!empty($permission_title) && in_array($permission_title, $data['user_permissions'])){
	            return true;
	        }elseif(in_array('all', $data['user_permissions'])){
	            return true;
	        }else{
	        	return false;
	        }
        }
        
    }

	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$data = $this->global;
        $data['page_title'] = "Access Denied";
        $data['page'] = 'errors/access';
		$this->load->view('main_dashboard_template',$data);
	}

	/**
	 * This function is used to logged out user from system
	 */
	function logoutComplete() {
		//$this->db->delete('reset_password', array('email'=>$email));
		$this->session->sess_destroy();
		//redirect('login');
		header('Location: /um');
	}

	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
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