<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| Letakkan file ini di: application/config/routes.php
*/

$route['default_controller'] = 'surat';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['list-surat-tugas'] = 'surat/list_surat_tugas';

/*
| -------------------------------------------------------------------------
| SURAT ROUTES
| -------------------------------------------------------------------------
*/

// Download eviden - PENTING: Harus di atas route lain
$route['surat/download_eviden/(.+)'] = 'surat/download_eviden/$1';
$route['surat/dl/(.+)'] = 'surat/dl/$1'; // Backup download method

// CRUD routes
$route['surat'] = 'surat/index';
$route['surat/index'] = 'surat/index';
$route['surat/submit'] = 'surat/submit';
$route['surat/edit/(:num)'] = 'surat/edit/$1';
$route['surat/delete/(:num)'] = 'surat/delete/$1';
$route['list-surat-tugas'] = 'surat/list_surat_tugas';


// Legacy download URL
$route['surat/download_eviden_url'] = 'surat/download_eviden_url';

// AJAX routes
$route['surat/get_dosen_by_nip'] = 'surat/get_dosen_by_nip';
$route['surat/autocomplete_nip'] = 'surat/autocomplete_nip';

// DEBUG - HAPUS SETELAH SELESAI
$route['surat/test_path'] = 'surat/test_path';
$route['surat/debug_eviden/(:num)'] = 'surat/debug_eviden/$1';

// DASHBOARD
$route['kaprodi'] = 'Kaprodi';
$route['sekretariat'] = 'sekretariat';
$route['dekan'] = 'Dekan';

