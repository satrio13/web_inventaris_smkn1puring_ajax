<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->model('auth_model');
	} 

	function index()
	{	
		redirect('auth/login');
    }
    
    function login()
	{	
        $this->auth_model->login();
        $this->load->view('auth/login');
    }

    function logout()
    {  
        $this->auth_model->logout();
    }

}
