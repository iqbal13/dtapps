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

$route['api/getuserdetail']['POST']						= 'api/apiusercontroller/getuserdetail';
$route['api/tambahdonasi']['POST'] 						= 'api/apidonasicontroller/donasi';
$route['api/getuserkel']['POST'] 						= 'api/apiusercontroller/getuserkel';
$route['api/ubahpassword']['POST']						=	'api/apiusercontroller/ubahpassword';
$route['api/getusermasyarakat']['POST']					= 'api/apiusercontroller/getusermasyarakat';

$route['api/editdonasi']['POST'] 						= 'api/apidonasicontroller/editdonasi';
$route['api/aktifkanuser']['POST']						= 'api/apiusercontroller/aktifkanuser';

$route['api/getdonasi']['POST'] 						= 'api/apidonasicontroller/listdonasi';
$route['api/getdonasiall']['POST'] 						= 'api/apidonasicontroller/listdonasiall';
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


$route['api/uploadkonfirmasi']['POST'] = 'api/apidonasicontroller/uploadkonfirmasi';

$route['api/listkonfirmasidetail']['POST'] = 'api/apidonasicontroller/konfirmdetail';

$route['api/ubahstatuskonfirmasi']['POST'] = 'api/apidonasicontroller/ubahstatuskonfirmasi';

$route['api/ubahstatuszakat']['POST'] = 'api/apidonasicontroller/ubahstatuszakat';

$route['api/cekkonfirmasi']['POST'] = 'api/apidonasicontroller/cekkonfirmasi';


$route['api/getinformasi']['POST'] = 'api/apidonasicontroller/getinformasi';