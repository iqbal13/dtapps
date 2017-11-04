<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apiusercontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
    $this->load->library('form_validation');
  }

  private function cekusername($type,$username){
    if($type == "username"){
    $a = $this->db->get_where('users',array('username' => $username));
    }else{
      $a = $this->db->get_where('users',array('email' => $username));
    }
    if($a->num_rows() == 0){
      return TRUE;
    }else{
      return FALSE;
    }

  }

  //method untuk melakukan penambahan admin (post)

  function user_post(){
  //header("Access-Control-Allow-Origin: *");
    $dt = json_decode($this->post()[0]);
    $username = $dt->username;
    $password = $dt->password;
    if($username == "" OR $password == ""){
    $this->response([
          'status' => FALSE,
          'message'=>'Harap isikan Username dan Password'
        ],Restdata::HTTP_OK);    
    }else{
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
          'message'=> 'Gagal Login',
        ],Restdata::HTTP_OK);

      }


    }


  }

  function ubahpassword_post(){
    $dt = json_decode($this->post()[0]);
    $id_user = $dt->id_user;
    $password = $dt->password;
    $password = md5($password);

    $data = array(
      'password' => $password);
    $a = $this->db->update('users',$data,array('id_user' => $id_user));
    if($a){

        $this->response([
          'status' => TRUE,
          'message'=> 'Password Berhasil Dirubah',
        ],Restdata::HTTP_OK);
    }else{
    $this->response([
          'status' => FALSE,
          'message'=> 'Password Gagal Dirubah !!',
        ],Restdata::HTTP_OK);

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

    $cekusername = $this->cekusername("username",$username);
    $cekemail = $this->cekusername("email",$email);


    if(!$cekusername){
        $this->response([
          'status' => FALSE,
          'message' => 'Username Telah Digunakan'
        ],Restdata::HTTP_OK);
        exit;
    }


    if(!$cekemail){
       $this->response([
          'status' => FALSE,
          'message' => 'Password Telah Digunakan'
        ],Restdata::HTTP_OK);
      exit;
    }

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

  function updateuser(){
    $dt = json_decode($this->post()[0]);
    $id_user = $dt->id_user;

    $username = $dt->username;
    $nama = $dt->nama;
    $email = $dt->email;

    $password = $dt->password;
    if($password == ""){
      $datanya = array(
        'username' => $username,
        'nama' => $nama,
        'email' => $email);
    }else{
      $datanya = array(
        'username' => $username,
        'nama' => $nama,
        'email' => $email,
        'password' => md5($password));
    }


    $aa = $this->db->update('users',$datanya,array('id_user' => $id_user));
    if($aa){
        $this->response([
          'status' => TRUE],Restdata::HTTP_OK);
    }else{

        $this->response([
          'status' => FALSE],Restdata::HTTP_OK);
    }

  }

  function getuserkelurahan_post(){
    $dt = json_decode($this->post()[0]);
    $id_user = $dt->id_user;
    $a = $this->db->get_where('users',array('id_user' => $id_user))->row_array();
    if($a){
      $this->response([
        'status' => TRUE,
        'data' => $a],Restdata::HTTP_OK);
    }else{

      $this->response([
        'status' => FALSE],Restdata::HTTP_OK);
    }
  }


  function getuserkel_post(){
    $a = $this->db->get_where('users',array('id_level' => 2))->result_array();
    if($a){
    $this->response([
          'status' => TRUE,
          'data' => $a
        ],Restdata::HTTP_OK);

    }else{
      $this->response([
        'status' => FALSE],Restdata::HTTP_OK);
    }
  }

  function getuserdetail_post(){
    $dt = json_decode($this->post()[0]);
    $id_user = $dt->id_user;
    $a = $this->db->query("SELECT * FROM users LEFT JOIN muzakki ON users.email = muzakki.email WHERE id_user = $id_user")->result_array();
    if($a){
    $this->response([
          'status' => TRUE,
          'data' => $a
        ],Restdata::HTTP_OK);

    }else{
      $this->response([
        'status' => FALSE],Restdata::HTTP_OK);
    }

  }

  function aktifkanuser_post(){
    $dt = json_decode($this->post()[0]);
    // echo $dt;
    // exit;
    $id_user = $dt->id_user;
    $status_user = $dt->status;

    // echo $id_user;
    // echo $status_user;
    // exit;

    $query = "UPDATE users SET status_user = '$status_user' WHERE id_user = $id_user";
    $b = $this->db->query($query);
    if($b){
  $this->response([
          'status' => TRUE,
          'message' => 'Aksi Berhasil Dilakukan'
        ],Restdata::HTTP_OK);

    }else{
      $this->response([
          'status' => FALSE,
        ],Restdata::HTTP_OK);

    }
  }

  function getusermasyarakat_post(){
 // $a = $this->db->get_where('users',array('id_level' => 1))->result_array();
    $a = $this->db->query("SELECT * FROM users LEFT JOIN muzakki ON users.email = muzakki.email WHERE id_level = 1")->result_array();
    if($a){
    $this->response([
          'status' => TRUE,
          'data' => $a
        ],Restdata::HTTP_OK);

    }else{
      $this->response([
        'status' => FALSE],Restdata::HTTP_OK);
    }
  }


  function tambahuser_post(){

    $dt = json_decode($this->post()[0]);
    $username = $dt->username;
    $password = $dt->password;
    $password = md5($password);
    $nama = $dt->nama;
    $email = $dt->email;
    $id_level = 2;
    $status_user = 1;

      $data = array(
        'username' => $username,
        'password' => $password,
        'email' => $email,
        'id_level' => $id_level,
        'nama' => $nama,
        'status_user' => $status_user);


      $a = $this->db->insert('users',$data);
      if($a){
        
         $this->response([
          'status' => TRUE,
          'message'=>'Pendaftaran Berhasil'
        ],Restdata::HTTP_OK);


      }else{

         $this->response([
          'status' => FALSE,
          'message'=>'Pendaftaran Gagal'
        ],Restdata::HTTP_OK);


      }



  }


}
