<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apiusercontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
  }

  //method untuk melakukan penambahan admin (post)

  function user_post(){

  //  print_r($this->post());

    $dt = json_decode($this->post()[0]);
    $username = $dt->username;
    $password = $dt->password;
    if($username == "" OR $password == ""){
    $this->response([
          'status' => FALSE,
          'message'=>'Harap isikan Username dan Password'
        ],Restdata::HTTP_OK);    }else{


    $password = md5($password);

    $users = $this->mymodel->ceklogin($username,$password);
    if($users){

      if($users['id_level'] == 1){
        $url = "home";
      }else{
        $url = "homekelurahan";
      }

  $this->response([
          'status' => TRUE,
          'user' => $users,
          'message'=>'Login Berhasil',
          'url' => $url,
        ],Restdata::HTTP_OK);

      }else {

        $this->response([
          'status' => FALSE,
          'message'=>'Username atau Password anda salah.. Silahkan coba lagi'
        ],Restdata::HTTP_OK);

      }

    }



  }

  function adduser_post(){

    $dt = json_decode($this->post()[0]);

    $nama_lengkap = $dt->nama_lengkap;
    $tanggal_lahir = $dt->tanggal_lahir;
    $pekerjaan = $dt->pekerjaan;
    $email = $dt->email;
    $no_hp = $dt->no_hp;
    $alamat = $dt->alamat;
    $username = $dt->username;
    $password = $dt->password;

    $data = array(
      'nama_lengkap' => $nama_lengkap,
      'tanggal_lahir' => $tanggal_lahir,
      'pekerjaan' => $pekerjaan,
      'email' => $email,
      'no_hp' => $no_hp,
      'alamat' => $alamat,
      'username' => $username,
      'password' => $password);

    $this->form_validation->set_rules($email,'email','trim|is_unique[users.email]');
    $this->form_validation->set_rules($username,'username','trim|is_unique[users.username]');
  
    if ($this->form_validation->run()==false) {
       $this->response([
          'status' => FALSE,
          'message'=> $this->validation_errors()
      ],Restdata::HTTP_OK);
  
      
    }else {
      if ($this->mymodel->insertuser($data)) {

        $b = $this->db->get('users',array('username' => $username))->row_array();

        $this->response([
          'status' => TRUE,
          'user' => $b,
          'message'=>'Pendaftaran Berhasil'
        ],Restdata::HTTP_OK);

      }else {

     
        $this->response([
          'status' => FALSE,
          'message'=>'Pendaftaran Gagal'
        ],Restdata::HTTP_OK);

      }
    }
  }




}
