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


//---------------------------------api buku---------------------------------------------------------
$route['api/buku']['GET']                             = 'api/apibukucontroller/buku';
$route['api/buku/format/(:any)']['GET']               = 'api/apibukucontroller/buku/format/$1';
$route['api/buku/(:num)']['GET']                      = 'api/apibukucontroller/buku/id/$1';
$route['api/buku/(:num)/format/(:any)']['GET']        = 'api/apibukucontroller/buku/id/$1/format/$2';


$route['api/buku']['POST']                            = 'api/apibukucontroller/buku';
$route['api/buku/(:num)']['PUT']                      = 'api/apibukucontroller/buku/id/$1';
$route['api/buku/(:num)']['DELETE']                   = 'api/apibukucontroller/buku/id/$1';


//---------------------------------api pinjam---------------------------------------------------------

$route['api/pinjam']['GET']                            = 'api/apipinjamcontroller/pinjam';
$route['api/pinjam/format/(:any)']['GET']              = 'api/apipinjamcontroller/pinjam/format/$1';
$route['api/pinjam/(:num)']['GET']                     = 'api/apipinjamcontroller/pinjam/id/$1';
$route['api/pinjam/(:num)/format/(:any)']['GET']       = 'api/apipinjamcontroller/pinjam/id/$1/format/$2';

$route['api/pinjam']['POST']                           = 'api/apipinjamcontroller/pinjam';

$route['api/pinjam/(:num)']['PUT']                     = 'api/apipinjamcontroller/pinjam/id/$1';

$route['api/pinjam/(:num)']['DELETE']                  =  'api/apipinjamcontroller/pinjam/id/$1';



//---------------------------------View Token---------------------------------------------------------
$route['api/viewtoken']['POST']                       = 'api/restdata/viewtoken';


//---------------------------------api admin---------------------------------------------------------
$route['api/admin']['POST']                           = 'api/apiadmincontroller/admin';//untuk menambahkan admin
$route['api/login']['POST']                           = 'api/apiusercontroller/user';//untuk menambahkan admin
$route['api/signup']['POST']                           = 'api/apiusercontroller/adduser';//untuk menambahkan admin

$route['api/tambahdonasi']['POST'] 						= 'api/apidonasicontroller/donasi';

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
$route['api/donasiuser']['POST'] = 'api/apidonasicontroller/donasiuser';

$route['api/konfirmasipembayaran']['POST'] = 'api/apidonasicontroller/konfirmasipembayaran';