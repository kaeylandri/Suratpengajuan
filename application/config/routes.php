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
$route['surat/create'] = 'surat/create';
$route['surat/submit'] = 'surat/submit';
$route['surat/edit/(:num)'] = 'surat/edit/$1';
$route['surat/delete/(:num)'] = 'surat/delete/$1';
$route['surat/cetak/(:num)'] = 'surat/cetak/$1';

// STATS GRID ROUTES - UPDATED TO MATCH CONTROLLER
$route['surat/total'] = 'surat/halaman_total';
$route['surat/disetujui'] = 'surat/halaman_disetujui';
$route['surat/ditolak'] = 'surat/halaman_ditolak';
$route['surat/pending'] = 'surat/halaman_pending';

// COMPATIBILITY ROUTES - KEEP EXISTING FOR BACKWARD COMPATIBILITY
$route['surat/semua'] = 'surat/halaman_total';
$route['surat/menunggu'] = 'surat/halaman_pending';

/*
| -------------------------------------------------------------------------
| SEKRETARIAT SURAT ROUTES - NEWLY ADDED
| -------------------------------------------------------------------------
*/
$route['surat/sekretariat/semua'] = 'surat/semua_sekretariat';
$route['surat/sekretariat/disetujui'] = 'surat/disetujui_sekretariat';
$route['surat/sekretariat/ditolak'] = 'surat/ditolak_sekretariat';
$route['surat/sekretariat/pending'] = 'surat/pending_sekretariat';
$route['surat/sekretariat/menunggu'] = 'surat/menunggu_sekretariat';

// APPROVAL ROUTES
$route['surat/setujui/(:num)'] = 'surat/setujui/$1';
$route['surat/tolak/(:num)'] = 'surat/tolak/$1';
$route['surat/update_status/(:num)/(:any)'] = 'surat/update_status/$1/$2';

// DETAIL ROUTE
$route['surat/detail/(:num)'] = 'surat/detail/$1';

// LIST SURAT TUGAS
$route['list-surat-tugas'] = 'surat/list_surat_tugas';

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

// Dekan routes - UPDATED WITH NEW PAGES
$route['dekan'] = 'dekan/index';
$route['dekan/dashboard'] = 'dekan/index';
$route['dekan/index'] = 'dekan/index';
$route['dekan/index/(:any)'] = 'dekan/index/$1';
$route['dekan/halaman_total'] = 'dekan/halaman_total';
$route['dekan/halaman_disetujui'] = 'dekan/halaman_disetujui';
$route['dekan/halaman_ditolak'] = 'dekan/halaman_ditolak';
$route['dekan/halaman_pending'] = 'dekan/halaman_pending';
$route['dekan/approve/(:num)'] = 'dekan/approve/$1';
$route['dekan/reject/(:num)'] = 'dekan/reject/$1';
$route['dekan/detail/(:num)'] = 'dekan/detail/$1';
$route['dekan/laporan'] = 'dekan/laporan';
$route['dekan/list_surat_tugas'] = 'dekan/list_surat_tugas';
$route['dekan/filter/(:any)'] = 'dekan/filter/$1';
$route['dekan/test'] = 'dekan/test';

// Kaprodi routes
$route['kaprodi'] = 'kaprodi/index';
$route['kaprodi/dashboard'] = 'kaprodi/index';
$route['kaprodi/approve/(:num)'] = 'kaprodi/approve/$1';
$route['kaprodi/reject/(:num)'] = 'kaprodi/reject/$1';

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
| CATCH-ALL ROUTE - HARUS DI BAWAH
| -------------------------------------------------------------------------
*/

$route['(:any)'] = 'errors/page_404';