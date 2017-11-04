<?php 

	class Download extends CI_Controller {

		function __construct(){
			parent::__construct();

			$this->load->helper('download');
		}

		function index(){
			$this->load->helper('url');
$file = "dnt.apk";
	force_download("dnt.apk","./apk/android-debug.apk");
		}

	}