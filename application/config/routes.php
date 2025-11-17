<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'surat';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ROUTES SURAT
$route['surat']                  = 'surat/index';
$route['surat/tambah']           = 'surat/tambah';
$route['surat/submit']           = 'surat/submit';
$route['surat/edit/(:num)']      = 'surat/edit/$1';
$route['surat/update/(:num)']    = 'surat/update/$1';
$route['surat/delete/(:num)']    = 'surat/delete/$1';
$route['surat/download_eviden/(:any)'] = 'surat/download_eviden/$1';


// ROUTE AUTOCOMPLETE NIP
$route['surat/autocomplete-nip'] = 'surat/autocomplete_nip';
$route['get-dosen'] = 'Surat/get_dosen_by_nip';


