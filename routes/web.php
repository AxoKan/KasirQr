<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controller::class, 'login'])->name('login');
Route::post('/aksi_login', [Controller::class, 'aksi_login']);
Route::get('/login1', [Controller::class, 'login1']);
Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');  
Route::get('/activity_log', [Controller::class, 'activitylog'])->name('activity_log');
Route::get('/setting/1', [Controller::class, 'setting'])->name('setting'); 
Route::post('/aksi_setting', [Controller::class, 'aksi_setting']);
Route::get('/User', [Controller::class, 'User'])->name('User'); 
Route::get('/TambahUser', [Controller::class, 'add_user'])->name('add_user');
Route::post('/aksi_add_user', [Controller::class, 'aksi_add_user']);
Route::get('delete/{id}', [Controller::class, 'DelUser'])->name('DelUser');
Route::get('/UpdateUser/{id}', [Controller::class, 'Update_user'])->name('Update_user');
Route::post('/aksi_update_user', [Controller::class, 'aksi_update_user']);
Route::get('/Menu', [Website::class, 'menu'])->name('Menu');
Route::get('deleteMenu/{id}', [Website::class, 'deleteMenu'])->name('deleteMenu');
Route::get('/TambahMenu', [Website::class, 'TambahMenu'])->name('TambahMenu');
Route::post('/aksi_add_Menu', [Website::class, 'aksi_add_Menu']);
Route::get('/EditMenu/{id}', [Website::class, 'EditMenu'])->name('EditMenu');
Route::post('/aksi_Edit_Menu', [Website::class, 'aksi_Edit_Menu']);
Route::get('/transaksi', [Website::class, 'transaksi'])->name('transaksi');
Route::get('/status/{id}', [Website::class, 'status'])->name('status');
Route::get('/Cancel/{id}', [Website::class, 'Cancel'])->name('Cancel');
Route::get('/meja', [Website::class, 'meja'])->name('meja');
Route::get('/tambah_meja', [Website::class, 'tambah_meja'])->name('tambah_meja');
Route::post('/aksi_add_meja', [Website::class, 'aksi_add_meja']);
Route::get('/scan', [Website::class, 'scan'])->name('scan');
Route::get('/Kasir/{id}', [Website::class, 'Kasir'])->name('Kasir');
Route::post('/aksi_kasir', [Website::class, 'aksi_kasir']);
Route::get('/Nota/{id}', [Website::class, 'Nota'])->name('Nota');
Route::get('/member', [Website::class, 'member'])->name('member');
Route::get('/deleteMember/{id}', [Website::class, 'deleteMember'])->name('deleteMember');
Route::get('/TambahMember', [Website::class, 'TambahMember'])->name('TambahMember');
Route::post('/aksi_add_member', [Website::class, 'aksi_add_member']);
Route::get('/EditMember/{id}', [Website::class, 'EditMember'])->name('EditMember');
Route::post('/aksi_EditMember', [Website::class, 'aksi_EditMember']);
Route::get('/KartuMember/{id}', [Website::class, 'KartuMember'])->name('KartuMember');
Route::get('/Voucher', [Website::class, 'Voucher'])->name('Voucher');
Route::get('/deleteVoucher/{id}', [Website::class, 'deleteVoucher'])->name('deleteVoucher');
Route::get('/TambahVoucher', [Website::class, 'TambahVoucher'])->name('TambahVoucher');
Route::post('/aksi_add_Voucher', [Website::class, 'aksi_add_Voucher']);
Route::get('/EditVoucher/{id}', [Website::class, 'EditVoucher'])->name('EditVoucher');
Route::post('/aksi_EditVoucher', [Website::class, 'aksi_EditVoucher']);
Route::get('/VoucherPaper/{id}', [Website::class, 'VoucherPaper'])->name('VoucherPaper');