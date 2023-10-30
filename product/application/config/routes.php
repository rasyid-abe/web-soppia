<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
    /* profil*/
	$route['profil'] = 'profil';
	$route['profil/store'] = 'profil/store';
	/* role */
	$route['role/permissionview/(:any)'] = 'role/permissionview/$1';
	$route['role/settimeaccessproseshw/(:any)'] = 'role/settimeaccessproseshw/$1';
	$route['role/settimeaccessprosestw/(:any)'] = 'role/settimeaccessprosestw/$1';
    /* start ttd */
	$route['pengaturan/tanda-tangan'] = 'pengaturan/tanda_tangan';
	$route['pengaturan/tanda-tangan/store'] = 'pengaturan/store_tanda_tangan';
    
    /* end ttd */
/* star Data Daerah */
	/* propinsi */
	$route['data-daerah/propinsi/delete-exec/(:any)'] = 'data-daerah/propinsi/delete_exec/$1';
	/*$route['data-daerah/propinsi'] = 'data-daerah/propinsi/index';
	$route['data-daerah/propinsi/getdata'] = 'data-daerah/propinsi/getdata';
	$route['data-daerah/propinsi/add'] = 'data-daerah/propinsi/add';
	$route['data-daerah/propinsi/store'] = 'data-daerah/propinsi/store';
	$route['data-daerah/propinsi/edit/(:any)'] = 'data-daerah/propinsi/edit/$1';
	$route['data-daerah/propinsi/update/(:any)'] = 'data-daerah/propinsi/update/$1';
	$route['data-daerah/propinsi/delete/(:any)'] = 'data-daerah/propinsi/delete/$1';
	$route['data-daerah/propinsi/view/(:any)'] = 'data-daerah/propinsi/details/$1';*/
	/* menu */
	$route['menu/set-position-menu'] = 'menu/set_position_menu';
	$route['menu/save-position-menu'] = 'menu/save_position_menu';
	/* kota training*/
	$route['data-daerah/kota-training'] = 'data-daerah/kota_training/index';
	$route['data-daerah/kota-training/getdata'] = 'data-daerah/kota_training/getdata';
	$route['data-daerah/kota-training/add'] = 'data-daerah/kota_training/add';
	$route['data-daerah/kota-training/store'] = 'data-daerah/kota_training/store';
	$route['data-daerah/kota-training/edit/(:any)'] = 'data-daerah/kota_training/edit/$1';
	$route['data-daerah/kota-training/update/(:any)'] = 'data-daerah/kota_training/update/$1';
	$route['data-daerah/kota-training/delete/(:any)'] = 'data-daerah/kota_training/delete/$1';
	$route['data-daerah/kota-training/delete-exec/(:any)'] = 'data-daerah/kota_training/delete_exec/$1';
	$route['data-daerah/kota-training/view/(:any)'] = 'data-daerah/kota_training/view/$1';

/* end Data Daerah */

/* start Data Bangunan */
	// gedung
	$route['bangunan/gedung/delete-exec/(:any)'] = 'bangunan/gedung/delete_exec/$1';
	
	// ruang lantai
	$route['bangunan/ruang-lantai'] = 'bangunan/ruang_lantai/index';
	$route['bangunan/ruang-lantai/getdata'] = 'bangunan/ruang_lantai/getdata';
	$route['bangunan/ruang-lantai/add'] = 'bangunan/ruang_lantai/add';
	$route['bangunan/ruang-lantai/store'] = 'bangunan/ruang_lantai/store';
	$route['bangunan/ruang-lantai/edit/(:any)'] = 'bangunan/ruang_lantai/edit/$1';
	$route['bangunan/ruang-lantai/update/(:any)'] = 'bangunan/ruang_lantai/update/$1';
	$route['bangunan/ruang-lantai/delete/(:any)'] = 'bangunan/ruang_lantai/delete/$1';
	$route['bangunan/ruang-lantai/delete-exec/(:any)'] = 'bangunan/ruang_lantai/delete_exec/$1';
	$route['bangunan/ruang-lantai/view/(:any)'] = 'bangunan/ruang_lantai/view/$1';

	// lokasi simpan
	$route['bangunan/lokasi-simpan'] = 'bangunan/lokasi_simpan/index';
	$route['bangunan/lokasi-simpan/getdata'] = 'bangunan/lokasi_simpan/getdata';
	$route['bangunan/lokasi-simpan/add'] = 'bangunan/lokasi_simpan/add';
	$route['bangunan/lokasi-simpan/store'] = 'bangunan/lokasi_simpan/store';
	$route['bangunan/lokasi-simpan/edit/(:any)'] = 'bangunan/lokasi_simpan/edit/$1';
	$route['bangunan/lokasi-simpan/update/(:any)'] = 'bangunan/lokasi_simpan/update/$1';
	$route['bangunan/lokasi-simpan/delete/(:any)'] = 'bangunan/lokasi_simpan/delete/$1';
	$route['bangunan/lokasi-simpan/delete-exec/(:any)'] = 'bangunan/lokasi_simpan/delete_exec/$1';
	$route['bangunan/lokasi-simpan/view/(:any)'] = 'bangunan/lokasi_simpan/view/$1';
/* end Data Bangunan*/

/* start data jenis usaha */
	// Jenis Usaha
	$route['jenis-usaha'] = 'jenis_usaha/index';
	$route['jenis-usaha/getdata'] = 'jenis_usaha/getdata';
	$route['jenis-usaha/add'] = 'jenis_usaha/add';
	$route['jenis-usaha/store'] = 'jenis_usaha/store';
	$route['jenis-usaha/edit/(:any)'] = 'jenis_usaha/edit/$1';
	$route['jenis-usaha/update/(:any)'] = 'jenis_usaha/update/$1';
	$route['jenis-usaha/delete/(:any)'] = 'jenis_usaha/delete/$1';
	$route['jenis-usaha/delete-exec/(:any)'] = 'jenis_usaha/delete_exec/$1';
	$route['jenis-usaha/view/(:any)'] = 'jenis_usaha/view/$1';
/* end data jenis usaha */

/* start data bidang unit organisasi */
	// Bidang unit organisasi
	$route['bidang-unit-organisasi'] = 'bidang_unit_organisasi/index';
	$route['bidang-unit-organisasi/getdata'] = 'bidang_unit_organisasi/getdata';
	$route['bidang-unit-organisasi/add'] = 'bidang_unit_organisasi/add';
	$route['bidang-unit-organisasi/store'] = 'bidang_unit_organisasi/store';
	$route['bidang-unit-organisasi/edit/(:any)'] = 'bidang_unit_organisasi/edit/$1';
	$route['bidang-unit-organisasi/update/(:any)'] = 'bidang_unit_organisasi/update/$1';
	$route['bidang-unit-organisasi/delete/(:any)'] = 'bidang_unit_organisasi/delete/$1';
	$route['bidang-unit-organisasi/delete-exec/(:any)'] = 'bidang_unit_organisasi/delete_exec/$1';
	$route['bidang-unit-organisasi/view/(:any)'] = 'bidang_unit_organisasi/view/$1';
/* end data bidang unit organisasi */

/* start data jenis pelatihan */
	// Jenis pelatihan 1
	$route['jenis-pelatihan/jenis-pelatihan-i'] = 'jenis-pelatihan/jenis_pelatihan_i/index';
	$route['jenis-pelatihan/jenis-pelatihan-i/getdata'] = 'jenis-pelatihan/jenis_pelatihan_i/getdata';
	$route['jenis-pelatihan/jenis-pelatihan-i/add'] = 'jenis-pelatihan/jenis_pelatihan_i/add';
	$route['jenis-pelatihan/jenis-pelatihan-i/store'] = 'jenis-pelatihan/jenis_pelatihan_i/store';
	$route['jenis-pelatihan/jenis-pelatihan-i/edit/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_i/edit/$1';
	$route['jenis-pelatihan/jenis-pelatihan-i/update/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_i/update/$1';
	$route['jenis-pelatihan/jenis-pelatihan-i/delete/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_i/delete/$1';
	$route['jenis-pelatihan/jenis-pelatihan-i/delete-exec/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_i/delete_exec/$1';
	$route['jenis-pelatihan/jenis-pelatihan-i/view/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_i/view/$1';
	// Jenis pelatihan 2
	$route['jenis-pelatihan/jenis-pelatihan-ii'] = 'jenis-pelatihan/jenis_pelatihan_ii/index';
	$route['jenis-pelatihan/jenis-pelatihan-ii/getdata'] = 'jenis-pelatihan/jenis_pelatihan_ii/getdata';
	$route['jenis-pelatihan/jenis-pelatihan-ii/add'] = 'jenis-pelatihan/jenis_pelatihan_ii/add';
	$route['jenis-pelatihan/jenis-pelatihan-ii/store'] = 'jenis-pelatihan/jenis_pelatihan_ii/store';
	$route['jenis-pelatihan/jenis-pelatihan-ii/edit/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_ii/edit/$1';
	$route['jenis-pelatihan/jenis-pelatihan-ii/update/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_ii/update/$1';
	$route['jenis-pelatihan/jenis-pelatihan-ii/delete/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_ii/delete/$1';
	$route['jenis-pelatihan/jenis-pelatihan-ii/delete-exec/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_ii/delete_exec/$1';
	$route['jenis-pelatihan/jenis-pelatihan-ii/view/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_ii/view/$1';
	// Jenis pelatihan 3
	$route['jenis-pelatihan/jenis-pelatihan-iii'] = 'jenis-pelatihan/jenis_pelatihan_iii/index';
	$route['jenis-pelatihan/jenis-pelatihan-iii/getdata'] = 'jenis-pelatihan/jenis_pelatihan_iii/getdata';
	$route['jenis-pelatihan/jenis-pelatihan-iii/add'] = 'jenis-pelatihan/jenis_pelatihan_iii/add';
	$route['jenis-pelatihan/jenis-pelatihan-iii/store'] = 'jenis-pelatihan/jenis_pelatihan_iii/store';
	$route['jenis-pelatihan/jenis-pelatihan-iii/edit/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_iii/edit/$1';
	$route['jenis-pelatihan/jenis-pelatihan-iii/update/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_iii/update/$1';
	$route['jenis-pelatihan/jenis-pelatihan-iii/delete/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_iii/delete/$1';
	$route['jenis-pelatihan/jenis-pelatihan-iii/delete-exec/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_iii/delete_exec/$1';
	$route['jenis-pelatihan/jenis-pelatihan-iii/view/(:any)'] = 'jenis-pelatihan/jenis_pelatihan_iii/view/$1';
	// Kelompok Pelatihan
	$route['jenis-pelatihan/kelompok-pelatihan'] = 'jenis-pelatihan/kelompok_pelatihan/index';
	$route['jenis-pelatihan/kelompok-pelatihan/getdata'] = 'jenis-pelatihan/kelompok_pelatihan/getdata';
	$route['jenis-pelatihan/kelompok-pelatihan/add'] = 'jenis-pelatihan/kelompok_pelatihan/add';
	$route['jenis-pelatihan/kelompok-pelatihan/store'] = 'jenis-pelatihan/kelompok_pelatihan/store';
	$route['jenis-pelatihan/kelompok-pelatihan/edit/(:any)'] = 'jenis-pelatihan/kelompok_pelatihan/edit/$1';
	$route['jenis-pelatihan/kelompok-pelatihan/update/(:any)'] = 'jenis-pelatihan/kelompok_pelatihan/update/$1';
	$route['jenis-pelatihan/kelompok-pelatihan/delete/(:any)'] = 'jenis-pelatihan/kelompok_pelatihan/delete/$1';
	$route['jenis-pelatihan/kelompok-pelatihan/delete-exec/(:any)'] = 'jenis-pelatihan/kelompok_pelatihan/delete_exec/$1';
	$route['jenis-pelatihan/kelompok-pelatihan/view/(:any)'] = 'jenis-pelatihan/kelompok_pelatihan/view/$1';
/* end data jenis pelatihan */


/* start data jenis sertifikasi */
	// Jenis sertifikasi 1
	$route['data-sertifikasi/jenis-sertifikasi-i'] = 'data-sertifikasi/jenis_sertifikasi_i/index';
	$route['data-sertifikasi/jenis-sertifikasi-i/getdata'] = 'data-sertifikasi/jenis_sertifikasi_i/getdata';
	$route['data-sertifikasi/jenis-sertifikasi-i/add'] = 'data-sertifikasi/jenis_sertifikasi_i/add';
	$route['data-sertifikasi/jenis-sertifikasi-i/store'] = 'data-sertifikasi/jenis_sertifikasi_i/store';
	$route['data-sertifikasi/jenis-sertifikasi-i/edit/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_i/edit/$1';
	$route['data-sertifikasi/jenis-sertifikasi-i/update/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_i/update/$1';
	$route['data-sertifikasi/jenis-sertifikasi-i/delete/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_i/delete/$1';
	$route['data-sertifikasi/jenis-sertifikasi-i/delete-exec/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_i/delete_exec/$1';
	$route['data-sertifikasi/jenis-sertifikasi-i/view/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_i/view/$1';

	// Jenis sertifikasi 2
	$route['data-sertifikasi/jenis-sertifikasi-ii'] = 'data-sertifikasi/jenis_sertifikasi_ii/index';
	$route['data-sertifikasi/jenis-sertifikasi-ii/getdata'] = 'data-sertifikasi/jenis_sertifikasi_ii/getdata';
	$route['data-sertifikasi/jenis-sertifikasi-ii/add'] = 'data-sertifikasi/jenis_sertifikasi_ii/add';
	$route['data-sertifikasi/jenis-sertifikasi-ii/store'] = 'data-sertifikasi/jenis_sertifikasi_ii/store';
	$route['data-sertifikasi/jenis-sertifikasi-ii/edit/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_ii/edit/$1';
	$route['data-sertifikasi/jenis-sertifikasi-ii/update/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_ii/update/$1';
	$route['data-sertifikasi/jenis-sertifikasi-ii/delete/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_ii/delete/$1';
	$route['data-sertifikasi/jenis-sertifikasi-ii/delete-exec/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_ii/delete_exec/$1';
	$route['data-sertifikasi/jenis-sertifikasi-ii/view/(:any)'] = 'data-sertifikasi/jenis_sertifikasi_ii/view/$1';

	// Sertifikasi
	$route['data-sertifikasi/sertifikasi'] = 'data-sertifikasi/sertifikasi/index';
	$route['data-sertifikasi/sertifikasi/getdata'] = 'data-sertifikasi/sertifikasi/getdata';
	$route['data-sertifikasi/sertifikasi/add'] = 'data-sertifikasi/sertifikasi/add';
	$route['data-sertifikasi/sertifikasi/store'] = 'data-sertifikasi/sertifikasi/store';
	$route['data-sertifikasi/sertifikasi/edit/(:any)'] = 'data-sertifikasi/sertifikasi/edit/$1';
	$route['data-sertifikasi/sertifikasi/update/(:any)'] = 'data-sertifikasi/sertifikasi/update/$1';
	$route['data-sertifikasi/sertifikasi/delete/(:any)'] = 'data-sertifikasi/sertifikasi/delete/$1';
	$route['data-sertifikasi/sertifikasi/delete-exec/(:any)'] = 'data-sertifikasi/sertifikasi/delete_exec/$1';
	$route['data-sertifikasi/sertifikasi/view/(:any)'] = 'data-sertifikasi/sertifikasi/view/$1';
/* end data jenis sertifikasi */


/* start data data diri */
	// gelar
	$route['data-diri/gelar/delete-exec/(:any)'] = 'data-diri/gelar/delete_exec/$1';
	// strata pendidikan
	$route['data-diri/strata-pendidikan'] = 'data-diri/strata_pendidikan/index';
	$route['data-diri/strata-pendidikan/getdata'] = 'data-diri/strata_pendidikan/getdata';
	$route['data-diri/strata-pendidikan/add'] = 'data-diri/strata_pendidikan/add';
	$route['data-diri/strata-pendidikan/store'] = 'data-diri/strata_pendidikan/store';
	$route['data-diri/strata-pendidikan/edit/(:any)'] = 'data-diri/strata_pendidikan/edit/$1';
	$route['data-diri/strata-pendidikan/update/(:any)'] = 'data-diri/strata_pendidikan/update/$1';
	$route['data-diri/strata-pendidikan/delete/(:any)'] = 'data-diri/strata_pendidikan/delete/$1';
	$route['data-diri/strata-pendidikan/delete-exec/(:any)'] = 'data-diri/strata_pendidikan/delete_exec/$1';
	$route['data-diri/strata-pendidikan/view/(:any)'] = 'data-diri/strata_pendidikan/view/$1';
	// bidang pendidikan
	$route['data-diri/bidang-pendidikan'] = 'data-diri/bidang_pendidikan/index';
	$route['data-diri/bidang-pendidikan/getdata'] = 'data-diri/bidang_pendidikan/getdata';
	$route['data-diri/bidang-pendidikan/add'] = 'data-diri/bidang_pendidikan/add';
	$route['data-diri/bidang-pendidikan/store'] = 'data-diri/bidang_pendidikan/store';
	$route['data-diri/bidang-pendidikan/edit/(:any)'] = 'data-diri/bidang_pendidikan/edit/$1';
	$route['data-diri/bidang-pendidikan/update/(:any)'] = 'data-diri/bidang_pendidikan/update/$1';
	$route['data-diri/bidang-pendidikan/delete/(:any)'] = 'data-diri/bidang_pendidikan/delete/$1';
	$route['data-diri/bidang-pendidikan/delete-exec/(:any)'] = 'data-diri/bidang_pendidikan/delete_exec/$1';
	$route['data-diri/bidang-pendidikan/view/(:any)'] = 'data-diri/bidang_pendidikan/view/$1';
	// Agama
	$route['data-diri/agama/delete-exec/(:any)'] = 'data-diri/agama/delete_exec/$1';
	// jenis kelamin
	$route['data-diri/jenis-kelamin'] = 'data-diri/jenis_kelamin/index';
	$route['data-diri/jenis-kelamin/getdata'] = 'data-diri/jenis_kelamin/getdata';
	$route['data-diri/jenis-kelamin/add'] = 'data-diri/jenis_kelamin/add';
	$route['data-diri/jenis-kelamin/store'] = 'data-diri/jenis_kelamin/store';
	$route['data-diri/jenis-kelamin/edit/(:any)'] = 'data-diri/jenis_kelamin/edit/$1';
	$route['data-diri/jenis-kelamin/update/(:any)'] = 'data-diri/jenis_kelamin/update/$1';
	$route['data-diri/jenis-kelamin/delete/(:any)'] = 'data-diri/jenis_kelamin/delete/$1';
	$route['data-diri/jenis-kelamin/delete-exec/(:any)'] = 'data-diri/jenis_kelamin/delete_exec/$1';
	$route['data-diri/jenis-kelamin/view/(:any)'] = 'data-diri/jenis_kelamin/view/$1';
/* end data data diri */

/* start data sesi */
	// Paket sesi harian
	$route['data-sesi/paket-sesi-harian'] = 'data-sesi/paket_sesi_harian/index';
	$route['data-sesi/paket-sesi-harian/getdata'] = 'data-sesi/paket_sesi_harian/getdata';
	$route['data-sesi/paket-sesi-harian/add'] = 'data-sesi/paket_sesi_harian/add';
	$route['data-sesi/paket-sesi-harian/store'] = 'data-sesi/paket_sesi_harian/store';
	$route['data-sesi/paket-sesi-harian/edit/(:any)'] = 'data-sesi/paket_sesi_harian/edit/$1';
	$route['data-sesi/paket-sesi-harian/update/(:any)'] = 'data-sesi/paket_sesi_harian/update/$1';
	$route['data-sesi/paket-sesi-harian/delete/(:any)'] = 'data-sesi/paket_sesi_harian/delete/$1';
	$route['data-sesi/paket-sesi-harian/delete-exec/(:any)'] = 'data-sesi/paket_sesi_harian/delete_exec/$1';
	$route['data-sesi/paket-sesi-harian/view/(:any)'] = 'data-sesi/paket_sesi_harian/view/$1';
	// extra
	$route['data-sesi/paket-sesi-harian/pengaturansesipaket/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaket/$1'; 
	$route['data-sesi/paket-sesi-harian/pengaturansesipaketadd/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketadd/$1';
	$route['data-sesi/paket-sesi-harian/pengaturansesipaketstore/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketstore/$1';
	$route['data-sesi/paket-sesi-harian/pengaturansesipaketedit/(:any)/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketedit/$1/$2';
	$route['data-sesi/paket-sesi-harian/pengaturansesipaketupdate/(:any)/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketupdate/$1/$2';
	$route['data-sesi/paket-sesi-harian/pengaturansesipaketview/(:any)/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketview/$1/$2';
	$route['data-sesi/paket-sesi-harian/pengaturansesipaketdelete/(:any)/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketdelete/$1/$2';
	$route['data-sesi/paket-sesi-harian/pengaturansesipaket/delete-exec/(:any)/(:any)'] = 'data-sesi/paket_sesi_harian/pengaturansesipaketdelete_exec/$1/$2';

	// Sesi satuan
	$route['data-sesi/sesi-satuan'] = 'data-sesi/sesi_satuan/index';
	$route['data-sesi/sesi-satuan/getdata'] = 'data-sesi/sesi_satuan/getdata';
	$route['data-sesi/sesi-satuan/add'] = 'data-sesi/sesi_satuan/add';
	$route['data-sesi/sesi-satuan/store'] = 'data-sesi/sesi_satuan/store';
	$route['data-sesi/sesi-satuan/edit/(:any)'] = 'data-sesi/sesi_satuan/edit/$1';
	$route['data-sesi/sesi-satuan/update/(:any)'] = 'data-sesi/sesi_satuan/update/$1';
	$route['data-sesi/sesi-satuan/delete/(:any)'] = 'data-sesi/sesi_satuan/delete/$1';
	$route['data-sesi/sesi-satuan/delete-exec/(:any)'] = 'data-sesi/sesi_satuan/delete_exec/$1';
	$route['data-sesi/sesi-satuan/view/(:any)'] = 'data-sesi/sesi_satuan/view/$1';

	// Detail paket sesi harian
	$route['data-sesi/detail-paket-sesi-harian'] = 'data-sesi/detail_paket_sesi_harian/index';
	$route['data-sesi/detail-paket-sesi-harian/getdata'] = 'data-sesi/detail_paket_sesi_harian/getdata';
	$route['data-sesi/detail-paket-sesi-harian/add'] = 'data-sesi/detail_paket_sesi_harian/add';
	$route['data-sesi/detail-paket-sesi-harian/store'] = 'data-sesi/detail_paket_sesi_harian/store';
	$route['data-sesi/detail-paket-sesi-harian/edit/(:any)'] = 'data-sesi/detail_paket_sesi_harian/edit/$1';
	$route['data-sesi/detail-paket-sesi-harian/update/(:any)'] = 'data-sesi/detail_paket_sesi_harian/update/$1';
	$route['data-sesi/detail-paket-sesi-harian/delete/(:any)'] = 'data-sesi/detail_paket_sesi_harian/delete/$1';
	$route['data-sesi/detail-paket-sesi-harian/delete-exec/(:any)'] = 'data-sesi/detail_paket_sesi_harian/delete_exec/$1';
	$route['data-sesi/detail-paket-sesi-harian/view/(:any)'] = 'data-sesi/detail_paket_sesi_harian/view/$1';
/* end data sesi */



/* start perusahaan instansi */

	// Holding Group
	$route['perusahaan-instansi/holding-group'] = 'perusahaan-instansi/holding_group/index';
	$route['perusahaan-instansi/holding-group/getdata'] = 'perusahaan-instansi/holding_group/getdata';
	$route['perusahaan-instansi/holding-group/add'] = 'perusahaan-instansi/holding_group/add';
	$route['perusahaan-instansi/holding-group/store'] = 'perusahaan-instansi/holding_group/store';
	$route['perusahaan-instansi/holding-group/edit/(:any)'] = 'perusahaan-instansi/holding_group/edit/$1';
	$route['perusahaan-instansi/holding-group/update/(:any)'] = 'perusahaan-instansi/holding_group/update/$1';
	$route['perusahaan-instansi/holding-group/delete/(:any)'] = 'perusahaan-instansi/holding_group/delete/$1';
	$route['perusahaan-instansi/holding-group/delete-exec/(:any)'] = 'perusahaan-instansi/holding_group/delete_exec/$1';
	$route['perusahaan-instansi/holding-group/view/(:any)'] = 'perusahaan-instansi/holding_group/view/$1';

	// Perusahaan
	$route['perusahaan-instansi/perusahaan/delete-exec/(:any)'] = 'perusahaan-instansi/perusahaan/delete_exec/$1';

/* end perusahaan instansi */

/* start data jenis pelatihan */
	// Data jenis pelatihan
	$route['data-jenis-pelatihan'] = 'data_jenis_pelatihan/index';
	$route['data-jenis-pelatihan/getdata'] = 'data_jenis_pelatihan/getdata';
	$route['data-jenis-pelatihan/add'] = 'data_jenis_pelatihan/add';
	$route['data-jenis-pelatihan/store'] = 'data_jenis_pelatihan/store';
	$route['data-jenis-pelatihan/edit/(:any)'] = 'data_jenis_pelatihan/edit/$1';
	$route['data-jenis-pelatihan/update/(:any)'] = 'data_jenis_pelatihan/update/$1';
	$route['data-jenis-pelatihan/delete/(:any)'] = 'data_jenis_pelatihan/delete/$1';
	$route['data-jenis-pelatihan/delete-exec/(:any)'] = 'data_jenis_pelatihan/delete_exec/$1';
	$route['data-jenis-pelatihan/view/(:any)'] = 'data_jenis_pelatihan/view/$1';
/* end data jenis pelatihan */


/* start data materi */
	// Data materi dan aktifitas
	$route['materi/materi-dan-aktifitas'] = 'materi/materi_dan_aktifitas/index';
	$route['materi/materi-dan-aktifitas/getdata'] = 'materi/materi_dan_aktifitas/getdata';
	$route['materi/materi-dan-aktifitas/add'] = 'materi/materi_dan_aktifitas/add';
	$route['materi/materi-dan-aktifitas/store'] = 'materi/materi_dan_aktifitas/store';
	$route['materi/materi-dan-aktifitas/edit/(:any)'] = 'materi/materi_dan_aktifitas/edit/$1';
	$route['materi/materi-dan-aktifitas/update/(:any)'] = 'materi/materi_dan_aktifitas/update/$1';
	$route['materi/materi-dan-aktifitas/delete/(:any)'] = 'materi/materi_dan_aktifitas/delete/$1';
	$route['materi/materi-dan-aktifitas/delete-exec/(:any)'] = 'materi/materi_dan_aktifitas/delete_exec/$1';
	$route['materi/materi-dan-aktifitas/view/(:any)'] = 'materi/materi_dan_aktifitas/view/$1';

	// Data materi sub bab
	$route['materi/materi-sub-bab'] = 'materi/materi_sub_bab/index';
	$route['materi/materi-sub-bab/getdata'] = 'materi/materi_sub_bab/getdata';
	$route['materi/materi-sub-bab/add'] = 'materi/materi_sub_bab/add';
	$route['materi/materi-sub-bab/store'] = 'materi/materi_sub_bab/store';
	$route['materi/materi-sub-bab/edit/(:any)'] = 'materi/materi_sub_bab/edit/$1';
	$route['materi/materi-sub-bab/update/(:any)'] = 'materi/materi_sub_bab/update/$1';
	$route['materi/materi-sub-bab/delete/(:any)'] = 'materi/materi_sub_bab/delete/$1';
	$route['materi/materi-sub-bab/delete-exec/(:any)'] = 'materi/materi_sub_bab/delete_exec/$1';
	$route['materi/materi-sub-bab/view/(:any)'] = 'materi/materi_sub_bab/view/$1';
/* end data materi */

/* start data IHT */
	// Proforma kontrak
	$route['iht/proforma-kontrak'] = 'iht/proforma_kontrak/index';
	$route['iht/proforma-kontrak/getdata'] = 'iht/proforma_kontrak/getdata';
	$route['iht/proforma-kontrak/add'] = 'iht/proforma_kontrak/add';
	$route['iht/proforma-kontrak/store'] = 'iht/proforma_kontrak/store';
	$route['iht/proforma-kontrak/edit/(:any)'] = 'iht/proforma_kontrak/edit/$1';
	$route['iht/proforma-kontrak/update/(:any)'] = 'iht/proforma_kontrak/update/$1';
	$route['iht/proforma-kontrak/delete/(:any)'] = 'iht/proforma_kontrak/delete/$1';
	$route['iht/proforma-kontrak/delete-exec/(:any)'] = 'iht/proforma_kontrak/delete_exec/$1';
	$route['iht/proforma-kontrak/view/(:any)'] = 'iht/proforma_kontrak/view/$1';
	
	$route['iht/proforma-kontrak/print/(:any)'] = 'iht/proforma_kontrak/print_data/$1';

	// Kontrak spk resmi
	/*$route['iht/kontrak-spk-resmi'] = 'iht/kontrak_spk_resmi/index';
	$route['iht/kontrak-spk-resmi/getdata'] = 'iht/kontrak_spk_resmi/getdata';
	$route['iht/kontrak-spk-resmi/add'] = 'iht/kontrak_spk_resmi/add';
	$route['iht/kontrak-spk-resmi/store'] = 'iht/kontrak_spk_resmi/store';
	$route['iht/kontrak-spk-resmi/edit/(:any)'] = 'iht/kontrak_spk_resmi/edit/$1';
	$route['iht/kontrak-spk-resmi/update/(:any)'] = 'iht/kontrak_spk_resmi/update/$1';
	$route['iht/kontrak-spk-resmi/delete/(:any)'] = 'iht/kontrak_spk_resmi/delete/$1';
	$route['iht/kontrak-spk-resmi/delete-exec/(:any)'] = 'iht/kontrak_spk_resmi/delete_exec/$1';
	$route['iht/kontrak-spk-resmi/view/(:any)'] = 'iht/kontrak_spk_resmi/view/$1';*/
	// kontrak resmi new

	$route['iht/sub-proforma/(:any)'] = 'iht/sub_proforma/indexnew/$1';
	
	$route['iht/sub-account/(:any)'] = 'iht/sub_account/index/$1';
	$route['iht/sub-account/getdata/(:any)'] = 'iht/sub_account/getdata/$1';
	/*$route['iht/kontrak-spk-resmi/(:any)/edit/(:any)'] = 'iht/kontrak_spk_resmi/editnew/$1/$2';
	$route['iht/kontrak-spk-resmi/(:any)/add'] = 'iht/kontrak_spk_resmi/addnew/$1';
	$route['iht/kontrak-spk-resmi/(:any)/store'] = 'iht/kontrak_spk_resmi/storenew/$1';
	$route['iht/kontrak-spk-resmi/(:any)/update/(:any)'] = 'iht/kontrak_spk_resmi/updatenew/$1/$2';
	$route['iht/kontrak-spk-resmi/(:any)/delete/(:any)'] = 'iht/kontrak_spk_resmi/deletenew/$1/$2';
	$route['iht/kontrak-spk-resmi/(:any)/delete-exec/(:any)'] = 'iht/kontrak_spk_resmi/delete_execnew/$1/$2';


	// Addendum
	$route['iht/addendum'] = 'iht/addendum/index';
	$route['iht/addendum/getdata'] = 'iht/addendum/getdata';
	$route['iht/addendum/add'] = 'iht/addendum/add';
	$route['iht/addendum/store'] = 'iht/addendum/store';
	$route['iht/addendum/edit/(:any)'] = 'iht/addendum/edit/$1';
	$route['iht/addendum/update/(:any)'] = 'iht/addendum/update/$1';
	$route['iht/addendum/delete/(:any)'] = 'iht/addendum/delete/$1';
	$route['iht/addendum/delete-exec/(:any)'] = 'iht/addendum/delete_exec/$1';
	$route['iht/addendum/view/(:any)'] = 'iht/addendum/view/$1';

	*/
	// accounting jurnal
	$route['reguler/accounting-jurnal'] = 'iht/accounting_jurnal/index';
	$route['reguler/accounting-jurnal/getdata'] = 'iht/accounting_jurnal/getdata';
	$route['reguler/accounting-jurnal/add'] = 'iht/accounting_jurnal/add';
	$route['reguler/accounting-jurnal/pendapatan'] = 'iht/accounting_jurnal/pendapatan';
	$route['reguler/accounting-jurnal/store'] = 'iht/accounting_jurnal/store';
	$route['reguler/accounting-jurnal/simpanbiaya'] = 'iht/accounting_jurnal/simpanbiaya';
	$route['reguler/accounting-jurnal/edit/(:any)'] = 'iht/accounting_jurnal/edit/$1';
	$route['reguler/accounting-jurnal/update/(:any)'] = 'iht/accounting_jurnal/update/$1';
	$route['reguler/accounting-jurnal/delete/(:any)'] = 'iht/accounting_jurnal/delete/$1';
	$route['reguler/accounting-jurnal/delete-exec/(:any)'] = 'iht/accounting_jurnal/delete_exec/$1';
	$route['reguler/accounting-jurnal/view/(:any)'] = 'iht/accounting_jurnal/view/$1';
	$route['reguler/accounting-jurnal/detail/(:any)'] = 'iht/accounting_jurnal/detail/$1';
	$route['reguler/accounting-jurnal/add/(:any)'] = 'iht/accounting_jurnal/add/$1';
	$route['reguler/accounting-jurnal/pendapatan/(:any)'] = 'iht/accounting_jurnal/pendapatan/$1';
/* end data IHT */

/* start data eskt */
	// Evaluasi Saran Komplain Tindak Lanjut
	$route['pencatatan-eskt/eskt'] = 'pencatatan-eskt/eskt/index';
	$route['pencatatan-eskt/eskt/getdata'] = 'pencatatan-eskt/eskt/getdata';
	$route['pencatatan-eskt/eskt/add'] = 'pencatatan-eskt/eskt/add';
	$route['pencatatan-eskt/eskt/store'] = 'pencatatan-eskt/eskt/store';
	$route['pencatatan-eskt/eskt/edit/(:any)'] = 'pencatatan-eskt/eskt/edit/$1';
	$route['pencatatan-eskt/eskt/update/(:any)'] = 'pencatatan-eskt/eskt/update/$1';
	$route['pencatatan-eskt/eskt/delete/(:any)'] = 'pencatatan-eskt/eskt/delete/$1';
	$route['pencatatan-eskt/eskt/delete-exec/(:any)'] = 'pencatatan-eskt/eskt/delete_exec/$1';
	$route['pencatatan-eskt/eskt/view/(:any)'] = 'pencatatan-eskt/eskt/view/$1';

	// Evaluasi Penyelenggaraan
	$route['pencatatan-eskt/evaluasi-penyelenggaraan'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/index';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/getdata'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/getdata';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/add/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/add/$1';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/hasil/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/hasil/$1';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/store'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/store';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/edit/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/edit/$1';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/update/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/update/$1';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/delete/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/delete/$1';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/delete-exec/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/delete_exec/$1';
	$route['pencatatan-eskt/evaluasi-penyelenggaraan/view/(:any)'] = 'pencatatan-eskt/evaluasi_penyelenggaraan/view/$1';

	// Evaluasi instruktur
	$route['pencatatan-eskt/evaluasi-instruktur'] = 'pencatatan-eskt/evaluasi_instruktur/index';
	$route['pencatatan-eskt/evaluasi-instruktur/getdata'] = 'pencatatan-eskt/evaluasi_instruktur/getdata';
	$route['pencatatan-eskt/evaluasi-instruktur/getmateri/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/getmateri/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/getinstruktur/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/getinstruktur/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/add/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/add/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/add/(:any)/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/add/$1/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/hasil/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/hasil/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/hasil/(:any)/(:any)/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/hasil/$1/$1/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/store'] = 'pencatatan-eskt/evaluasi_instruktur/store';
	$route['pencatatan-eskt/evaluasi-instruktur/edit/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/edit/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/update/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/update/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/delete/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/delete/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/delete-exec/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/delete_exec/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/view/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/view/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/materi/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/materi/$1';
	$route['pencatatan-eskt/evaluasi-instruktur/instruktur/(:any)'] = 'pencatatan-eskt/evaluasi_instruktur/instruktur/$1';
/* end data eskt */

/* start data pengelolaan psl */
	// setting template
	$route['pengelolaan-psl/setting-template'] = 'pengelolaan-psl/setting_template/index';
	$route['pengelolaan-psl/setting-template/getdata'] = 'pengelolaan-psl/setting_template/getdata';
	$route['pengelolaan-psl/setting-template/add'] = 'pengelolaan-psl/setting_template/add';
	$route['pengelolaan-psl/setting-template/store'] = 'pengelolaan-psl/setting_template/store';
	$route['pengelolaan-psl/setting-template/edit/(:any)'] = 'pengelolaan-psl/setting_template/edit/$1';
	$route['pengelolaan-psl/setting-template/update/(:any)'] = 'pengelolaan-psl/setting_template/update/$1';
	$route['pengelolaan-psl/setting-template/delete/(:any)'] = 'pengelolaan-psl/setting_template/delete/$1';
	$route['pengelolaan-psl/setting-template/delete-exec/(:any)'] = 'pengelolaan-psl/setting_template/delete_exec/$1';
	$route['pengelolaan-psl/setting-template/view/(:any)'] = 'pengelolaan-psl/setting_template/view/$1';
	$route['pengelolaan-psl/setting-template/add/(:any)'] = 'pengelolaan-psl/setting_template/add/$1';

	// output
	$route['pengelolaan-psl/output'] = 'pengelolaan-psl/output/index';
	$route['pengelolaan-psl/output/getdata'] = 'pengelolaan-psl/output/getdata';
	$route['pengelolaan-psl/output/add'] = 'pengelolaan-psl/output/add';
	$route['pengelolaan-psl/output/store'] = 'pengelolaan-psl/output/store';
	$route['pengelolaan-psl/output/edit/(:any)'] = 'pengelolaan-psl/output/edit/$1';
	$route['pengelolaan-psl/output/update/(:any)'] = 'pengelolaan-psl/output/update/$1';
	$route['pengelolaan-psl/output/delete/(:any)'] = 'pengelolaan-psl/output/delete/$1';
	$route['pengelolaan-psl/output/delete-exec/(:any)'] = 'pengelolaan-psl/output/delete_exec/$1';
	$route['pengelolaan-psl/output/view/(:any)'] = 'pengelolaan-psl/output/view/$1';
/* end data pengelolaan psl */

/* start data pbt */
	// pengumuman hasil
	$route['pbt/pengumuman-hasil'] = 'pbt/pengumuman_hasil/index';
	$route['pbt/pengumuman-hasil/getdata'] = 'pbt/pengumuman_hasil/getdata';
	$route['pbt/pengumuman-hasil/add'] = 'pbt/pengumuman_hasil/add';
	$route['pbt/pengumuman-hasil/store'] = 'pbt/pengumuman_hasil/store';
	$route['pbt/pengumuman-hasil/edit/(:any)'] = 'pbt/pengumuman_hasil/edit/$1';
	$route['pbt/pengumuman-hasil/update/(:any)'] = 'pbt/pengumuman_hasil/update/$1';
	$route['pbt/pengumuman-hasil/delete/(:any)'] = 'pbt/pengumuman_hasil/delete/$1';
	$route['pbt/pengumuman-hasil/delete-exec/(:any)'] = 'pbt/pengumuman_hasil/delete_exec/$1';
	$route['pbt/pengumuman-hasil/view/(:any)'] = 'pbt/pengumuman_hasil/view/$1';
	$route['pbt/pengumuman-hasil/hasil/(:any)'] = 'pbt/pengumuman_hasil/hasil/$1';
	$route['pbt/pengumuman-hasil/hasil-hh/(:any)/(:any)'] = 'pbt/pengumuman_hasil/hasilhh/$1/$2';
	$route['pbt/pengumuman-hasil/print/(:any)/(:any)'] = 'pbt/pengumuman_hasil/printddasd/$1/$2';

	// scanning lembar jawaban
	$route['pbt/scanning-lembar-jawaban'] = 'pbt/scanning_lembar_jawaban/index';
	$route['pbt/scanning-lembar-jawaban/getdata'] = 'pbt/scanning_lembar_jawaban/getdata';
	$route['pbt/scanning-lembar-jawaban/add'] = 'pbt/scanning_lembar_jawaban/add';
	$route['pbt/scanning-lembar-jawaban/add/(:any)/(:any)'] = 'pbt/scanning_lembar_jawaban/add/$1/$1';
	$route['pbt/scanning-lembar-jawaban/her/(:any)/(:any)'] = 'pbt/scanning_lembar_jawaban/her/$1/$1';
	$route['pbt/scanning-lembar-jawaban/store'] = 'pbt/scanning_lembar_jawaban/store';
	$route['pbt/scanning-lembar-jawaban/edit/(:any)'] = 'pbt/scanning_lembar_jawaban/edit/$1';
	$route['pbt/scanning-lembar-jawaban/update/(:any)'] = 'pbt/scanning_lembar_jawaban/update/$1';
	$route['pbt/scanning-lembar-jawaban/delete/(:any)'] = 'pbt/scanning_lembar_jawaban/delete/$1';
	$route['pbt/scanning-lembar-jawaban/delete-exec/(:any)'] = 'pbt/scanning_lembar_jawaban/delete_exec/$1';
	$route['pbt/scanning-lembar-jawaban/delete/(:any)/(:any)/(:any)/(:any)'] = 'pbt/scanning_lembar_jawaban/delete/$1/$1/$1/$1';
	$route['pbt/scanning-lembar-jawaban/view/(:any)'] = 'pbt/scanning_lembar_jawaban/view/$1';
	$route['pbt/scanning-lembar-jawaban/peserta/(:any)'] = 'pbt/scanning_lembar_jawaban/peserta/$1';
	$route['pbt/scanning-lembar-jawaban/nilaiher1'] = 'pbt/scanning_lembar_jawaban/nilaiher1';
	$route['pbt/scanning-lembar-jawaban/nilaiher2'] = 'pbt/scanning_lembar_jawaban/nilaiher2';
	$route['pbt/scanning-lembar-jawaban/nilaieksher1'] = 'pbt/scanning_lembar_jawaban/nilaieksher1';
	$route['pbt/scanning-lembar-jawaban/nilaieksher2'] = 'pbt/scanning_lembar_jawaban/nilaieksher2';
	$route['pbt/scanning-lembar-jawaban/hapusher1/(:any)/(:any)/(:any)'] = 'pbt/scanning_lembar_jawaban/hapusher1/$1/$1/$1';
	$route['pbt/scanning-lembar-jawaban/hapusher2/(:any)/(:any)/(:any)'] = 'pbt/scanning_lembar_jawaban/hapusher2/$1/$1/$1';

/* end data pbt */

/* start data cbt */
	// set rencana ujian
	$route['cbt/set-rencana-ujian'] = 'cbt/set_rencana_ujian/index';
	$route['cbt/set-rencana-ujian/getdata'] = 'cbt/set_rencana_ujian/getdata';
	$route['cbt/set-rencana-ujian/add'] = 'cbt/set_rencana_ujian/add';
	$route['cbt/set-rencana-ujian/store'] = 'cbt/set_rencana_ujian/store';
	$route['cbt/set-rencana-ujian/edit/(:any)'] = 'cbt/set_rencana_ujian/edit/$1';
	$route['cbt/set-rencana-ujian/update/(:any)'] = 'cbt/set_rencana_ujian/update/$1';
	$route['cbt/set-rencana-ujian/delete/(:any)'] = 'cbt/set_rencana_ujian/delete/$1';
	$route['cbt/set-rencana-ujian/delete-exec/(:any)'] = 'cbt/set_rencana_ujian/delete_exec/$1';
	$route['cbt/set-rencana-ujian/view/(:any)'] = 'cbt/set_rencana_ujian/view/$1';

	// pelaksanaan ujian
	$route['cbt/pelaksanaan-ujian'] = 'cbt/pelaksanaan_ujian/index';
	$route['cbt/pelaksanaan-ujian/getdata'] = 'cbt/pelaksanaan_ujian/getdata';
	$route['cbt/pelaksanaan-ujian/add'] = 'cbt/pelaksanaan_ujian/add';
	$route['cbt/pelaksanaan-ujian/store'] = 'cbt/pelaksanaan_ujian/store';
	$route['cbt/pelaksanaan-ujian/edit/(:any)'] = 'cbt/pelaksanaan_ujian/edit/$1';
	$route['cbt/pelaksanaan-ujian/update/(:any)'] = 'cbt/pelaksanaan_ujian/update/$1';
	$route['cbt/pelaksanaan-ujian/delete/(:any)'] = 'cbt/pelaksanaan_ujian/delete/$1';
	$route['cbt/pelaksanaan-ujian/delete-exec/(:any)'] = 'cbt/pelaksanaan_ujian/delete_exec/$1';
	$route['cbt/pelaksanaan-ujian/view/(:any)'] = 'cbt/pelaksanaan_ujian/view/$1';

	// pengumuman hasil
	$route['cbt/pengumuman-hasil'] = 'cbt/pengumuman_hasil/index';
	$route['cbt/pengumuman-hasil/getdata'] = 'cbt/pengumuman_hasil/getdata';
	$route['cbt/pengumuman-hasil/add'] = 'cbt/pengumuman_hasil/add';
	$route['cbt/pengumuman-hasil/store'] = 'cbt/pengumuman_hasil/store';
	$route['cbt/pengumuman-hasil/edit/(:any)'] = 'cbt/pengumuman_hasil/edit/$1';
	$route['cbt/pengumuman-hasil/update/(:any)'] = 'cbt/pengumuman_hasil/update/$1';
	$route['cbt/pengumuman-hasil/delete/(:any)'] = 'cbt/pengumuman_hasil/delete/$1';
	$route['cbt/pengumuman-hasil/delete-exec/(:any)'] = 'cbt/pengumuman_hasil/delete_exec/$1';
	$route['cbt/pengumuman-hasil/view/(:any)'] = 'cbt/pengumuman_hasil/view/$1';

	// bank soal
	$route['cbt/bank-soal'] = 'cbt/bank_soal/index';
	$route['cbt/bank-soal/getdata'] = 'cbt/bank_soal/getdata';
	$route['cbt/bank-soal/add'] = 'cbt/bank_soal/add';
	$route['cbt/bank-soal/store'] = 'cbt/bank_soal/store';
	$route['cbt/bank-soal/edit/(:any)'] = 'cbt/bank_soal/edit/$1';
	$route['cbt/bank-soal/update/(:any)'] = 'cbt/bank_soal/update/$1';
	$route['cbt/bank-soal/delete/(:any)'] = 'cbt/bank_soal/delete/$1';
	$route['cbt/bank-soal/delete-exec/(:any)'] = 'cbt/bank_soal/delete_exec/$1';
	$route['cbt/bank-soal/view/(:any)'] = 'cbt/bank_soal/view/$1';

/* end data cbt */

/* start data non-iht */
	// pembukaan kelas
	$route['non-iht/pembukaan-kelas-non-iht'] = 'non-iht/pembukaan_kelas_non_iht/index';
	$route['non-iht/pembukaan-kelas-non-iht/getdata'] = 'non-iht/pembukaan_kelas_non_iht/getdata';
	$route['non-iht/pembukaan-kelas-non-iht/add'] = 'non-iht/pembukaan_kelas_non_iht/add';
	$route['non-iht/pembukaan-kelas-non-iht/store'] = 'non-iht/pembukaan_kelas_non_iht/store';
	$route['non-iht/pembukaan-kelas-non-iht/edit/(:any)'] = 'non-iht/pembukaan_kelas_non_iht/edit/$1';
	$route['non-iht/pembukaan-kelas-non-iht/update/(:any)'] = 'non-iht/pembukaan_kelas_non_iht/update/$1';
	$route['non-iht/pembukaan-kelas-non-iht/delete/(:any)'] = 'non-iht/pembukaan_kelas_non_iht/delete/$1';
	$route['non-iht/pembukaan-kelas-non-iht/delete-exec/(:any)'] = 'non-iht/pembukaan_kelas_non_iht/delete_exec/$1';
	$route['non-iht/pembukaan-kelas-non-iht/view/(:any)'] = 'non-iht/pembukaan_kelas_non_iht/view/$1';

/* end data non-iht */

/* start data kelas pelatihan */
	// setting materi kelas
	$route['kelas-pelatihan/setting-materi-kelas'] = 'kelas-pelatihan/setting_materi_kelas/index';
	$route['kelas-pelatihan/setting-materi-kelas/getdata'] = 'kelas-pelatihan/setting_materi_kelas/getdata';
	$route['kelas-pelatihan/setting-materi-kelas/add/(:any)'] = 'kelas-pelatihan/setting_materi_kelas/add/$1';
	$route['kelas-pelatihan/setting-materi-kelas/store'] = 'kelas-pelatihan/setting_materi_kelas/store';
	$route['kelas-pelatihan/setting-materi-kelas/edit/(:any)'] = 'kelas-pelatihan/setting_materi_kelas/edit/$1';
	$route['kelas-pelatihan/setting-materi-kelas/update/(:any)'] = 'kelas-pelatihan/setting_materi_kelas/update/$1';
	$route['kelas-pelatihan/setting-materi-kelas/delete/(:any)'] = 'kelas-pelatihan/setting_materi_kelas/delete/$1';
	$route['kelas-pelatihan/setting-materi-kelas/delete-exec/(:any)'] = 'kelas-pelatihan/setting_materi_kelas/delete_exec/$1';
	$route['kelas-pelatihan/setting-materi-kelas/view/(:any)'] = 'kelas-pelatihan/setting_materi_kelas/view/$1';
	
	$route['kelas-pelatihan/laporan-t/(:any)'] = 'kelas-pelatihan/laporan_t/index/$1';

	// penutupan kelas
	$route['kelas-pelatihan/penutupan-kelas'] = 'kelas-pelatihan/penutupan_kelas/index';
	$route['kelas-pelatihan/penutupan-kelas/getdata'] = 'kelas-pelatihan/penutupan_kelas/getdata';
	$route['kelas-pelatihan/penutupan-kelas/add'] = 'kelas-pelatihan/penutupan_kelas/add';
	$route['kelas-pelatihan/penutupan-kelas/store'] = 'kelas-pelatihan/penutupan_kelas/store';
	$route['kelas-pelatihan/penutupan-kelas/edit/(:any)'] = 'kelas-pelatihan/penutupan_kelas/edit/$1';
	$route['kelas-pelatihan/penutupan-kelas/update/(:any)'] = 'kelas-pelatihan/penutupan_kelas/update/$1';
	$route['kelas-pelatihan/penutupan-kelas/delete/(:any)'] = 'kelas-pelatihan/penutupan_kelas/delete/$1';
	$route['kelas-pelatihan/penutupan-kelas/delete-exec/(:any)'] = 'kelas-pelatihan/penutupan_kelas/delete_exec/$1';
	$route['kelas-pelatihan/penutupan-kelas/view/(:any)'] = 'kelas-pelatihan/penutupan_kelas/view/$1';

	// pembebanan biaya kelas
	$route['kelas-pelatihan/pembebanan-biaya-kelas'] = 'kelas-pelatihan/pembebanan_biaya_kelas/index';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/getdata'] = 'kelas-pelatihan/pembebanan_biaya_kelas/getdata';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/add'] = 'kelas-pelatihan/pembebanan_biaya_kelas/add';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/pendapatan'] = 'kelas-pelatihan/pembebanan_biaya_kelas/pendapatan';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/store'] = 'kelas-pelatihan/pembebanan_biaya_kelas/store';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/simpanbiaya'] = 'kelas-pelatihan/pembebanan_biaya_kelas/simpanbiaya';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/edit/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/edit/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/update/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/update/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/delete/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/delete/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/delete-exec/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/delete_exec/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/view/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/view/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/detail/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/detail/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/add/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/add/$1';
	$route['kelas-pelatihan/pembebanan-biaya-kelas/pendapatan/(:any)'] = 'kelas-pelatihan/pembebanan_biaya_kelas/pendapatan/$1';

	// laporan project kelas
	$route['kelas-pelatihan/laporan-project-kelas'] = 'kelas-pelatihan/laporan_project_kelas/index';
	$route['kelas-pelatihan/laporan-project-kelas/getdata'] = 'kelas-pelatihan/laporan_project_kelas/getdata';
	$route['kelas-pelatihan/laporan-project-kelas/add'] = 'kelas-pelatihan/laporan_project_kelas/add';
	$route['kelas-pelatihan/laporan-project-kelas/store'] = 'kelas-pelatihan/laporan_project_kelas/store';
	$route['kelas-pelatihan/laporan-project-kelas/edit/(:any)'] = 'kelas-pelatihan/laporan_project_kelas/edit/$1';
	$route['kelas-pelatihan/laporan-project-kelas/update/(:any)'] = 'kelas-pelatihan/laporan_project_kelas/update/$1';
	$route['kelas-pelatihan/laporan-project-kelas/delete/(:any)'] = 'kelas-pelatihan/laporan_project_kelas/delete/$1';
	$route['kelas-pelatihan/laporan-project-kelas/delete-exec/(:any)'] = 'kelas-pelatihan/laporan_project_kelas/delete_exec/$1';
	$route['kelas-pelatihan/laporan-project-kelas/view/(:any)'] = 'kelas-pelatihan/laporan_project_kelas/view/$1';

	// pembukaan kelas
	$route['kelas-pelatihan/pembukaan-kelas'] = 'kelas-pelatihan/pembukaan_kelas/index';
	$route['kelas-pelatihan/pembukaan-kelas/getdata'] = 'kelas-pelatihan/pembukaan_kelas/getdata';
	$route['kelas-pelatihan/pembukaan-kelas/add'] = 'kelas-pelatihan/pembukaan_kelas/add';
	$route['kelas-pelatihan/pembukaan-kelas/store'] = 'kelas-pelatihan/pembukaan_kelas/store';
	$route['kelas-pelatihan/pembukaan-kelas/edit/(:any)'] = 'kelas-pelatihan/pembukaan_kelas/edit/$1';
	$route['kelas-pelatihan/pembukaan-kelas/update/(:any)'] = 'kelas-pelatihan/pembukaan_kelas/update/$1';
	$route['kelas-pelatihan/pembukaan-kelas/delete/(:any)'] = 'kelas-pelatihan/pembukaan_kelas/delete/$1';
	$route['kelas-pelatihan/pembukaan-kelas/delete-exec/(:any)'] = 'kelas-pelatihan/pembukaan_kelas/delete_exec/$1';
	$route['kelas-pelatihan/pembukaan-kelas/view/(:any)'] = 'kelas-pelatihan/pembukaan_kelas/view/$1';
	$route['kelas-pelatihan/pembukaan-kelas/getfromselect/(:any)'] = 'kelas-pelatihan/pembukaan_kelas/getfromselect/$1';

	// jadwal kelas
	$route['kelas-pelatihan/jadwal-kelas'] = 'kelas-pelatihan/jadwal_kelas/index';
	$route['kelas-pelatihan/jadwal-kelas/getdata'] = 'kelas-pelatihan/jadwal_kelas/getdata';
	$route['kelas-pelatihan/jadwal-kelas/add'] = 'kelas-pelatihan/jadwal_kelas/add';
	$route['kelas-pelatihan/jadwal-kelas/setting/(:any)'] = 'kelas-pelatihan/jadwal_kelas/setting/$1';
	$route['kelas-pelatihan/jadwal-kelas/hapus/(:any)'] = 'kelas-pelatihan/jadwal_kelas/hapus/$1';
	$route['kelas-pelatihan/jadwal-kelas/store/(:any)'] = 'kelas-pelatihan/jadwal_kelas/store/$1';
	$route['kelas-pelatihan/jadwal-kelas/edit/(:any)'] = 'kelas-pelatihan/jadwal_kelas/edit/$1';
	$route['kelas-pelatihan/jadwal-kelas/update/(:any)'] = 'kelas-pelatihan/jadwal_kelas/update/$1';
	$route['kelas-pelatihan/jadwal-kelas/delete/(:any)'] = 'kelas-pelatihan/jadwal_kelas/delete/$1';
	$route['kelas-pelatihan/jadwal-kelas/delete-exec/(:any)'] = 'kelas-pelatihan/jadwal_kelas/delete_exec/$1';
	$route['kelas-pelatihan/jadwal-kelas/view/(:any)'] = 'kelas-pelatihan/jadwal_kelas/view/$1';
	// cekmateri
	$route['kelas-pelatihan/jadwal-kelas/loadsesi'] = 'kelas-pelatihan/jadwal_kelas/loadsesi';

/* end data kelas pelatihan */

/* start data Konektifitas-ds-qia */
	// pemenuhan persyaratan
	$route['konektifitas-ds-qia/pemenuhan-persyaratan'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/index';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/getdata'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/getdata';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/add'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/add';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/store'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/store';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/edit/(:any)'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/edit/$1';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/update/(:any)'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/update/$1';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/delete/(:any)'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/delete/$1';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/delete-exec/(:any)'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/delete_exec/$1';
	$route['konektifitas-ds-qia/pemenuhan-persyaratan/view/(:any)'] = 'konektifitas-ds-qia/pemenuhan_persyaratan/view/$1';

	// penarikan surat
	$route['konektifitas-ds-qia/penarikan-surat'] = 'konektifitas-ds-qia/penarikan_surat/index';
	$route['konektifitas-ds-qia/penarikan-surat/getdata'] = 'konektifitas-ds-qia/penarikan_surat/getdata';
	$route['konektifitas-ds-qia/penarikan-surat/add'] = 'konektifitas-ds-qia/penarikan_surat/add';
	$route['konektifitas-ds-qia/penarikan-surat/store'] = 'konektifitas-ds-qia/penarikan_surat/store';
	$route['konektifitas-ds-qia/penarikan-surat/edit/(:any)'] = 'konektifitas-ds-qia/penarikan_surat/edit/$1';
	$route['konektifitas-ds-qia/penarikan-surat/update/(:any)'] = 'konektifitas-ds-qia/penarikan_surat/update/$1';
	$route['konektifitas-ds-qia/penarikan-surat/delete/(:any)'] = 'konektifitas-ds-qia/penarikan_surat/delete/$1';
	$route['konektifitas-ds-qia/penarikan-surat/delete-exec/(:any)'] = 'konektifitas-ds-qia/penarikan_surat/delete_exec/$1';
	$route['konektifitas-ds-qia/penarikan-surat/view/(:any)'] = 'konektifitas-ds-qia/penarikan_surat/view/$1';

	// pengantaran permohonan
	$route['konektifitas-ds-qia/pengantaran-permohonan'] = 'konektifitas-ds-qia/pengantaran_permohonan/index';
	$route['konektifitas-ds-qia/pengantaran-permohonan/getdata'] = 'konektifitas-ds-qia/pengantaran_permohonan/getdata';
	$route['konektifitas-ds-qia/pengantaran-permohonan/add'] = 'konektifitas-ds-qia/pengantaran_permohonan/add';
	$route['konektifitas-ds-qia/pengantaran-permohonan/store'] = 'konektifitas-ds-qia/pengantaran_permohonan/store';
	$route['konektifitas-ds-qia/pengantaran-permohonan/edit/(:any)'] = 'konektifitas-ds-qia/pengantaran_permohonan/edit/$1';
	$route['konektifitas-ds-qia/pengantaran-permohonan/update/(:any)'] = 'konektifitas-ds-qia/pengantaran_permohonan/update/$1';
	$route['konektifitas-ds-qia/pengantaran-permohonan/delete/(:any)'] = 'konektifitas-ds-qia/pengantaran_permohonan/delete/$1';
	$route['konektifitas-ds-qia/pengantaran-permohonan/delete-exec/(:any)'] = 'konektifitas-ds-qia/pengantaran_permohonan/delete_exec/$1';
	$route['konektifitas-ds-qia/pengantaran-permohonan/view/(:any)'] = 'konektifitas-ds-qia/pengantaran_permohonan/view/$1';
	$route['konektifitas-ds-qia/pengantaran-permohonan/kirim/(:any)'] = 'konektifitas-ds-qia/pengantaran_permohonan/kirim/$1';

/* end data Konektifitas-ds-qia */

/* start data pendaftaran-kelas */
	// pembukaan kuncian
	$route['pendaftaran-kelas/pembukaan-kuncian'] = 'pendaftaran-kelas/pembukaan_kuncian/index';
	$route['pendaftaran-kelas/pembukaan-kuncian/getdata'] = 'pendaftaran-kelas/pembukaan_kuncian/getdata';
	$route['pendaftaran-kelas/pembukaan-kuncian/add'] = 'pendaftaran-kelas/pembukaan_kuncian/add';
	$route['pendaftaran-kelas/pembukaan-kuncian/store'] = 'pendaftaran-kelas/pembukaan_kuncian/store';
	$route['pendaftaran-kelas/pembukaan-kuncian/edit/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/edit/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/update/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/update/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/delete/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/delete/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/delete-exec/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/delete_exec/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/view/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/view/$1';
	// ++ extra
	$route['pendaftaran-kelas/pembukaan-kuncian/verifikasi/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/verifikasi/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/verifikasi-proses/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/verifikasi_proses/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/buka-kuncian/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/buka_kuncian/$1';
	$route['pendaftaran-kelas/pembukaan-kuncian/save-buka-kuncian/(:any)'] = 'pendaftaran-kelas/pembukaan_kuncian/save_buka_kuncian/$1';

	// kelas QIA
	$route['pendaftaran-kelas/kelas-qia'] = 'pendaftaran-kelas/kelas_qia/index';
	$route['pendaftaran-kelas/kelas-qia/getdata'] = 'pendaftaran-kelas/kelas_qia/getdata';
	$route['pendaftaran-kelas/kelas-qia/getdataqia/(:any)'] = 'pendaftaran-kelas/kelas_qia/getdataqia/$1';
	$route['pendaftaran-kelas/kelas-qia/add'] = 'pendaftaran-kelas/kelas_qia/add';
	$route['pendaftaran-kelas/kelas-qia/detail/(:any)'] = 'pendaftaran-kelas/kelas_qia/detail/$1';
	$route['pendaftaran-kelas/kelas-qia/store'] = 'pendaftaran-kelas/kelas_qia/store';
	$route['pendaftaran-kelas/kelas-qia/edit/(:any)'] = 'pendaftaran-kelas/kelas_qia/edit/$1';
	$route['pendaftaran-kelas/kelas-qia/update/(:any)'] = 'pendaftaran-kelas/kelas_qia/update/$1';
	$route['pendaftaran-kelas/kelas-qia/delete/(:any)'] = 'pendaftaran-kelas/kelas_qia/delete/$1';
	$route['pendaftaran-kelas/kelas-qia/delete_peserta/(:any)/(:any)'] = 'pendaftaran-kelas/kelas_qia/delete_peserta/$1/$1';
	$route['pendaftaran-kelas/kelas-qia/delete-act/(:any)/(:any)'] = 'pendaftaran-kelas/kelas_qia/delete_act/$1/$1';
	$route['pendaftaran-kelas/kelas-qia/view/(:any)'] = 'pendaftaran-kelas/kelas_qia/view/$1';
	$route['pendaftaran-kelas/kelas-qia/peserta/(:any)'] = 'pendaftaran-kelas/kelas_qia/peserta/$1';
	$route['pendaftaran-kelas/kelas-qia/print/(:any)'] = 'pendaftaran-kelas/kelas_qia/print/$1';
	$route['pendaftaran-kelas/kelas-qia/getpeserta'] = 'pendaftaran-kelas/kelas_qia/getpeserta';

	// kelas Non QIA
	$route['pendaftaran-kelas/kelas-non-qia'] = 'pendaftaran-kelas/kelas_non_qia/index';
	$route['pendaftaran-kelas/kelas-non-qia/getdata'] = 'pendaftaran-kelas/kelas_non_qia/getdata';
	$route['pendaftaran-kelas/kelas-non-qia/getdatanonqia/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/getdatanonqia/$1';
	$route['pendaftaran-kelas/kelas-non-qia/add'] = 'pendaftaran-kelas/kelas_non_qia/add';
	$route['pendaftaran-kelas/kelas-non-qia/detail/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/detail/$1';
	$route['pendaftaran-kelas/kelas-non-qia/store'] = 'pendaftaran-kelas/kelas_non_qia/store';
	$route['pendaftaran-kelas/kelas-non-qia/edit/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/edit/$1';
	$route['pendaftaran-kelas/kelas-non-qia/update/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/update/$1';
	$route['pendaftaran-kelas/kelas-non-qia/delete/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/delete/$1';
	$route['pendaftaran-kelas/kelas-non-qia/delete_peserta/(:any)/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/delete_peserta/$1/$1';
	$route['pendaftaran-kelas/kelas-non-qia/delete-act/(:any)/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/delete_act/$1/$1';
	$route['pendaftaran-kelas/kelas-non-qia/view/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/view/$1';
	$route['pendaftaran-kelas/kelas-non-qia/peserta/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/peserta/$1';
	$route['pendaftaran-kelas/kelas-non-qia/print/(:any)'] = 'pendaftaran-kelas/kelas_non_qia/print/$1';
	$route['pendaftaran-kelas/kelas-non-qia/getpeserta'] = 'pendaftaran-kelas/kelas_non_qia/getpeserta';

/* end data pendaftaran-kelas */

/* start data instruktur */
	// pendaftaran
	$route['instruktur/pendaftaran'] = 'instruktur/pendaftaran/index';
	$route['instruktur/pendaftaran/getdata'] = 'instruktur/pendaftaran/getdata';
	$route['instruktur/pendaftaran/add'] = 'instruktur/pendaftaran/add';
	$route['instruktur/pendaftaran/store'] = 'instruktur/pendaftaran/store';
	$route['instruktur/pendaftaran/edit/(:any)'] = 'instruktur/pendaftaran/edit/$1';
	$route['instruktur/pendaftaran/update/(:any)'] = 'instruktur/pendaftaran/update/$1';
	$route['instruktur/pendaftaran/delete/(:any)'] = 'instruktur/pendaftaran/delete/$1';
	$route['instruktur/pendaftaran/delete-exec/(:any)'] = 'instruktur/pendaftaran/delete_exec/$1';
	$route['instruktur/pendaftaran/view/(:any)'] = 'instruktur/pendaftaran/view/$1';

	// penugasan
	$route['instruktur/penugasan'] = 'instruktur/penugasan/index';
	$route['instruktur/penugasan/getdata'] = 'instruktur/penugasan/getdata';
	$route['instruktur/penugasan/add'] = 'instruktur/penugasan/add';
	$route['instruktur/penugasan/store'] = 'instruktur/penugasan/store';
	$route['instruktur/penugasan/edit/(:any)'] = 'instruktur/penugasan/edit/$1';
	$route['instruktur/penugasan/update/(:any)'] = 'instruktur/penugasan/update/$1';
	$route['instruktur/penugasan/delete/(:any)'] = 'instruktur/penugasan/delete/$1';
	$route['instruktur/penugasan/delete-exec/(:any)'] = 'instruktur/penugasan/delete_exec/$1';
	$route['instruktur/penugasan/view/(:any)'] = 'instruktur/penugasan/view/$1';

	// pembayaran
	$route['instruktur/pembayaran'] = 'instruktur/pembayaran/index';
	$route['instruktur/pembayaran/getdata'] = 'instruktur/pembayaran/getdata';
	$route['instruktur/pembayaran/add'] = 'instruktur/pembayaran/add';
	$route['instruktur/pembayaran/store'] = 'instruktur/pembayaran/store';
	$route['instruktur/pembayaran/biaya/(:any)'] = 'instruktur/pembayaran/biaya/$1';
	$route['instruktur/pembayaran/edit/(:any)'] = 'instruktur/pembayaran/edit/$1';
	$route['instruktur/pembayaran/update/(:any)'] = 'instruktur/pembayaran/update/$1';
	$route['instruktur/pembayaran/simpanbiaya/(:any)'] = 'instruktur/pembayaran/simpanbiaya/$1';
	$route['instruktur/pembayaran/delete/(:any)'] = 'instruktur/pembayaran/delete/$1';
	$route['instruktur/pembayaran/delete-exec/(:any)'] = 'instruktur/pembayaran/delete_exec/$1';
	$route['instruktur/pembayaran/view/(:any)'] = 'instruktur/pembayaran/view/$1';

	// pencatatan aktifitas
	$route['instruktur/pencatatan-aktifitas'] = 'instruktur/pencatatan_aktifitas/index';
	$route['instruktur/pencatatan-aktifitas/getdata'] = 'instruktur/pencatatan_aktifitas/getdata';
	$route['instruktur/pencatatan-aktifitas/add'] = 'instruktur/pencatatan_aktifitas/add';
	$route['instruktur/pencatatan-aktifitas/store'] = 'instruktur/pencatatan_aktifitas/store';
	$route['instruktur/pencatatan-aktifitas/edit/(:any)'] = 'instruktur/pencatatan_aktifitas/edit/$1';
	$route['instruktur/pencatatan-aktifitas/update/(:any)'] = 'instruktur/pencatatan_aktifitas/update/$1';
	$route['instruktur/pencatatan-aktifitas/delete/(:any)'] = 'instruktur/pencatatan_aktifitas/delete/$1';
	$route['instruktur/pencatatan-aktifitas/delete-exec/(:any)'] = 'instruktur/pencatatan_aktifitas/delete_exec/$1';
	$route['instruktur/pencatatan-aktifitas/view/(:any)'] = 'instruktur/pencatatan_aktifitas/view/$1';

/* end data pendaftaran-kelas */

/* start data peserta */
	// calon peserta
	$route['peserta/calon-peserta'] = 'peserta/calon_peserta/index';
	$route['peserta/calon-peserta/getdata'] = 'peserta/calon_peserta/getdata';
	$route['peserta/calon-peserta/add'] = 'peserta/calon_peserta/add';
	$route['peserta/calon-peserta/store'] = 'peserta/calon_peserta/store';
	$route['peserta/calon-peserta/edit/(:any)'] = 'peserta/calon_peserta/edit/$1';
	$route['peserta/calon-peserta/update/(:any)'] = 'peserta/calon_peserta/update/$1';
	$route['peserta/calon-peserta/posting/(:any)'] = 'peserta/calon_peserta/posting/$1';
	$route['peserta/calon-peserta/delete/(:any)'] = 'peserta/calon_peserta/delete/$1';
	$route['peserta/calon-peserta/delete-exec/(:any)'] = 'peserta/calon_peserta/delete_exec/$1';
	$route['peserta/calon-peserta/view/(:any)'] = 'peserta/calon_peserta/view/$1';

	// pembukaan kunci entry
	$route['peserta/pembukaan-kunci-entry'] = 'peserta/pembukaan_kunci_entry/index';
	$route['peserta/pembukaan-kunci-entry/getdata'] = 'peserta/pembukaan_kunci_entry/getdata';
	$route['peserta/pembukaan-kunci-entry/add'] = 'peserta/pembukaan_kunci_entry/add';
	$route['peserta/pembukaan-kunci-entry/store'] = 'peserta/pembukaan_kunci_entry/store';
	$route['peserta/pembukaan-kunci-entry/edit/(:any)'] = 'peserta/pembukaan_kunci_entry/edit/$1';
	$route['peserta/pembukaan-kunci-entry/update/(:any)'] = 'peserta/pembukaan_kunci_entry/update/$1';
	$route['peserta/pembukaan-kunci-entry/delete/(:any)'] = 'peserta/pembukaan_kunci_entry/delete/$1';
	$route['peserta/pembukaan-kunci-entry/delete-exec/(:any)'] = 'peserta/pembukaan_kunci_entry/delete_exec/$1';
	$route['peserta/pembukaan-kunci-entry/view/(:any)'] = 'peserta/pembukaan_kunci_entry/view/$1';
	// ++ extra
	$route['peserta/pembukaan-kunci-entry/verifikasi/(:any)'] = 'peserta/pembukaan_kunci_entry/verifikasi/$1';
	$route['peserta/pembukaan-kunci-entry/verifikasi-proses/(:any)'] = 'peserta/pembukaan_kunci_entry/verifikasi_proses/$1';
	$route['peserta/pembukaan-kunci-entry/buka-kuncian/(:any)'] = 'peserta/pembukaan_kunci_entry/buka_kuncian/$1';
	$route['peserta/pembukaan-kunci-entry/save-buka-kuncian/(:any)'] = 'peserta/pembukaan_kunci_entry/save_buka_kuncian/$1';


	// posting data peserta
	$route['peserta/data-peserta'] = 'peserta/posting_data_peserta/index';
	$route['peserta/data-peserta/getdata'] = 'peserta/posting_data_peserta/getdata';
	$route['peserta/data-peserta/add'] = 'peserta/posting_data_peserta/add';
	$route['peserta/data-peserta/store'] = 'peserta/posting_data_peserta/store';
	$route['peserta/data-peserta/edit/(:any)'] = 'peserta/posting_data_peserta/edit/$1';
	$route['peserta/data-peserta/update/(:any)'] = 'peserta/posting_data_peserta/update/$1';
	$route['peserta/data-peserta/delete/(:any)'] = 'peserta/posting_data_peserta/delete/$1';
	$route['peserta/data-peserta/delete-exec/(:any)'] = 'peserta/posting_data_peserta/delete_exec/$1';
	$route['peserta/data-peserta/view/(:any)'] = 'peserta/posting_data_peserta/view/$1';
	// ++ extra 
	$route['peserta/posting-data-peserta/posting/(:any)'] = 'peserta/posting_data_peserta/posting/$1';


	// update data peserta
	$route['peserta/update-data-peserta'] = 'peserta/update_data_peserta/index';
	/*
		$route['peserta/update-data-peserta/getdata'] = 'peserta/update_data_peserta/getdata';
		$route['peserta/update-data-peserta/add'] = 'peserta/update_data_peserta/add';
		$route['peserta/update-data-peserta/store'] = 'peserta/update_data_peserta/store';
	*/
	$route['peserta/update-data-peserta/edit/(:any)'] = 'peserta/update_data_peserta/edit/$1';
	$route['peserta/update-data-peserta/update/(:any)'] = 'peserta/update_data_peserta/update/$1';
	$route['peserta/update-data-peserta/delete/(:any)'] = 'peserta/update_data_peserta/delete/$1';
	$route['peserta/update-data-peserta/delete-exec/(:any)'] = 'peserta/update_data_peserta/delete_exec/$1';
	$route['peserta/update-data-peserta/view/(:any)'] = 'peserta/update_data_peserta/view/$1';
	// ++ extra
	$route['peserta/update-data-peserta/geteditform/(:any)'] = 'peserta/update_data_peserta/geteditform/$1';
	
	// riwayat kelas peserta
	$route['peserta/riwayat-kelas'] = 'peserta/riwayat_kelas/index';
	$route['peserta/riwayat-kelas/getdata'] = 'peserta/riwayat_kelas/getdata';
	$route['peserta/riwayat-kelas/getdata2'] = 'peserta/riwayat_kelas/getdata2';
	$route['peserta/riwayat-kelas/add'] = 'peserta/riwayat_kelas/add';
	$route['peserta/riwayat-kelas/store'] = 'peserta/riwayat_kelas/store';
	$route['peserta/riwayat-kelas/edit/(:any)'] = 'peserta/riwayat_kelas/edit/$1';
	$route['peserta/riwayat-kelas/update/(:any)'] = 'peserta/riwayat_kelas/update/$1';
	$route['peserta/riwayat-kelas/delete/(:any)'] = 'peserta/riwayat_kelas/delete/$1';
	$route['peserta/riwayat-kelas/delete-exec/(:any)'] = 'peserta/riwayat_kelas/delete_exec/$1';
	$route['peserta/riwayat-kelas/view/(:any)'] = 'peserta/riwayat_kelas/view/$1';
	$route['peserta/riwayat-kelas/detailqia/(:any)'] = 'peserta/riwayat_kelas/detailqia/$1';
	$route['peserta/riwayat-kelas/detailnonqia/(:any)'] = 'peserta/riwayat_kelas/detailnonqia/$1';

/* end data peserta */

/* start data persediaan habis pakai */
	// kartu stock
	$route['persediaan-habis-pakai/kartu-stock'] = 'persediaan-habis-pakai/kartu_stock/index';
	$route['persediaan-habis-pakai/kartu-stock/getdata'] = 'persediaan-habis-pakai/kartu_stock/getdata';
	$route['persediaan-habis-pakai/kartu-stock/add'] = 'persediaan-habis-pakai/kartu_stock/add';
	$route['persediaan-habis-pakai/kartu-stock/store'] = 'persediaan-habis-pakai/kartu_stock/store';
	$route['persediaan-habis-pakai/kartu-stock/edit/(:any)'] = 'persediaan-habis-pakai/kartu_stock/edit/$1';
	$route['persediaan-habis-pakai/kartu-stock/update/(:any)'] = 'persediaan-habis-pakai/kartu_stock/update/$1';
	$route['persediaan-habis-pakai/kartu-stock/delete/(:any)'] = 'persediaan-habis-pakai/kartu_stock/delete/$1';
	$route['persediaan-habis-pakai/kartu-stock/delete-exec/(:any)'] = 'persediaan-habis-pakai/kartu_stock/delete_exec/$1';
	$route['persediaan-habis-pakai/kartu-stock/view/(:any)'] = 'persediaan-habis-pakai/kartu_stock/view/$1';

	// pengadaan habis pakai
	$route['persediaan-habis-pakai/pengadaan-habis-pakai'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/index';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/getdata'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/getdata';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/add'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/add';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/store'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/store';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/edit/(:any)'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/edit/$1';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/update/(:any)'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/update/$1';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/delete/(:any)'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/delete/$1';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/delete-exec/(:any)'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/delete_exec/$1';
	$route['persediaan-habis-pakai/pengadaan-habis-pakai/view/(:any)'] = 'persediaan-habis-pakai/pengadaan_habis_pakai/view/$1';

	// penyimpanan habis pakai
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/index';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/getdata'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/getdata';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/add'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/add';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/store'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/store';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/edit/(:any)'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/edit/$1';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/update/(:any)'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/update/$1';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/delete/(:any)'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/delete/$1';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/delete-exec/(:any)'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/delete_exec/$1';
	$route['persediaan-habis-pakai/penyimpanan-habis-pakai/view/(:any)'] = 'persediaan-habis-pakai/penyimpanan_habis_pakai/view/$1';

	// penggunaan habis pakai
	$route['persediaan-habis-pakai/pengunaan-habis-pakai'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/index';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/getdata'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/getdata';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/add'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/add';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/store'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/store';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/edit/(:any)'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/edit/$1';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/update/(:any)'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/update/$1';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/delete/(:any)'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/delete/$1';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/delete-exec/(:any)'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/delete_exec/$1';
	$route['persediaan-habis-pakai/pengunaan-habis-pakai/view/(:any)'] = 'persediaan-habis-pakai/pengunaan_habis_pakai/view/$1';

/* end data persediaan habis pakai */

/* start data pengelolaan ruangan */
	// kartu eksploitasi ruangan
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/index';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/getdata'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/getdata';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/add'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/add';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/store'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/store';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/edit/(:any)'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/edit/$1';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/update/(:any)'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/update/$1';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/delete/(:any)'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/delete/$1';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/delete-exec/(:any)'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/delete_exec/$1';
	$route['pengelolaan-ruangan/kartu-eksploitasi-ruangan/view/(:any)'] = 'pengelolaan-ruangan/kartu_eksploitasi_ruangan/view/$1';

	// pemeliharaan ruangan
	$route['pengelolaan-ruangan/pemeliharaan-ruangan'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/index';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/getdata'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/getdata';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/add'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/add';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/store'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/store';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/edit/(:any)'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/edit/$1';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/update/(:any)'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/update/$1';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/delete/(:any)'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/delete/$1';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/delete-exec/(:any)'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/delete_exec/$1';
	$route['pengelolaan-ruangan/pemeliharaan-ruangan/view/(:any)'] = 'pengelolaan-ruangan/pemeliharaan_ruangan/view/$1';

	// pemakaian ruangan
	$route['pengelolaan-ruangan/pemakaian-ruangan'] = 'pengelolaan-ruangan/pemakaian_ruangan/index';
	$route['pengelolaan-ruangan/pemakaian-ruangan/getdata'] = 'pengelolaan-ruangan/pemakaian_ruangan/getdata';
	$route['pengelolaan-ruangan/pemakaian-ruangan/add'] = 'pengelolaan-ruangan/pemakaian_ruangan/add';
	$route['pengelolaan-ruangan/pemakaian-ruangan/store'] = 'pengelolaan-ruangan/pemakaian_ruangan/store';
	$route['pengelolaan-ruangan/pemakaian-ruangan/edit/(:any)'] = 'pengelolaan-ruangan/pemakaian_ruangan/edit/$1';
	$route['pengelolaan-ruangan/pemakaian-ruangan/update/(:any)'] = 'pengelolaan-ruangan/pemakaian_ruangan/update/$1';
	$route['pengelolaan-ruangan/pemakaian-ruangan/delete/(:any)'] = 'pengelolaan-ruangan/pemakaian_ruangan/delete/$1';
	$route['pengelolaan-ruangan/pemakaian-ruangan/delete-exec/(:any)'] = 'pengelolaan-ruangan/pemakaian_ruangan/delete_exec/$1';
	$route['pengelolaan-ruangan/pemakaian-ruangan/view/(:any)'] = 'pengelolaan-ruangan/pemakaian_ruangan/view/$1';

/* end data pengelolaan ruangan */

/* start data at dan inventaris */
	// pengadaan inventaris
	$route['at-dan-inventaris/pengadaan-inventaris'] = 'at-dan-inventaris/pengadaan_inventaris/index';
	$route['at-dan-inventaris/pengadaan-inventaris/getdata'] = 'at-dan-inventaris/pengadaan_inventaris/getdata';
	$route['at-dan-inventaris/pengadaan-inventaris/add'] = 'at-dan-inventaris/pengadaan_inventaris/add';
	$route['at-dan-inventaris/pengadaan-inventaris/store'] = 'at-dan-inventaris/pengadaan_inventaris/store';
	$route['at-dan-inventaris/pengadaan-inventaris/edit/(:any)'] = 'at-dan-inventaris/pengadaan_inventaris/edit/$1';
	$route['at-dan-inventaris/pengadaan-inventaris/update/(:any)'] = 'at-dan-inventaris/pengadaan_inventaris/update/$1';
	$route['at-dan-inventaris/pengadaan-inventaris/delete/(:any)'] = 'at-dan-inventaris/pengadaan_inventaris/delete/$1';
	$route['at-dan-inventaris/pengadaan-inventaris/delete-exec/(:any)'] = 'at-dan-inventaris/pengadaan_inventaris/delete_exec/$1';
	$route['at-dan-inventaris/pengadaan-inventaris/view/(:any)'] = 'at-dan-inventaris/pengadaan_inventaris/view/$1';

	// penggunaan inventaris
	$route['at-dan-inventaris/penggunaan-inventaris'] = 'at-dan-inventaris/penggunaan_inventaris/index';
	$route['at-dan-inventaris/penggunaan-inventaris/getdata'] = 'at-dan-inventaris/penggunaan_inventaris/getdata';
	$route['at-dan-inventaris/penggunaan-inventaris/add'] = 'at-dan-inventaris/penggunaan_inventaris/add';
	$route['at-dan-inventaris/penggunaan-inventaris/store'] = 'at-dan-inventaris/penggunaan_inventaris/store';
	$route['at-dan-inventaris/penggunaan-inventaris/edit/(:any)'] = 'at-dan-inventaris/penggunaan_inventaris/edit/$1';
	$route['at-dan-inventaris/penggunaan-inventaris/update/(:any)'] = 'at-dan-inventaris/penggunaan_inventaris/update/$1';
	$route['at-dan-inventaris/penggunaan-inventaris/delete/(:any)'] = 'at-dan-inventaris/penggunaan_inventaris/delete/$1';
	$route['at-dan-inventaris/penggunaan-inventaris/delete-exec/(:any)'] = 'at-dan-inventaris/penggunaan_inventaris/delete_exec/$1';
	$route['at-dan-inventaris/penggunaan-inventaris/view/(:any)'] = 'at-dan-inventaris/penggunaan_inventaris/view/$1';

	// pemeliharaan inventaris
	$route['at-dan-inventaris/pemeliharaan-inventaris'] = 'at-dan-inventaris/pemeliharaan_inventaris/index';
	$route['at-dan-inventaris/pemeliharaan-inventaris/getdata'] = 'at-dan-inventaris/pemeliharaan_inventaris/getdata';
	$route['at-dan-inventaris/pemeliharaan-inventaris/add'] = 'at-dan-inventaris/pemeliharaan_inventaris/add';
	$route['at-dan-inventaris/pemeliharaan-inventaris/store'] = 'at-dan-inventaris/pemeliharaan_inventaris/store';
	$route['at-dan-inventaris/pemeliharaan-inventaris/edit/(:any)'] = 'at-dan-inventaris/pemeliharaan_inventaris/edit/$1';
	$route['at-dan-inventaris/pemeliharaan-inventaris/update/(:any)'] = 'at-dan-inventaris/pemeliharaan_inventaris/update/$1';
	$route['at-dan-inventaris/pemeliharaan-inventaris/delete/(:any)'] = 'at-dan-inventaris/pemeliharaan_inventaris/delete/$1';
	$route['at-dan-inventaris/pemeliharaan-inventaris/delete-exec/(:any)'] = 'at-dan-inventaris/pemeliharaan_inventaris/delete_exec/$1';
	$route['at-dan-inventaris/pemeliharaan-inventaris/view/(:any)'] = 'at-dan-inventaris/pemeliharaan_inventaris/view/$1';

	// penyimpanan inventaris
	$route['at-dan-inventaris/penyimpanan-inventaris'] = 'at-dan-inventaris/penyimpanan_inventaris/index';
	$route['at-dan-inventaris/penyimpanan-inventaris/getdata'] = 'at-dan-inventaris/penyimpanan_inventaris/getdata';
	$route['at-dan-inventaris/penyimpanan-inventaris/add'] = 'at-dan-inventaris/penyimpanan_inventaris/add';
	$route['at-dan-inventaris/penyimpanan-inventaris/store'] = 'at-dan-inventaris/penyimpanan_inventaris/store';
	$route['at-dan-inventaris/penyimpanan-inventaris/edit/(:any)'] = 'at-dan-inventaris/penyimpanan_inventaris/edit/$1';
	$route['at-dan-inventaris/penyimpanan-inventaris/update/(:any)'] = 'at-dan-inventaris/penyimpanan_inventaris/update/$1';
	$route['at-dan-inventaris/penyimpanan-inventaris/delete/(:any)'] = 'at-dan-inventaris/penyimpanan_inventaris/delete/$1';
	$route['at-dan-inventaris/penyimpanan-inventaris/delete-exec/(:any)'] = 'at-dan-inventaris/penyimpanan_inventaris/delete_exec/$1';
	$route['at-dan-inventaris/penyimpanan-inventaris/view/(:any)'] = 'at-dan-inventaris/penyimpanan_inventaris/view/$1';

	// depresiasi
	$route['at-dan-inventaris/depresiasi'] = 'at-dan-inventaris/depresiasi/index';
	$route['at-dan-inventaris/depresiasi/getdata'] = 'at-dan-inventaris/depresiasi/getdata';
	$route['at-dan-inventaris/depresiasi/add'] = 'at-dan-inventaris/depresiasi/add';
	$route['at-dan-inventaris/depresiasi/store'] = 'at-dan-inventaris/depresiasi/store';
	$route['at-dan-inventaris/depresiasi/edit/(:any)'] = 'at-dan-inventaris/depresiasi/edit/$1';
	$route['at-dan-inventaris/depresiasi/update/(:any)'] = 'at-dan-inventaris/depresiasi/update/$1';
	$route['at-dan-inventaris/depresiasi/delete/(:any)'] = 'at-dan-inventaris/depresiasi/delete/$1';
	$route['at-dan-inventaris/depresiasi/delete-exec/(:any)'] = 'at-dan-inventaris/depresiasi/delete_exec/$1';
	$route['at-dan-inventaris/depresiasi/view/(:any)'] = 'at-dan-inventaris/depresiasi/view/$1';

	// kartu eksploitasi
	$route['at-dan-inventaris/kartu-eksploitasi'] = 'at-dan-inventaris/kartu_eksploitasi/index';
	$route['at-dan-inventaris/kartu-eksploitasi/getdata'] = 'at-dan-inventaris/kartu_eksploitasi/getdata';
	$route['at-dan-inventaris/kartu-eksploitasi/add'] = 'at-dan-inventaris/kartu_eksploitasi/add';
	$route['at-dan-inventaris/kartu-eksploitasi/store'] = 'at-dan-inventaris/kartu_eksploitasi/store';
	$route['at-dan-inventaris/kartu-eksploitasi/edit/(:any)'] = 'at-dan-inventaris/kartu_eksploitasi/edit/$1';
	$route['at-dan-inventaris/kartu-eksploitasi/update/(:any)'] = 'at-dan-inventaris/kartu_eksploitasi/update/$1';
	$route['at-dan-inventaris/kartu-eksploitasi/delete/(:any)'] = 'at-dan-inventaris/kartu_eksploitasi/delete/$1';
	$route['at-dan-inventaris/kartu-eksploitasi/delete-exec/(:any)'] = 'at-dan-inventaris/kartu_eksploitasi/delete_exec/$1';
	$route['at-dan-inventaris/kartu-eksploitasi/view/(:any)'] = 'at-dan-inventaris/kartu_eksploitasi/view/$1';

/* end data at dan inventaris */

/* start data perpustakaan */
	// data buku
	$route['perpustakaan/data-buku'] = 'perpustakaan/perpus_buku/index';
	$route['perpustakaan/data-buku/getdata'] = 'perpustakaan/perpus_buku/getdata';
	$route['perpustakaan/data-buku/add'] = 'perpustakaan/perpus_buku/add';
	$route['perpustakaan/data-buku/store'] = 'perpustakaan/perpus_buku/store';
	$route['perpustakaan/data-buku/edit/(:any)'] = 'perpustakaan/perpus_buku/edit/$1';
	$route['perpustakaan/data-buku/update/(:any)'] = 'perpustakaan/perpus_buku/update/$1';
	$route['perpustakaan/data-buku/delete/(:any)'] = 'perpustakaan/perpus_buku/delete/$1';
	$route['perpustakaan/data-buku/delete-exec/(:any)'] = 'perpustakaan/perpus_buku/delete_exec/$1';
	$route['perpustakaan/data-buku/view/(:any)'] = 'perpustakaan/perpus_buku/view/$1';

	// data anggota
	$route['perpustakaan/data-anggota'] = 'perpustakaan/perpus_anggota/index';
	$route['perpustakaan/data-anggota/getdata'] = 'perpustakaan/perpus_anggota/getdata';
	$route['perpustakaan/data-anggota/add'] = 'perpustakaan/perpus_anggota/add';
	$route['perpustakaan/data-anggota/store'] = 'perpustakaan/perpus_anggota/store';
	$route['perpustakaan/data-anggota/edit/(:any)'] = 'perpustakaan/perpus_anggota/edit/$1';
	$route['perpustakaan/data-anggota/update/(:any)'] = 'perpustakaan/perpus_anggota/update/$1';
	$route['perpustakaan/data-anggota/delete/(:any)'] = 'perpustakaan/perpus_anggota/delete/$1';
	$route['perpustakaan/data-anggota/delete-exec/(:any)'] = 'perpustakaan/perpus_anggota/delete_exec/$1';
	$route['perpustakaan/data-anggota/view/(:any)'] = 'perpustakaan/perpus_anggota/view/$1';

	// data peminjaman
	$route['perpustakaan/data-peminjaman'] = 'perpustakaan/perpus_peminjaman/index';
	$route['perpustakaan/data-peminjaman/getdata'] = 'perpustakaan/perpus_peminjaman/getdata';
	$route['perpustakaan/data-peminjaman/add'] = 'perpustakaan/perpus_peminjaman/add';
	$route['perpustakaan/data-peminjaman/store'] = 'perpustakaan/perpus_peminjaman/store';
	$route['perpustakaan/data-peminjaman/edit/(:any)'] = 'perpustakaan/perpus_peminjaman/edit/$1';
	$route['perpustakaan/data-peminjaman/update/(:any)'] = 'perpustakaan/perpus_peminjaman/update/$1';
	$route['perpustakaan/data-peminjaman/delete/(:any)'] = 'perpustakaan/perpus_peminjaman/delete/$1';
	$route['perpustakaan/data-peminjaman/delete-exec/(:any)'] = 'perpustakaan/perpus_peminjaman/delete_exec/$1';
	$route['perpustakaan/data-peminjaman/view/(:any)'] = 'perpustakaan/perpus_peminjaman/view/$1';
	
	// data pengembalian
	$route['perpustakaan/data-pengembalian'] = 'perpustakaan/perpus_pengembalian/index';
	$route['perpustakaan/data-pengembalian/getdata'] = 'perpustakaan/perpus_pengembalian/getdata';
	$route['perpustakaan/data-pengembalian/add'] = 'perpustakaan/perpus_pengembalian/add';
	$route['perpustakaan/data-pengembalian/store'] = 'perpustakaan/perpus_pengembalian/store';
	$route['perpustakaan/data-pengembalian/edit/(:any)'] = 'perpustakaan/perpus_pengembalian/edit/$1';
	$route['perpustakaan/data-pengembalian/update/(:any)'] = 'perpustakaan/perpus_pengembalian/update/$1';
	$route['perpustakaan/data-pengembalian/delete/(:any)'] = 'perpustakaan/perpus_pengembalian/delete/$1';
	$route['perpustakaan/data-pengembalian/delete-exec/(:any)'] = 'perpustakaan/perpus_pengembalian/delete_exec/$1';
	$route['perpustakaan/data-pengembalian/view/(:any)'] = 'perpustakaan/perpus_pengembalian/view/$1';

/* end data perpustakaan */

/* start data kepegawaian */
	// kontraprestasi pegawai
	$route['kepegawaian/kontraprestasi-pegawai'] = 'kepegawaian/kontraprestasi_pegawai/index';
	$route['kepegawaian/kontraprestasi-pegawai/getdata'] = 'kepegawaian/kontraprestasi_pegawai/getdata';
	$route['kepegawaian/kontraprestasi-pegawai/add'] = 'kepegawaian/kontraprestasi_pegawai/add';
	$route['kepegawaian/kontraprestasi-pegawai/store'] = 'kepegawaian/kontraprestasi_pegawai/store';
	$route['kepegawaian/kontraprestasi-pegawai/edit/(:any)'] = 'kepegawaian/kontraprestasi_pegawai/edit/$1';
	$route['kepegawaian/kontraprestasi-pegawai/update/(:any)'] = 'kepegawaian/kontraprestasi_pegawai/update/$1';
	$route['kepegawaian/kontraprestasi-pegawai/delete/(:any)'] = 'kepegawaian/kontraprestasi_pegawai/delete/$1';
	$route['kepegawaian/kontraprestasi-pegawai/delete-exec/(:any)'] = 'kepegawaian/kontraprestasi_pegawai/delete_exec/$1';
	$route['kepegawaian/kontraprestasi-pegawai/view/(:any)'] = 'kepegawaian/kontraprestasi_pegawai/view/$1';
	$route['kepegawaian/kontraprestasi-pegawai/datapegawai'] = 'kepegawaian/kontraprestasi-pegawai/datapegawai';

	// data pegawai
	$route['kepegawaian/data-pegawai'] = 'kepegawaian/data_pegawai/index';
	$route['kepegawaian/data-pegawai/getdata'] = 'kepegawaian/data_pegawai/getdata';
	$route['kepegawaian/data-pegawai/add'] = 'kepegawaian/data_pegawai/add';
	$route['kepegawaian/data-pegawai/store'] = 'kepegawaian/data_pegawai/store';
	$route['kepegawaian/data-pegawai/edit/(:any)'] = 'kepegawaian/data_pegawai/edit/$1';
	$route['kepegawaian/data-pegawai/update/(:any)'] = 'kepegawaian/data_pegawai/update/$1';
	$route['kepegawaian/data-pegawai/delete/(:any)'] = 'kepegawaian/data_pegawai/delete/$1';
	$route['kepegawaian/data-pegawai/delete-exec/(:any)'] = 'kepegawaian/data_pegawai/delete_exec/$1';
	$route['kepegawaian/data-pegawai/view/(:any)'] = 'kepegawaian/data_pegawai/view/$1';

	// kinerja pegawai
	$route['kepegawaian/kinerja-pegawai'] = 'kepegawaian/kinerja_pegawai/index';
	$route['kepegawaian/kinerja-pegawai/getdata'] = 'kepegawaian/kinerja_pegawai/getdata';
	$route['kepegawaian/kinerja-pegawai/add'] = 'kepegawaian/kinerja_pegawai/add';
	$route['kepegawaian/kinerja-pegawai/store'] = 'kepegawaian/kinerja_pegawai/store';
	$route['kepegawaian/kinerja-pegawai/edit/(:any)'] = 'kepegawaian/kinerja_pegawai/edit/$1';
	$route['kepegawaian/kinerja-pegawai/update/(:any)'] = 'kepegawaian/kinerja_pegawai/update/$1';
	$route['kepegawaian/kinerja-pegawai/delete/(:any)'] = 'kepegawaian/kinerja_pegawai/delete/$1';
	$route['kepegawaian/kinerja-pegawai/delete-exec/(:any)'] = 'kepegawaian/kinerja_pegawai/delete_exec/$1';
	$route['kepegawaian/kinerja-pegawai/view/(:any)'] = 'kepegawaian/kinerja_pegawai/view/$1';

	// cuti pegawai
	$route['kepegawaian/cuti-pegawai'] = 'kepegawaian/cuti_pegawai/index';
	$route['kepegawaian/cuti-pegawai/getdata'] = 'kepegawaian/cuti_pegawai/getdata';
	$route['kepegawaian/cuti-pegawai/add'] = 'kepegawaian/cuti_pegawai/add';
	$route['kepegawaian/cuti-pegawai/store'] = 'kepegawaian/cuti_pegawai/store';
	$route['kepegawaian/cuti-pegawai/edit/(:any)'] = 'kepegawaian/cuti_pegawai/edit/$1';
	$route['kepegawaian/cuti-pegawai/update/(:any)'] = 'kepegawaian/cuti_pegawai/update/$1';
	$route['kepegawaian/cuti-pegawai/delete/(:any)'] = 'kepegawaian/cuti_pegawai/delete/$1';
	$route['kepegawaian/cuti-pegawai/delete-exec/(:any)'] = 'kepegawaian/cuti_pegawai/delete_exec/$1';
	$route['kepegawaian/cuti-pegawai/view/(:any)'] = 'kepegawaian/cuti_pegawai/view/$1';

	// pembinaan pegawai
	$route['kepegawaian/pembinaan-pegawai'] = 'kepegawaian/pembinaan_pegawai/index';
	$route['kepegawaian/pembinaan-pegawai/getdata'] = 'kepegawaian/pembinaan_pegawai/getdata';
	$route['kepegawaian/pembinaan-pegawai/add'] = 'kepegawaian/pembinaan_pegawai/add';
	$route['kepegawaian/pembinaan-pegawai/store'] = 'kepegawaian/pembinaan_pegawai/store';
	$route['kepegawaian/pembinaan-pegawai/edit/(:any)'] = 'kepegawaian/pembinaan_pegawai/edit/$1';
	$route['kepegawaian/pembinaan-pegawai/update/(:any)'] = 'kepegawaian/pembinaan_pegawai/update/$1';
	$route['kepegawaian/pembinaan-pegawai/delete/(:any)'] = 'kepegawaian/pembinaan_pegawai/delete/$1';
	$route['kepegawaian/pembinaan-pegawai/delete-exec/(:any)'] = 'kepegawaian/pembinaan_pegawai/delete_exec/$1';
	$route['kepegawaian/pembinaan-pegawai/view/(:any)'] = 'kepegawaian/pembinaan_pegawai/view/$1';
	$route['kepegawaian/pembinaan-pegawai/datapegawai'] = 'kepegawaian/pembinaan_pegawai/datapegawai';

	// lembur pegawai
	$route['kepegawaian/lembur-pegawai'] = 'kepegawaian/lembur_pegawai/index';
	$route['kepegawaian/lembur-pegawai/getdata'] = 'kepegawaian/lembur_pegawai/getdata';
	$route['kepegawaian/lembur-pegawai/add'] = 'kepegawaian/lembur_pegawai/add';
	$route['kepegawaian/lembur-pegawai/store'] = 'kepegawaian/lembur_pegawai/store';
	$route['kepegawaian/lembur-pegawai/edit/(:any)'] = 'kepegawaian/lembur_pegawai/edit/$1';
	$route['kepegawaian/lembur-pegawai/update/(:any)'] = 'kepegawaian/lembur_pegawai/update/$1';
	$route['kepegawaian/lembur-pegawai/delete/(:any)'] = 'kepegawaian/lembur_pegawai/delete/$1';
	$route['kepegawaian/lembur-pegawai/delete-exec/(:any)'] = 'kepegawaian/lembur_pegawai/delete_exec/$1';
	$route['kepegawaian/lembur-pegawai/view/(:any)'] = 'kepegawaian/lembur_pegawai/view/$1';

	// presensi
	$route['kepegawaian/presensi'] = 'kepegawaian/presensi/index';
	$route['kepegawaian/presensi/getdata'] = 'kepegawaian/presensi/getdata';
	$route['kepegawaian/presensi/add'] = 'kepegawaian/presensi/add';
	$route['kepegawaian/presensi/store'] = 'kepegawaian/presensi/store';
	$route['kepegawaian/presensi/edit/(:any)'] = 'kepegawaian/presensi/edit/$1';
	$route['kepegawaian/presensi/update/(:any)'] = 'kepegawaian/presensi/update/$1';
	$route['kepegawaian/presensi/delete/(:any)'] = 'kepegawaian/presensi/delete/$1';
	$route['kepegawaian/presensi/delete-exec/(:any)'] = 'kepegawaian/presensi/delete_exec/$1';
	$route['kepegawaian/presensi/view/(:any)'] = 'kepegawaian/presensi/view/$1';

	// bpjs ketenagakerjaan
	$route['kepegawaian/bpjs-ketenagakerjaan'] = 'kepegawaian/bpjs_ketenagakerjaan/index';
	$route['kepegawaian/bpjs-ketenagakerjaan/getdata'] = 'kepegawaian/bpjs_ketenagakerjaan/getdata';
	$route['kepegawaian/bpjs-ketenagakerjaan/add'] = 'kepegawaian/bpjs_ketenagakerjaan/add';
	$route['kepegawaian/bpjs-ketenagakerjaan/store'] = 'kepegawaian/bpjs_ketenagakerjaan/store';
	$route['kepegawaian/bpjs-ketenagakerjaan/edit/(:any)'] = 'kepegawaian/bpjs_ketenagakerjaan/edit/$1';
	$route['kepegawaian/bpjs-ketenagakerjaan/update/(:any)'] = 'kepegawaian/bpjs_ketenagakerjaan/update/$1';
	$route['kepegawaian/bpjs-ketenagakerjaan/delete/(:any)'] = 'kepegawaian/bpjs_ketenagakerjaan/delete/$1';
	$route['kepegawaian/bpjs-ketenagakerjaan/delete-exec/(:any)'] = 'kepegawaian/bpjs_ketenagakerjaan/delete_exec/$1';
	$route['kepegawaian/bpjs-ketenagakerjaan/view/(:any)'] = 'kepegawaian/bpjs_ketenagakerjaan/view/$1';
	$route['kepegawaian/bpjs-ketenagakerjaan/datapegawai'] = 'kepegawaian/bpjs_ketenagakerjaan/datapegawai';

	// bpjs kesehatan
	$route['kepegawaian/bpjs-kesehatan'] = 'kepegawaian/bpjs_kesehatan/index';
	$route['kepegawaian/bpjs-kesehatan/getdata'] = 'kepegawaian/bpjs_kesehatan/getdata';
	$route['kepegawaian/bpjs-kesehatan/add'] = 'kepegawaian/bpjs_kesehatan/add';
	$route['kepegawaian/bpjs-kesehatan/store'] = 'kepegawaian/bpjs_kesehatan/store';
	$route['kepegawaian/bpjs-kesehatan/edit/(:any)'] = 'kepegawaian/bpjs_kesehatan/edit/$1';
	$route['kepegawaian/bpjs-kesehatan/update/(:any)'] = 'kepegawaian/bpjs_kesehatan/update/$1';
	$route['kepegawaian/bpjs-kesehatan/delete/(:any)'] = 'kepegawaian/bpjs_kesehatan/delete/$1';
	$route['kepegawaian/bpjs-kesehatan/delete-exec/(:any)'] = 'kepegawaian/bpjs_kesehatan/delete_exec/$1';
	$route['kepegawaian/bpjs-kesehatan/view/(:any)'] = 'kepegawaian/bpjs_kesehatan/view/$1';
	$route['kepegawaian/bpjs-kesehatan/datapegawai'] = 'kepegawaian/bpjs_kesehatan/datapegawai';

/* end data kepegawaian */

/* start data informasi hasil evaluasi */
	$route['informasi-hasil-evaluasi'] = 'informasi_hasil_evaluasi/index';
	$route['informasi-hasil-evaluasi/getdata'] = 'informasi_hasil_evaluasi/getdata';
	$route['informasi-hasil-evaluasi/add'] = 'informasi_hasil_evaluasi/add';
	$route['informasi-hasil-evaluasi/store'] = 'informasi_hasil_evaluasi/store';
	$route['informasi-hasil-evaluasi/edit/(:any)'] = 'informasi_hasil_evaluasi/edit/$1';
	$route['informasi-hasil-evaluasi/update/(:any)'] = 'informasi_hasil_evaluasi/update/$1';
	$route['informasi-hasil-evaluasi/delete/(:any)'] = 'informasi_hasil_evaluasi/delete/$1';
	$route['informasi-hasil-evaluasi/delete-exec/(:any)'] = 'informasi_hasil_evaluasi/delete_exec/$1';
	$route['informasi-hasil-evaluasi/view/(:any)'] = 'informasi_hasil_evaluasi/view/$1';
/* end data informasi hasil evaluasi */

/* start data informasi skt */
	$route['informasi-skt'] = 'informasi_skt/index';
	$route['informasi-skt/getdata'] = 'informasi_skt/getdata';
	$route['informasi-skt/add'] = 'informasi_skt/add';
	$route['informasi-skt/store'] = 'informasi_skt/store';
	$route['informasi-skt/edit/(:any)'] = 'informasi_skt/edit/$1';
	$route['informasi-skt/update/(:any)'] = 'informasi_skt/update/$1';
	$route['informasi-skt/delete/(:any)'] = 'informasi_skt/delete/$1';
	$route['informasi-skt/delete-exec/(:any)'] = 'informasi_skt/delete_exec/$1';
	$route['informasi-skt/view/(:any)'] = 'informasi_skt/view/$1';
/* end data informasi skt */

/* start data backup */
	$route['backup/backup'] = 'backup/backup/index';
	$route['backup/backup/getdata'] = 'backup/backup/getdata';
	$route['backup/backup/add'] = 'backup/backup/add';
	$route['backup/backup/store'] = 'backup/backup/store';
	$route['backup/backup/edit/(:any)'] = 'backup/backup/edit/$1';
	$route['backup/backup/update/(:any)'] = 'backup/backup/update/$1';
	$route['backup/backup/delete/(:any)'] = 'backup/backup/delete/$1';
	$route['backup/backup/delete-exec/(:any)'] = 'backup/backup/delete_exec/$1';
	$route['backup/backup/view/(:any)'] = 'backup/backup/view/$1';
/* end data backup */

/* start data restore */
	$route['backup/restore'] = 'backup/restore/index';
	$route['backup/restore/getdata'] = 'backup/restore/getdata';
	$route['backup/restore/add'] = 'backup/restore/add';
	$route['backup/restore/store'] = 'backup/restore/store';
	$route['backup/restore/edit/(:any)'] = 'backup/restore/edit/$1';
	$route['backup/restore/update/(:any)'] = 'backup/restore/update/$1';
	$route['backup/restore/delete/(:any)'] = 'backup/restore/delete/$1';
	$route['backup/restore/delete-exec/(:any)'] = 'backup/restore/delete_exec/$1';
	$route['backup/restore/view/(:any)'] = 'backup/restore/view/$1';
/* end data restore */

/* start data alumni */
	$route['pengelolaan-alumni'] = 'pengelolaan_alumni/index';
	$route['pengelolaan-alumni/getdata'] = 'pengelolaan_alumni/getdata';
	$route['pengelolaan-alumni/view/(:any)'] = 'pengelolaan_alumni/view/$1';
/* end data alumni */

/* start data pendataan-marketing */
	$route['pendataan-marketing'] = 'pendataan_marketing/index';
	$route['pendataan-marketing/getdata'] = 'pendataan_marketing/getdata';
	$route['pendataan-marketing/add'] = 'pendataan_marketing/add';
	$route['pendataan-marketing/store'] = 'pendataan_marketing/store';
	$route['pendataan-marketing/edit/(:any)'] = 'pendataan_marketing/edit/$1';
	$route['pendataan-marketing/update/(:any)'] = 'pendataan_marketing/update/$1';
	$route['pendataan-marketing/delete/(:any)'] = 'pendataan_marketing/delete/$1';
	$route['pendataan-marketing/delete-exec/(:any)'] = 'pendataan_marketing/delete_exec/$1';
	$route['pendataan-marketing/view/(:any)'] = 'pendataan_marketing/view/$1';
/* end data pendataan-marketing */

/* start data setting-jadwal */
	$route['kelas-pelatihan/setting-jadwal/(:any)'] = 'kelas-pelatihan/setting_jadwal/index/$1';
	$route['kelas-pelatihan/setting-jadwal/getdata/(:any)'] = 'kelas-pelatihan/setting_jadwal/getdata/$1';
/* end data setting-jadwal */
