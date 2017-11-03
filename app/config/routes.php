<?php
defined('BASEPATH') OR exit('No direct script access allowed');




$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//---------------------------------api anggota----------------------------------------------------

$route['api/anggota']['GET']                          = 'api/apianggotacontroller/anggota';
$route['api/anggota/format/(:any)']['GET']            = 'api/apianggotacontroller/anggota/format/$1';
$route['api/anggota/(:num)']['GET']                   = 'api/apianggotacontroller/anggota/id/$1';
$route['api/anggota/(:num)/format/(:any)']['GET']     = 'api/apianggotacontroller/anggota/id/$1/format/$2';

$route['api/anggota']['POST']                         = 'api/apianggotacontroller/anggota';
$route['api/anggota/(:num)']['PUT']                   = 'api/apianggotacontroller/anggota/id/$1';
$route['api/anggota/(:num)']['DELETE']                = 'api/apianggotacontroller/anggota/id/$1';




//---------------------------------api admin---------------------------------------------------------
$route['api/admin']['POST']                           = 'api/apiadmincontroller/admin';//untuk menambahkan admin
$route['api/login']['POST']                           = 'api/apiusercontroller/user';//untuk menambahkan admin
$route['api/signup']['POST']                           = 'api/apiusercontroller/adduser';//untuk menambahkan admin
$route['api/tambahuser']['POST']                           = 'api/apiusercontroller/tambahuser';//untuk menambahkan admin

$route['api/tambahdonasi']['POST'] 						= 'api/apidonasicontroller/donasi';
$route['api/getuserkel']['POST'] 						= 'api/apiusercontroller/getuserkel';



$route['api/editdonasi']['POST'] 						= 'api/apidonasicontroller/editdonasi';


$route['api/getdonasi']['POST'] 						= 'api/apidonasicontroller/listdonasi';
$route['api/listkonfirmasi']['POST'] 						= 'api/apidonasicontroller/listkonfirmasi';

$route['api/deletedonasi']['POST']                           = 'api/apidonasicontroller/deldonasi';

$route['api/getjenis']['POST'] = 'api/apidonasicontroller/masterzakat';
$route['api/geturgensi']['POST'] = 'api/apidonasicontroller/masterurgensi';
$route['api/getstatus']['POST'] = 'api/apidonasicontroller/masterstatus';
$route['api/berdonasi']['POST'] = 'api/apidonasicontroller/berdonasi';

$route['api/cekdonasi']['POST'] = 'api/apidonasicontroller/cekdonasi';
$route['api/detaildonasi']['POST'] = 'api/apidonasicontroller/donasidetail';
$route['api/detaildonasiselesai']['POST'] = 'api/apidonasicontroller/donasidetailselesai';
$route['api/donasiuser']['POST'] = 'api/apidonasicontroller/donasiuser';
$route['api/donasiuserselesai']['POST'] = 'api/apidonasicontroller/donasiuserselesai';

$route['api/konfirmasipembayaran']['POST'] = 'api/apidonasicontroller/konfirmasipembayaran';

$route['api/updatestatus']['POST'] = 'api/apidonasicontroller/updatestatus';
$route['api/getdonasiuser']['POST'] = 'api/apidonasicontroller/listdonasiuser';

$route['api/upload']['POST'] = 'api/apidonasicontroller/uploaddata';