<?php 

	class Download extends CI_Controller {

		function __construct(){
			parent::__construct();

			$this->load->helper('download');
		}

		function index(){
			$this->load->helper('url');
$file = "android-debug.apk";
	forced
	force_download(base_url().'apk/android-debug.apk',NULL);
		}

	}