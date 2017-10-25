<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apidonasicontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
  }

  public function berdonasi_post(){
    $dt = json_decode($this->post()[0]);
    $id_daftarzakat = $dt->id_daftarzakat;
    $id_user = $dt->id_user;
    $dd = $id_user * 3;
    $kode_unik = strtotime(date('Y-m-d H:i:s'))."-".$dd;
    $dt = array(
      'id_muzakki' => $id_user,
      'id_zakat' => $id_daftarzakat,
      'status_pendaftaran' => '1',
      'kode_unik' => $kode_unik);

    $a = $this->db->insert('trans_zakat',$dt);
    if($a){
        $this->response([
          'status' => TRUE,
          'message' => 'Anda Telah berhasil berdonasi',
          'data' => $dt
                  ],Restdata::HTTP_OK);
    }
    }



  public function masterzakat_post(){
    $a = $this->db->get('master_jeniszakat')->result_array();

    $this->response([
          'status' => TRUE,
          'jeniszakat' => $a,
                  ],Restdata::HTTP_OK);
  }
public function masterurgensi_post(){
    $a = $this->db->get('master_urgensi')->result_array();

    $this->response([
          'status' => TRUE,
          'urgensistatus' => $a,
                  ],Restdata::HTTP_OK);
  }
public function masterstatus_post(){
    $a = $this->db->get('master_status')->result_array();

    $this->response([
          'status' => TRUE,
          'statuszakat' => $a,
                  ],Restdata::HTTP_OK);
  }

  function deldonasi_post(){

   $dt =  json_decode($this->post()[0]);

    $id_zakat = $dt->id_daftarzakat;

    $a = $this->db->delete('daftar_zakat',array('id_daftarzakat' => $id_zakat));
    if($a){
       $this->response([
          'status' => TRUE,
          'message' => 'Donasi berhasil dihapuskan'
                  ],Restdata::HTTP_OK);
    }
  }

  //method untuk melakukan penambahan admin (post)

  function listdonasi_post(){
    $donasi = $this->mymodel->getdonasi();

    if($donasi){

  $this->response([
          'status' => TRUE,
          'feedData' => $donasi
                  ],Restdata::HTTP_OK);
}else{

  $this->response([
          'status' => FALSE,
          'message'=>'Gagal Load Data'
        ],Restdata::HTTP_OK);
}
  }



 function donasidetail_post(){
    $dt = json_decode($this->post()[0]);
    $id_daftarzakat = $dt->id_daftarzakat;

    $donasi = $this->db->get_where('daftar_zakat',array('id_daftarzakat' => $id_daftarzakat))->row_array();

    $donasi = $this->db->query("SELECT * FROM daftar_zakat LEFT JOIN master_urgensi ON daftar_zakat.urgensi = master_urgensi.id_urgensi LEFT JOIN master_jeniszakat ON daftar_zakat.kategori_kebutuhan = master_jeniszakat.id_jeniszakat")->row_array();  
    $pendonasi = $this->db->query("SELECT * FROM trans_zakat LEFT JOIN daftar_zakat ON trans_zakat.id_zakat = daftar_zakat.id_daftarzakat LEFT JOIN users ON trans_zakat.id_muzakki = users.id_user LEFT JOIN muzakki ON users.email = muzakki.email WHERE id_zakat = '$id_daftarzakat'")->result_array();
    if($donasi){

  $this->response([
          'status' => TRUE,
          'feedData' => $donasi,
          'pendonasi' => $pendonasi
                  ],Restdata::HTTP_OK);
}else{

  $this->response([
          'status' => FALSE,
          'message'=>'Gagal Load Data'
        ],Restdata::HTTP_OK);
}
  }


  function listkonfirmasi_post(){
    $donasi = $this->db->get('konfirmasi_pembayaran')->result_array();
    if($donasi){

  $this->response([
          'status' => TRUE,
          'konfirmasi' => $donasi
                  ],Restdata::HTTP_OK);
}else{

  $this->response([
          'status' => FALSE,
          'message'=>'Gagal Load Data'
        ],Restdata::HTTP_OK);
}
  }

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

  function cekdonasi_post(){

  $dt = json_decode($this->post()[0]);
  $id_user = $dt->id_user;
  $id_daftarzakat = $dt->id_daftarzakat;

  $a = $this->db->get_where('trans_zakat',array('id_muzakki' => $id_user,'id_zakat' => $id_daftarzakat))->result_array();

  if(count($a) == 0){

       return $this->response([
          'status' => FALSE
        ],Restdata::HTTP_OK);
  }else{

       return $this->response([
          'status' => TRUE        
        ],Restdata::HTTP_OK);
  }

  }

  function ubahstatus_post(){
    $dt = $json_decode($this->post()[0]);
    $id_daftarzakat = $dt->id_daftarzakat;


    
  }

  function editdonasi_post(){
      $dt = json_decode($this->post()[0]);

    $id_daftarzakat = $dt->id_daftarzakat;
    $nama_kebutuhan = $dt->nama_kebutuhan;
    $kebutuhan_dana = $dt->kebutuhan_dana;
    $nama_penerima = $dt->nama_penerima;
    $kategori_kebutuhan = $dt->kategori_kebutuhan;
    $urgensi = $dt->urgensi;
    $deskripsi = $dt->deskripsi;
    $tanggal = $dt->tanggal;
    $created_date = date('Y-m-d');
    $data = array(
      'nama_kebutuhan' => $nama_kebutuhan,
      'kebutuhan_dana' => $kebutuhan_dana,
      'nama_penerima' => $nama_penerima,
      'kategori_kebutuhan' => $kategori_kebutuhan,
      'urgensi' => $urgensi,
      'status' => 'Proses',
      'created_date' => $created_date,
      'deskripsi' => $deskripsi,
      'tanggal' => $tanggal);
    
        $query = $this->db->update('daftar_zakat',$data,array('id_daftarzakat' => $id_daftarzakat));
      if ($query) {


        $this->response([
          'status' => TRUE,
          'message'=>'Edit Zakat Berhasil'
        ],Restdata::HTTP_OK);

      }else {

     
        $this->response([
          'status' => FALSE,
          'message'=>'Edit zakat gagal ditambahkan'
        ],Restdata::HTTP_OK);

      
    }
  }

  function donasi_post(){
      // $at = json_decode($this->files()[0]);
      $dt = json_decode($this->post()[0]);


    $nama_kebutuhan = $dt->nama_kebutuhan;
    $kebutuhan_dana = $dt->kebutuhan_dana;
    $nama_penerima = $dt->nama_penerima;
    $kategori_kebutuhan = $dt->kategori_kebutuhan;
    $urgensi = $dt->urgensi;
    $deskripsi = $dt->deskripsi;
    $tanggal = $dt->tanggal;
    $created_date = date('Y-m-d');
    $data = array(
      'nama_kebutuhan' => $nama_kebutuhan,
      'kebutuhan_dana' => $kebutuhan_dana,
      'nama_penerima' => $nama_penerima,
      'kategori_kebutuhan' => $kategori_kebutuhan,
      'urgensi' => $urgensi,
      'status' => 'Proses',
      'created_date' => $created_date,
      'deskripsi' => $deskripsi,
      'tanggal' => $tanggal);
  
      
      if ($this->mymodel->insertdonasi($data)) {


        $this->response([
          'status' => TRUE,
          'message'=>'Daftar Zakat berhasil ditambahkan'
        ],Restdata::HTTP_OK);

      }else {

     
        $this->response([
          'status' => FALSE,
          'message'=>'Daftar zakat gagal ditambahkan'
        ],Restdata::HTTP_OK);

      
    }
  }


function donasiuser_post(){
  $dt = json_decode($this->post()[0]);
  $id_user = $dt->id_user;
  $query = "SELECT * FROM trans_zakat LEFT JOIN daftar_zakat ON trans_zakat.id_zakat = daftar_zakat.id_daftarzakat WHERE id_muzakki = '$id_user'";
  $a = $this->db->query($query);
  $b = $a->result_array();
  if ($b) {


        $this->response([
          'status' => TRUE,
          'donasi'=> $b
        ],Restdata::HTTP_OK);

      }else {

     
        $this->response([
          'status' => FALSE,
          'message'=>'Tidak ada Data'
        ],Restdata::HTTP_OK);

      
    }


}



}
