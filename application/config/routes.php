<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
// $route['default_controller'] = 'home/maintenance';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login-mhs'] = 'home/loginMhs';
$route['registrasi-mhs'] = 'home/registrasiMhs';
$route['saveRegistrasi'] = 'home/saveRegistrasi';
$route['loginMhs'] = 'home/loginPost';
$route['cari'] = 'home/cari';
$route['blog'] = 'home/blog/1';
$route['detail/(:any)'] = 'home/detail/$1';

$route['dosen'] = 'home/dosen';
$route['dosen/(:num)'] = 'home/dosenDetail/$1';
$route['info/(:any)'] = 'home/infoDetail/$1';
$route['informasi/(:any)'] = 'home/informasi/$1';
$route['p/(:any)'] = 'home/p/$1';
$route['a/(:any)'] = 'home/a/$1';
$route['visimisi'] = 'home/profil/4';
$route['strukturorganisasi'] = 'home/profil/5';
$route['prospekkerja'] = 'home/profil/3';
$route['blog/pages'] = 'blog';
$route['kategori/(:any)'] = 'home/kategori/$1';
$route['penulis/(:num)'] = 'home/penulis/$1';
$route['blog/pages/(:any)'] = 'home/blog/$1';

