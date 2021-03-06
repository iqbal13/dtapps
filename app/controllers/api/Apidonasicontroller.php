<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apidonasicontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
  }

  function cekkonfirmasi_post(){
    $dt = json_decode($this->post()[0]);
    $id_user = $dt->id_user;
    $id_zakat = $dt->id_daftarzakat;

    $query1 = $this->db->get_where('trans_zakat',array('id_muzakki' => $id_user,'id_zakat' => $id_zakat))->row_array();
    $kode_unik = $query1['kode_unik'];

    // $cek = $this->db->get_where('konfirmasi_pembayaran',array('kode_unik' => $kode_unik,'id_user' => $id_user))->result_array();

    $cek = $this->db->query("SELECT * FROM konfirmasi_pembayaran left join master_statuskonfirmasi On konfirmasi_pembayaran.status = master_statuskonfirmasi.id_statuskonfirmasi WHERE kode_unik = '$kode_unik' AND id_user = '$id_user'")->result_array();

    if(count($cek) != 0){
         $this->response([
          'status' => TRUE,
          'data' => $cek[0]
                  ],Restdata::HTTP_OK);

    }else{

         $this->response([
          'status' => FALSE
                  ],Restdata::HTTP_OK);

    }

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

  function ubahstatuszakat_post(){
    $dt = json_decode($this->post()[0]);
    $id_daftarzakat = $dt->id_daftarzakat;
    $aktif = $dt->aktif;

    $query = "UPDATE daftar_zakat SET aktif = '$aktif' WHERE id_daftarzakat = '$id_daftarzakat'";
    $ab = $this->db->query($query);
    if($ab){
      $this->response([
        'status' => TRUE,
        'message' => 'Aksi Berhasil Dilakukan'],Restdata::HTTP_OK);
    }else{
    $this->response([
        'status' => FALSE,
        'message' => 'Aksi Gagal Dilakukan'],Restdata::HTTP_OK);
      
    }
  }

  //method untuk melakukan penambahan admin (post)

  function listdonasiall_post(){
//    $donasi = $this->db->get_where('daftar_zakat',array('aktif' => 0))->result_array();
    
    $donasi = $this->db->query("SELECT * FROM daftar_zakat LEFT JOIN users ON daftar_zakat.created_by = users.id_user WHERE aktif = 0")->result_array();

        if($donasi){

  $this->response([
          'status' => TRUE,
          'feedData' => $donasi
                  ],Restdata::HTTP_OK);

     }else{


  $this->response([
          'status' => TRUE,
          'feedData' => "Gagal Load Data"
                  ],Restdata::HTTP_FALSE);


     }



  }


  function listdonasiuser_post(){
    $donasi = $this->db->get_where('daftar_zakat',array('status !=' => '2','aktif' => 1))->result_array();

    if($donasi){

  $this->response([
          'status' => TRUE,
          'feedData' => $donasi
                  ],Restdata::HTTP_OK);

     }else{


  $this->response([
          'status' => TRUE,
          'feedData' => "Gagal Load Data"
                  ],Restdata::HTTP_FALSE);


     }


  }

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

  function updatestatus_post(){
    $dt = json_decode($this->post()[0]);
    $id_daftarzakat = $dt->id_daftarzakat;
    $status = $dt->status;

    $dta = array(
      'status' => $status);

    $a =  $this->db->update('daftar_zakat',$dta,array('id_daftarzakat' => $id_daftarzakat));
    if($a){
        $this->response([
          'status' => TRUE,
          'message'=>'Status Zakat Berhasil Dirubah'
        ],Restdata::HTTP_OK);
    }
  }



 function donasidetail_post(){
  $id_daftarzakat = 0;
    $dt = json_decode($this->post()[0]);

    $id_daftarzakat = $dt->id_daftarzakat;
   // echo $id_daftarzakat;

//    $donasi = $this->db->get_where('daftar_zakat',array('id_daftarzakat' => $id_daftarzakat))->row_array();

    $donasi = $this->db->query("SELECT * FROM daftar_zakat LEFT JOIN master_urgensi ON daftar_zakat.urgensi = master_urgensi.id_urgensi LEFT JOIN master_jeniszakat ON daftar_zakat.kategori_kebutuhan = master_jeniszakat.id_jeniszakat LEFT JOIN master_status ON daftar_zakat.status = master_status.id_status WHERE id_daftarzakat = '$id_daftarzakat'")->row_array();  
    $pendonasi = $this->db->query("SELECT * FROM trans_zakat LEFT JOIN daftar_zakat ON trans_zakat.id_zakat = daftar_zakat.id_daftarzakat LEFT JOIN users ON trans_zakat.id_muzakki = users.id_user LEFT JOIN muzakki ON users.email = muzakki.email LEFT JOIN konfirmasi_pembayaran ON trans_zakat.kode_unik = konfirmasi_pembayaran.kode_unik WHERE id_zakat = $id_daftarzakat and status_pendaftaran = '2'")->result_array();
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



 function donasidetailselesai_post(){
  $id_daftarzakat = 0;
    $dt = json_decode($this->post()[0]);

    $id_daftarzakat = $dt->id_daftarzakat;
   // echo $id_daftarzakat;

//    $donasi = $this->db->get_where('daftar_zakat',array('id_daftarzakat' => $id_daftarzakat))->row_array();

    $donasi = $this->db->query("SELECT * FROM daftar_zakat LEFT JOIN master_urgensi ON daftar_zakat.urgensi = master_urgensi.id_urgensi LEFT JOIN master_jeniszakat ON daftar_zakat.kategori_kebutuhan = master_jeniszakat.id_jeniszakat WHERE id_daftarzakat = '$id_daftarzakat' AND status = 2 AND status_pendaftaran = 2")->row_array();  
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



  function konfirmasipembayaran_post(){



    $dt = json_decode($this->post()[0]);
    $id_user = $dt->id_user;
    $id_daftarzakat = $dt->id_daftarzakat;
$a = $this->db->query("SELECT * FROM trans_zakat WHERE id_muzakki = '$id_user' AND id_zakat = '$id_daftarzakat'")->row_array();

    $kode_unik = $a['kode_unik'];
    // echo $kode_unik;

    // print_r($dt);
    // exit;

    $id_user = $dt->id_user;
    $dt = array(
      'kode_unik' => $kode_unik,
      'jumlah_pembayaran' => $dt->jumlah_pembayaran,
      'atas_nama' => $dt->atas_nama,
      'tanggal_transfer' => $dt->tanggal_transfer,
      'created_by' => $id_user,
      'id_user' => $id_user,
      'created_date' => date('Y-m-d H:i:s'),
      'status' => 1);

    $a = $this->db->insert('konfirmasi_pembayaran',$dt);
    if($a){

        $this->response([
          'status' => TRUE,
          'message' => 'Anda Telah berhasil melakukan konfirmasi pembayaran donasi, Terimakasih',
          'id_daftarzakat' => $this->db->insert_id()
                  ],Restdata::HTTP_OK);
    }else{
      $this->response([
          'status' => FALSE,
          'message' => 'Proses Gagal'
                  ],Restdata::HTTP_OK);
    }

  }


  function listkonfirmasi_post(){
    // $donasi = $this->db->get('konfirmasi_pembayaran')->result_array();

    $donasi = $this->db->query("SELECT * FROM konfirmasi_pembayaran LEFT JOIN master_statuskonfirmasi ON konfirmasi_pembayaran.status = master_statuskonfirmasi.id_statuskonfirmasi")->result_array();
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


  function konfirmdetail_post(){
    $dt = json_decode($this->post()[0]);
    $id = $dt->id_konfirm;
    $a = $this->db->query("SELECT * FROM konfirmasi_pembayaran LEFT JOIN trans_zakat ON konfirmasi_pembayaran.kode_unik = trans_zakat.kode_unik LEFT JOIN users ON konfirmasi_pembayaran.id_user = users.id_user LEFT JOIN daftar_zakat ON trans_zakat.id_zakat = daftar_zakat.id_daftarzakat WHERE id_konfirm = '$id'")->row_array();

    //print_r($a);


    if($a){
      $this->response([
        'status' => TRUE,
        'data' => $a],Restdata::HTTP_OK);

    }else{

      $this->response([
        'status' => FALSE
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

  function ubahpassword_post(){
    $dt = json_decode($this->post()[0]);

    $id_user = $dt->id_user;
    $password = $dt->password;
    $data = array(
      'password' => md5($password));

    $a = $this->db->update('user',$data,array('id_user' => $id_user));
    if($a){
   $this->response([
          'status' => TRUE,
          'message'=>'Edit Password Berhasil'
        ],Restdata::HTTP_OK);
    }else{
         $this->response([
          'status' => FALSE,
          'message'=>'Edit Password Gagal'
        ],Restdata::HTTP_OK);
    }

  }


  function cekdonasi_post(){

  $dt = json_decode($this->post()[0]);
  $id_user = $dt->id_user;
  $id_daftarzakat = $dt->id_daftarzakat;

  $a = $this->db->get_where('trans_zakat',array('id_muzakki' => $id_user,'id_zakat' => $id_daftarzakat))->result_array();

  $cekdt = $this->db->get_where('konfirmasi_pembayaran',array('kode_unik' => @$a[0]['kode_unik'],'status' => 2));



  if(count($a) == 0){

       return $this->response([
          'status' => FALSE
        ],Restdata::HTTP_OK);
  }else{
    if($cekdt->num_rows() == 0){
      $dtl = 0;
    }else{
      $dtl = $cekdt->row_array();
    }

       return $this->response([
          'status' => TRUE,
          'data_transfer' => $dtl,
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
      'status' => 1,
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

  public function resize_image($file_path, $width, $height) {

    $this->load->library('image_lib');

    $img_cfg['image_library'] = 'gd2';
    $img_cfg['source_image'] = $file_path;
    $img_cfg['maintain_ratio'] = TRUE;
    $img_cfg['create_thumb'] = TRUE;
    $img_cfg['new_image'] = $file_path;
    $img_cfg['width'] = $width;
    $img_cfg['quality'] = 100;
    $img_cfg['height'] = $height;

    $this->image_lib->initialize($img_cfg);
    $this->image_lib->resize();

}

  function uploaddata_post(){ 

    $a = $this->db->query("SELECT * FROM daftar_zakat ORDER BY id_daftarzakat DESC LIMIT 1");

          if($_FILES['file']['name'] != ''){
      $target_path = "img/masalah";
// $target_path = $target_path . basename( $_FILES['file']['name']);
  $temp = explode(".", $_FILES["file"]["name"]);//untuk mengambil nama file gambarnya saja tanpa format gambarnya
    $nama_baru = round(microtime(true)) . '.' . end($temp);//fungsi untuk membuat nama acak
      if (move_uploaded_file($_FILES["file"]["tmp_name"],$target_path."/".$nama_baru)) {
        $id = $temp[0];
        $t = base_url().$target_path.'/'.$nama_baru;
        $this->resize_image($target_path."/".$nama_baru,100,100);
        $query = "UPDATE daftar_zakat SET gambar = '$t' WHERE id_daftarzakat = '$id'";



        $this->db->query($query);
      } else {
    }
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
    $created_date = date('Y-m-d H:i:s');
    $created_by = $dt->created_by;

    $cek = $this->db->get_where('users',array('id_user' => $created_by))->row_array();
    if($cek['id_level'] == 3){
      $aktif = 1;
    }else{
      $aktif = 0;
    }

    $data = array(
      'nama_kebutuhan' => $nama_kebutuhan,
      'kebutuhan_dana' => $kebutuhan_dana,
      'nama_penerima' => $nama_penerima,
      'kategori_kebutuhan' => $kategori_kebutuhan,
      'status' => 1,
      'created_date' => $created_date,
      'created_by' => $created_by,
      'deskripsi' => $deskripsi,
      'tanggal' => $tanggal,
      'aktif' => $aktif);
  

      if ($this->mymodel->insertdonasi($data)) {


        $this->response([
          'status' => TRUE,
          'message'=>'Daftar Zakat berhasil ditambahkan',
          'id_daftarzakat' => $this->db->insert_id()
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
  $query = "SELECT * FROM trans_zakat LEFT JOIN daftar_zakat ON trans_zakat.id_zakat = daftar_zakat.id_daftarzakat LEFT JOIN master_status ON daftar_zakat.status = master_status.id_status WHERE id_muzakki = '$id_user'";
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


function donasiuserselesai_post(){
  $dt = json_decode($this->post()[0]);
  $id_user = $dt->id_user;
  $query = "SELECT * FROM trans_zakat LEFT JOIN daftar_zakat ON trans_zakat.id_zakat = daftar_zakat.id_daftarzakat LEFT JOIN master_status ON daftar_zakat.status = master_status.id_status WHERE id_muzakki = '$id_user' AND status = 2";
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

function uploadkonfirmasi_post(){

  print_r($_FILES);



           if($_FILES['file']['name'] != ''){
      $target_path = "img/konfirmasi/";
// $target_path = $target_path . basename( $_FILES['file']['name']);
  $temp = explode(".", $_FILES["file"]["name"]);//untuk mengambil nama file gambarnya saja tanpa format gambarnya
    $nama_baru = round(microtime(true)) . '.' . end($temp);//fungsi untuk membuat nama acak
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_path."/" . $nama_baru)) {
        $id = $temp[0];

        $t = base_url().$target_path.'/'.$nama_baru;

        $query = "UPDATE konfirmasi_pembayaran SET bukti_pembayaran = '$t' WHERE id_konfirm = '$id'";
        $this->db->query($query);
      } else {
      }
    }
}


function ubahstatuskonfirmasi_post(){
  $dt = json_decode($this->post()[0]);

  $id_konfirm = $dt->id_konfirm;
  $status = $dt->status;

  $query = $this->db->query("SELECT * FROM konfirmasi_pembayaran WHERE id_konfirm = '$id_konfirm'")->row_array();

  $kode_unik = $query['kode_unik'];

  $a = $this->db->query("UPDATE konfirmasi_pembayaran SET status = '$status' WHERE id_konfirm = '$id_konfirm'");
  if($a){

    if($status == 2){
      $query2 = $this->db->query("UPDATE trans_zakat SET status_pendaftaran = '$status' WHERE kode_unik = '$kode_unik'");

      $qq2 = $this->db->query("SELECT * FROM trans_zakat WHERE kode_unik = '$kode_unik'")->row_array();

      $id_daftarzakat = $qq2['id_zakat'];
      $uang_transfer = $query['jumlah_pembayaran'];

      $data = $this->db->query("SELECT * FROM daftar_zakat WHERE id_daftarzakat = '$id_daftarzakat'")->row_array();
     
      $angka = $data['progres_dana'];
      $total = $angka + $uang_transfer;

      $query3 = $this->db->query("UPDATE daftar_zakat SET progres_dana = '$total' WHERE id_daftarzakat = '$id_daftarzakat'");

    }else{

    }


        $this->response([
          'status' => TRUE,
          'message' => 'Status Konfirmasi Pembayaran Berhasil Dirubah'
        ],Restdata::HTTP_OK);

  }else{

        $this->response([
          'status' => FALSE,
          'message' => 'Status Konfirmasi Pembayaran GAGAL Dirubah'
        ],Restdata::HTTP_OK);
  }


}


  function getinformasi_post(){
    $a = $this->db->get_where('informasi')->row_array();
    if($a){
      $this->response([
        'status' => TRUE,
        'data' => $a],Restdata::HTTP_OK);
    }
  }


}
