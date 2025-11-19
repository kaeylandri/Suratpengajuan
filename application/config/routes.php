<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/

$route['default_controller'] = 'surat';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| SURAT ROUTES - FIXED
| -------------------------------------------------------------------------
*/

// DOWNLOAD ROUTES
$route['surat/download_eviden'] = 'surat/download_eviden';
$route['surat/download_eviden_url'] = 'surat/download_eviden_url';
$route['surat/dl/(.+)'] = 'surat/dl/$1';

// STATUS TRACKING
$route['surat/status/(:num)'] = 'surat/get_status/$1';
$route['api/status/(:num)'] = 'surat/get_status/$1';

// MULTI ACTION ROUTES
$route['surat/multi_delete'] = 'surat/multi_delete';
$route['surat/multi_edit'] = 'surat/multi_edit';
$route['surat/save_multi_edit'] = 'surat/save_multi_edit';

// CRUD ROUTES - FIXED
$route['surat'] = 'surat/index';
$route['surat/index'] = 'surat/index';
$route['surat/create'] = 'surat/create'; // ← TAMBAH INI
$route['surat/submit'] = 'surat/submit';
$route['surat/edit/(:num)'] = 'surat/edit/$1';
$route['surat/delete/(:num)'] = 'surat/delete/$1';
$route['surat/cetak/(:num)'] = 'surat/cetak/$1';

// LIST SURAT TUGAS - FIXED (HAPUS DUPLIKAT)
$route['list-surat-tugas'] = 'surat/list_surat_tugas'; // ← HANYA INI YANG PENTING!

// QR CODE
$route['surat/generate_qr/(:num)'] = 'surat/generate_qr/$1';

// AJAX ROUTES
$route['surat/get_dosen_by_nip'] = 'surat/get_dosen_by_nip';
$route['surat/autocomplete_nip'] = 'surat/autocomplete_nip';

// DEBUG ROUTES
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
| API ROUTES
| -------------------------------------------------------------------------
*/

$route['api/surat/status/(:num)'] = 'surat/get_status/$1';
$route['api/surat/list'] = 'surat/index';
$route['api/surat/detail/(:num)'] = 'surat/get_status/$1';

/*
| -------------------------------------------------------------------------
| CATCH-ALL ROUTE
| -------------------------------------------------------------------------
*/

$route['(:any)'] = 'errors/page_404';