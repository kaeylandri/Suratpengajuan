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

/*
| -------------------------------------------------------------------------
| SURAT ROUTES
| -------------------------------------------------------------------------
*/

// Download routes - PENTING: Harus di atas route lain
$route['surat/download_eviden'] = 'surat/download_eviden';
$route['surat/download_eviden_url'] = 'surat/download_eviden_url';
$route['surat/dl/(.+)'] = 'surat/dl/$1'; // Backup download method

// Status tracking route - NEW
$route['surat/status/(:num)'] = 'surat/get_status/$1';
$route['api/status/(:num)'] = 'surat/get_status/$1';

// CRUD routes
$route['surat'] = 'surat/index';
$route['surat/index'] = 'surat/index';
$route['surat/submit'] = 'surat/submit';
$route['surat/edit/(:num)'] = 'surat/edit/$1';
$route['surat/delete/(:num)'] = 'surat/delete/$1';
$route['surat/multi_delete'] = 'surat/multi_delete';
$route['surat/multi_edit'] = 'surat/multi_edit';
$route['surat/save_multi_edit'] = 'surat/save_multi_edit';
$route['surat/cetak/(:num)'] = 'surat/cetak/$1';

// List surat tugas
$route['list-surat-tugas'] = 'surat/list_surat_tugas';

// QR Code
$route['surat/generate_qr/(:num)'] = 'surat/generate_qr/$1';

// AJAX routes
$route['surat/get_dosen_by_nip'] = 'surat/get_dosen_by_nip';
$route['surat/autocomplete_nip'] = 'surat/autocomplete_nip';

// DEBUG routes - HAPUS SETELAH SELESAI
$route['surat/test_path'] = 'surat/test_path';
$route['surat/debug_eviden/(:num)'] = 'surat/debug_eviden/$1';

/*
| -------------------------------------------------------------------------
| DASHBOARD ROUTES
| -------------------------------------------------------------------------
*/

// Dekan routes
$route['dekan'] = 'dekan/index';
$route['dekan/dashboard'] = 'dekan/index';
$route['dekan/test'] = 'dekan/test';

// Kaprodi routes
$route['kaprodi'] = 'kaprodi/index';
$route['kaprodi/dashboard'] = 'kaprodi/index';

// Sekretariat routes
$route['sekretariat'] = 'sekretariat/index';
$route['sekretariat/dashboard'] = 'sekretariat/index';

/*
| -------------------------------------------------------------------------
| API ROUTES (Optional)
| -------------------------------------------------------------------------
*/

// API routes untuk mobile app atau third party
$route['api/surat/status/(:num)'] = 'surat/get_status/$1';
$route['api/surat/list'] = 'surat/index';
$route['api/surat/detail/(:num)'] = 'surat/get_status/$1';

/*
| -------------------------------------------------------------------------
| CATCH-ALL ROUTE (Harus di paling bawah)
| -------------------------------------------------------------------------
*/

// Catch-all untuk handling error 404
$route['(:any)'] = 'errors/page_404';