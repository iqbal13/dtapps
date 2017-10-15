<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function ceklogin($username,$password){
    $a = $this->db->get_where('users',array('username' => $username, 'password' => $password));
    return $a->row_array();
  }


  public function selectanggota(){
    $this->db->select('*');
    $this->db->from('anggota');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectanggotawhere($id){
    $this->db->select('*');
    $this->db->from('anggota');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function insertanggota($data){
    if ($this->db->insert('anggota',$data)) {
      return true;
    }
  }

  public function updateanggota($id,$data){
    $this->db->set($data);
    $this->db->where('id',$id);
    if ($this->db->update('anggota')) {
      return true;
    }
  }

  public function deleteanggota($id){
    $this->db->where('id',$id);
    $this->db->delete('anggota');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  public function insertadmin($data){
    if ($this->db->insert('admin',$data)) {
      return true;
    }
  }  

  public function insertdonasi($data){
    if ($this->db->insert('daftar_zakat',$data)) {
      return true;
    }
  }

  public function getdonasi(){
    $a = $this->db->get('daftar_zakat')->result_array();
    return $a;
  }

  public function insertuser($data){

      $dt_user = array(
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => md5($data['password']),
        'id_level' => 1
      );

      $a = $this->db->insert('users',$dt_user);
      if($a){

          $dz = array(
            'email' => $data['email'],
            'nama_lengkap' => $data['nama_lengkap'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'pekerjaan' => $data['pekerjaan'],
            'tanggal_lahir' => $data['tanggal_lahir']);
          $b = $this->db->insert('muzakki',$dz);
          if($b){
            return TRUE;
          }


      }else{
        return FALSE;
      }

  }

  public function selectbuku(){
    $this->db->select('*');
    $this->db->from('buku');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectbukuwhere($id){
    $this->db->select('*');
    $this->db->from('buku');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function insertbuku($data){
    if ($this->db->insert('buku',$data)) {
      return true;
    }
  }

  public function updatebuku($id,$data){
    $this->db->set($data);
    $this->db->where('id',$id);
    if ($this->db->update('buku')) {
      return true;
    }
  }

  public function deletebuku($id){
    $this->db->where('id',$id);
    $this->db->delete('buku');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }


  //--------pinjam-----

  public function selectidbuku(){
    $this->db->select('id');
    $this->db->from('buku');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectidanggota(){
    $this->db->select('id');
    $this->db->from('anggota');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertpinjam($data){
    if ($this->db->insert('pinjam',$data)) {
      return true;
    }
  }

  public function selectpinjam(){
    $this->db->select('pinjam.id, anggota.nama, buku.judul, pinjam.tgl_pinjam, pinjam.denda');
    $this->db->from('pinjam');
    $this->db->join('anggota','pinjam.id_anggota = anggota.id');
    $this->db->join('buku','pinjam.id_buku = buku.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectpinjamwhere($idpinjam){
    $this->db->select('pinjam.id, anggota.nama, buku.judul, pinjam.tgl_pinjam, pinjam.denda');
    $this->db->from('pinjam');
    $this->db->join('anggota','pinjam.id_anggota = anggota.id');
    $this->db->join('buku','pinjam.id_buku = buku.id');
    $this->db->where('pinjam.id',$idpinjam);
    $query = $this->db->get();
    return $query->result();
  }

  public function updatepinjam($id,$data){
    $this->db->set($data);
    $this->db->where('id',$id);
    if ($this->db->update('pinjam')) {
      return true;
    }
  }

  public function deletepinjam($id){
    $this->db->where('id',$id);
    $this->db->delete('pinjam');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

}
