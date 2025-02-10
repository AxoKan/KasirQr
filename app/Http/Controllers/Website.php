<?php

namespace App\Http\Controllers;
use App\Models\M_lelang;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Website extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function menu()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Menu Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
    $data['sa'] = $model->tampil('menu',
    'id_menu');
 

    echo view ('esensial/header', $data);
    echo view ('esensial/menu', $data);
    echo view('website/menu/menu',$data);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function deleteMenu($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_menu' => $id];
    $isi = array(
            'deleted_at' => date('Y-m-d H:i:s')
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Deleted',
            'description' => 'User Deleted Menu Data.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('menu', $where ,$isi);

    return redirect()->to('Menu');
}
public function TambahMenu()
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Add Menu Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $data1['t'] = $model->tampil('menu',
'id_menu');

           echo view ('esensial/header', $data);
           echo view ('esensial/menu', $data);
           echo view('website/menu/TambahMenu',$data1);
           echo view ('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
public function aksi_add_Menu(Request $request)
{
    $userLevel = session()->get('Level');
    $allowedLevels = ['petugas', 'admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();
        
        // Retrieve input data
        $a = $request->input('Kategory');
        $b = $request->input('Menu');
        $e = $request->input('harga');
        $d = $request->input('Keterangan', '-'); // Default to '-' if empty
        $c = $request->input('stok');
        $dashboardImage = $request->file('image');
        $uploadPath = public_path('assets/img/Menu/');
        
        // Prepare data array
        $data = [
            'Kategory' => $a,
            'nama_menu' => $b,
            'keterangan' => $d, // Already set to '-' if empty
            'harga_menu' => $e,
            'stok' => $c
        ];
        
        // Handle image upload
        if ($dashboardImage) {
            $dashboardFileName = $dashboardImage->getClientOriginalName(); // Get the original file name
            $filePath = $uploadPath . '/' . $dashboardFileName;

            // Check if a file with the same name already exists
            if (file_exists($filePath)) {
                // File with the same name exists, skip upload or generate a unique name
                $dashboardFileName = time() . '_' . $dashboardFileName; // Append timestamp to make it unique
                $filePath = $uploadPath . '/' . $dashboardFileName; // Update file path
            }

            // Move the uploaded file to the target directory
            $dashboardImage->move($uploadPath, $dashboardFileName);
            $data['foto'] = $dashboardFileName; // Save the file name in the data array
        }
        
        // Insert data into the database
        $model->tambah('menu', $data);
        
        // Log the activity
        try {
            $timestamp = now(); // Use Laravel's now() function for current time
            DB::table('activity_log')->insert([
                'user_id' => $user_id,
                'activity' => 'add',
                'description' => 'User added Menu Data.',
                'timestamp' => $timestamp,
            ]);
        } catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }

        // Redirect with success message
        return redirect()->route('Menu')->with('success', 'Menu added successfully!');
    } else {
        // Redirect to error page if user level is not allowed
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
    public function EditMenu($id)
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Add Menu Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $where = array('id_menu'=> $id);
           $data1['menu']=$model->getWhere('menu', $where);
           echo view ('esensial/header', $data);
           echo view ('esensial/menu', $data);
           echo view('website/menu/EditMenu',$data1);
           echo view ('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
    public function aksi_Edit_Menu (Request $request)
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();
        $a = $request->input('Kategory');
        $b = $request->input('Menu');
        $e = $request->input('harga');
        $c = $request->input('stok');
        $id = $request->input('id');
        $where = array('id_menu' => $id);
        $dashboardImage = $request->file('image');
        $uploadPath = public_path('assets/img/Menu/');
        
        $data = array(
            'Kategory' => $a,
            'nama_menu' =>  $b,
            'harga_menu' => $e,
            'stok' => $c
         );
         if ($dashboardImage) {
            $dashboardFileName = $dashboardImage->hashName();
            $dashboardImage->move($uploadPath, $dashboardFileName);
            $data['foto'] = $dashboardFileName;
        }
         $model->edit('menu',$where, $data);
         try {
            $timestamp = now(); // Use Laravel's now() function for current time
            DB::table('activity_log')->insert([
                'user_id' => $user_id,
                'activity' => 'add',
                'description' => 'User added Menu Data.',
                'timestamp' => $timestamp,
            ]);
        }catch (\Exception $e) {
                // Log the error if activity logging fails
                logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
            }
            return redirect()->route('Menu')->with('success', 'Settings updated successfully!');
print_r($isi);
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
	}
    public function transaksi ()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Menu Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
    $data1['sa'] = $model->tampil('transaksi',
    'transaksi');
    $data1['detail'] = DB::table('detail_transaksi')
    ->join('menu', 'detail_transaksi.menu_id', '=', 'menu.id_menu')
    ->get();


    echo view ('esensial/header', $data);
    echo view ('esensial/menu', $data);
    echo view('website/kasir/transaksi',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function status($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_transaksi' => $id];
    $isi = array(
            'status' => '2'
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Complete',
            'description' => 'User Completed a transaction.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('transaksi',$where,$isi );
print_r($isi);
print_r($where);
    return redirect()->to('transaksi');
}
public function Cancel($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_transaksi' => $id];
    $whereForeign = ['transaksi_id' => $id];

    // Data for soft delete
    $isi = array(
        'deleted_at' => date('Y-m-d H:i:s') // Soft delete flag
    );

    try {
        // Logging the cancellation activity
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Cancel',
            'description' => 'User Canceled a Transaction.',
            'timestamp' => $timestamp,
        ]);
    } catch (\Exception $e) {
        // Log the error if activity logging fails
        logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
    }

    // Soft delete the main transaction record
    $model->edit('transaksi', $where, $isi);

    // Soft delete the related detail_transaksi records based on foreign key
    $model->edit('detail_transaksi', $whereForeign, $isi);

    // Redirect to Menu or other desired page
    return redirect()->to('transaksi');
}
public function meja ()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Meja Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
    $data1['sa'] = $model->tampil('meja',
    'transaksi');


    echo view ('esensial/header', $data);
    echo view ('esensial/menu', $data);
    echo view('website/meja/meja',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}

public function tambah_meja()
{
    $userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];
    $user_id = session()->get('id_user');
    if (in_array($userLevel, $allowedLevels)) {
    $model= new M_lelang();
       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Add Meja Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
        echo view('esensial/header', $data);
        echo view('esensial/menu', $data);
        echo view('website/meja/tambah_meja');
        echo view('esensial/footer');
    } else {
        return redirect()->to('notfound');
    }
}
 public function aksi_add_meja(Request $request)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $e = $request->input('nama');
    $isi = array(
            'No_meja' => $e
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Add',
            'description' => 'User Added a Meja Number.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->tambah('meja',$isi );
print_r($isi);

    return redirect()->to('meja');
}
public function scan()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();
    
           // Fetch all logo data
           $logoData = $model->tampil('logo'); // Fetch all logos
           $filteredLogo = $logoData->filter(function ($item) {
               return $item->id_logo == 1; // Adjust this condition as needed
           });
           $data['satu'] = $filteredLogo->first();
           $logs = $model->getActivityLogs();
           $data['users'] = $model->tampil('user', 'id_user');
           try {
               $timestamp = now(); // Use Laravel's now() function for current time
               DB::table('activity_log')->insert([
                   'user_id' => $user_id,
                   'activity' => 'View',
                   'description' => 'User viewed Scan Page.',
                   'timestamp' => $timestamp,
               ]);
           }catch (\Exception $e) {
                   // Log the error if activity logging fails
                   logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
               }
    
    
    
        echo view ('esensial/header', $data);
        echo view ('esensial/menu', $data);
        echo view('website/scan/scan');
        echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function kasir($id)
{
        $model = new M_lelang();
    $user_id = session()->get('id_user');
   // Fetch all logo data
   $logoData = $model->tampil('logo'); // Fetch all logos
   $filteredLogo = $logoData->filter(function ($item) {
       return $item->id_logo == 1; // Adjust this condition as needed
   });
   $data['satu'] = $filteredLogo->first();
   $logs = $model->getActivityLogs();
   $data['users'] = $model->tampil('user', 'id_user');
   try {
       $timestamp = now(); // Use Laravel's now() function for current time
       DB::table('activity_log')->insert([
           'user_id' => $user_id,
           'activity' => 'View',
           'description' => 'User viewed Kasir Page.',
           'timestamp' => $timestamp,
       ]);
   }catch (\Exception $e) {
           // Log the error if activity logging fails
           logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
       }
$data1['t'] = $model->tampil('menu',
'id_menu');
$data1['Voucher'] = $model->tampil('voucher',
'id_Voucher');
$data1['member'] = $model->tampil('membership',
'id_member');

$where = ['id_meja' => $id];
$data1['meja']=$model->getWhere('meja', $where);
    echo view('esensial/header',$data);
    echo view('website/Kasir/kasir',$data1);
    echo view('esensial/footer',$data);

}


public function aksi_kasir(Request $request)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $meja = $request->input('meja');
    $total = $request->input('total');
    $bayar = $request->input('bayar');
    $menuItem = $request->input('menu'); // This will give an array of id_menu
    $price = $request->input('harga');
    $kembalian = $request->input('kembalian');
    $id = $request->input('id');
    $menuItems = $request->input('menu_items'); // 'menu_items' should be an array of menu data

    // Insert data into the `transaksi` table
    // Ambil nomor terakhir dari transaksi
$lastTransaction = DB::table('transaksi')
->orderBy('Nomor', 'desc')
->first();

if ($lastTransaction && preg_match('/G(\d+)/', $lastTransaction->Nomor, $matches)) {
$newNumber = 'G' . ($matches[1] + 1);
} else {
$newNumber = 'G34'; // Jika tidak ada transaksi sebelumnya, mulai dari G34
}

// Buat data transaksi baru
$transaksiData = [
'Nomor' => $newNumber,
'nama_pelanggan' => $meja,
'tanggal_transaksi' => date('Y-m-d'),
'total_harga' => $total,
'bayar' => $bayar,
'kembalian' => $kembalian,
'status' => '1',
'created_at' => date('Y-m-d H:i:s'),
];
    // Insert the transaction and get the ID of the inserted row
    $transaksiId = $model->tambah1('transaksi', $transaksiData);
    print_r($transaksiId);
    if ($request->input('menu') && $request->input('harga')) {
        $menuItems = array_map(null, $request->input('menu'), $request->input('harga'));
    
        foreach ($menuItems as $item) {
            list($menuId, $harga) = $item;
    
            $detailData = [
                'transaksi_id' => $transaksiId, // ID transaksi dari parent
                'menu_id' => $menuId, // ID menu
                'subtotal' => $harga, // Harga menu
                'created_at' => date('Y-m-d H:i:s'),
            ];
    
            // Simpan ke database menggunakan model
            $model->tambah1('detail_transaksi', $detailData);
    
            // Debugging (opsional)
            print_r($detailData);
        }
        return redirect()->to('Kasir/' . $id)->with('success', 'Transaction completed successfully.');
    }
    
}    
public function Nota ($id)
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Nota.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $where = ['id_transaksi' => $id];
    $data1['sa'] = $model->getWhere('transaksi', $where );
    $where1 = ['transaksi_id' => $id];
    $data1['detail'] = DB::table('detail_transaksi')
    ->join('menu', 'detail_transaksi.menu_id', '=', 'menu.id_menu')
    ->where($where1)
    ->get();
    $data1['satu'] = $filteredLogo->first();
    $logs = $model->getActivityLogs();
    
    echo view ('esensial/header', $data);
    echo view('website/kasir/Nota',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function member ()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Member Data.',
               'timestamp' => $timestamp,
           ]);
           
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $data1['sa'] = $model->tampil('membership', 'id_member');   
           foreach ($data1['sa'] as $voucher) {
               if (isset($voucher->Valid) && strtotime($voucher->Valid) < time() && $voucher->status !== '2') {
                   // Update the status to '2' if the voucher has expired
                   $where = ['id_member' => $voucher->id_member];
                   $isi = ['status' => '2'];
                   $model->edit('membership', $where, $isi);
               }
           }
           

    echo view ('esensial/header', $data);
    echo view ('esensial/menu', $data);
    echo view('website/membership/member',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function deleteMember($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_member' => $id];
    $isi = array(
            'deleted_at' => date('Y-m-d H:i:s')
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Deleted',
            'description' => 'User Deleted Member Data.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('membership', $where ,$isi);

    return redirect()->to('member');
}
public function TambahMember()
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Add Membership .',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
 

           echo view ('esensial/header', $data);
           echo view ('esensial/menu', $data);
           echo view('website/membership/TambahMember');
           echo view ('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
public function aksi_add_member(Request $request)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $e = $request->input('Nomor');
    $b = $request->input('nama');
    $c = $request->input('time'); // Input value for the time
    $currentDate = Carbon::now(); // Get the current date
    
    // Calculate the Valid date based on the input time
    switch ($c) {
        case 1:
            $validDate = $currentDate->addMonth(); // Add 1 month
            break;
        case 2:
            $validDate = $currentDate->addMonths(5); // Add 5 months
            break;
        case 3:
            $validDate = $currentDate->addYear(); // Add 1 year
            break;
        default:
            $validDate = $currentDate; // Default to current date if no valid input
            break;
    }
    
    $isi = array(
        'NoMember' => $e,
        'nama' => $b,
        'Valid' => $validDate->toDateString(), // Format the date to a string (YYYY-MM-DD)
        'diskon' => '10'
    );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Add',
            'description' => 'User Added a Membership.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->tambah('membership',$isi );
print_r($isi);

    return redirect()->to('member');
}
public function EditMember($id)
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Update Membership.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $where = array('id_member'=> $id);
           $data1['member']=$model->getWhere('membership', $where);

           echo view ('esensial/header', $data);
           echo view ('esensial/menu', $data);
           echo view('website/membership/EditMember',$data1);
           echo view ('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
public function aksi_EditMember(Request $request)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $e = $request->input('Nomor');
    $b = $request->input('nama');
    $id = $request->input('id');
        $where = array('id_member' => $id);
    $isi = array(
            'NoMember' => $e,
            'nama' => $b,
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Update',
            'description' => 'User Updated a Membership.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('membership', $where ,$isi );
print_r($isi);

    return redirect()->to('member');
}
public function KartuMember ($id)
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Member.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $where = array('id_member'=> $id);
           $data1['member']=$model->getWhere('membership', $where);
    $data1['satu'] = $filteredLogo->first();
    $logs = $model->getActivityLogs();
    
    echo view ('esensial/header', $data);
    echo view('website/membership/Kartu',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function Voucher()
{
    $userLevel = session()->get('Level');
    $allowedLevels = ['petugas', 'admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        // Fetch all logo data
        $logoData = $model->tampil('logo'); // Fetch all logos
        $filteredLogo = $logoData->filter(function ($item) {
            return $item->id_logo == 1; // Adjust this condition as needed
        });
        $data['satu'] = $filteredLogo->first();
        $logs = $model->getActivityLogs();
        $data['users'] = $model->tampil('user', 'id_user');

        try {
            $timestamp = now(); // Use Laravel's now() function for current time
            DB::table('activity_log')->insert([
                'user_id' => $user_id,
                'activity' => 'View',
                'description' => 'User viewed Voucher Data.',
                'timestamp' => $timestamp,
            ]);
        } catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }

        // Fetch vouchers data
        $data1['sa'] = $model->tampil('Voucher', 'id_Voucher');

        // Check if any voucher has expired and update its status to '2'
        foreach ($data1['sa'] as $voucher) {
            if (strtotime($voucher->Valid) < time() && $voucher->status != 2) {
                // Update the status to '2' if the voucher has expired
                $where = ['id_Voucher' => $voucher->id_Voucher];
                $isi = ['status' => '2'];
                $model->edit('voucher', $where, $isi);
            }
        }

        // Render the views
        echo view('esensial/header', $data);
        echo view('esensial/menu', $data);
        echo view('website/Voucher/Voucher', $data1);
        echo view('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}

public function deleteVoucher($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_Voucher' => $id];
    $isi = array(
            'deleted_at' => date('Y-m-d H:i:s')
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Deleted',
            'description' => 'User Deleted Voucher Data.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('voucher', $where ,$isi);

    return redirect()->to('Voucher');
}
public function TambahVoucher()
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Add Voucher .',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
 

           echo view ('esensial/header', $data);
           echo view ('esensial/menu', $data);
           echo view('website/Voucher/TambahVoucher');
           echo view ('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
public function aksi_add_Voucher(Request $request)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $e = $request->input('Nomor');
    $b = $request->input('nama');
    $c = $request->input('diskon');
    $d = $request->input('Valid');
    $isi = array(
            'No_Voucher' => $e,
            'Nama_Voucher' => $b,
            'Diskon' => $c,
            'Valid' => $d
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Add',
            'description' => 'User Added a Voucher.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->tambah('Voucher',$isi );
print_r($isi);

    return redirect()->to('Voucher');
}
public function EditVoucher($id)
	{
        $userLevel = session()->get('Level');
        $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Update Voucher.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $where = array('id_Voucher'=> $id);
           $data1['Voucher']=$model->getWhere('voucher', $where);

           echo view ('esensial/header', $data);
           echo view ('esensial/menu', $data);
           echo view('website/Voucher/EditVoucher',$data1);
           echo view ('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
public function aksi_EditVoucher(Request $request)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $e = $request->input('Nomor');
    $b = $request->input('nama');
    $d = $request->input('Valid');
    $c = $request->input('diskon');
    $id = $request->input('id');
    $where = array('id_Voucher' => $id);
    $isi = array(
          'No_Voucher' => $e,
            'Nama_Voucher' => $b,
            'Diskon' => $c,
            'Valid' => $d
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Add',
            'description' => 'User Added a Voucher.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('voucher', $where,$isi);
print_r($isi);
print_r($where);
    return redirect()->to('Voucher');
}
public function VoucherPaper ($id)
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed voucher.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $where = array('id_Voucher'=> $id);
           $data1['Voucher']=$model->getWhere('voucher', $where);
    $data1['satu'] = $filteredLogo->first();
    $logs = $model->getActivityLogs();
    
    echo view ('esensial/header', $data);
    echo view('website/Voucher/VoucherPaper',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
public function StopVoucher($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_Voucher' => $id];
    $isi = array(
            'status' => '2'
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Deleted',
            'description' => 'User Stop Voucher Data.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('voucher', $where ,$isi);

    return redirect()->to('Voucher');
}
public function StopMember($id)
{
    $model = new M_lelang();
    $user_id = session()->get('id_user');
    $where = ['id_member' => $id];
    $isi = array(
            'status' => '2'
        
     );
     try {
        $timestamp = now(); // Use Laravel's now() function for current time
        DB::table('activity_log')->insert([
            'user_id' => $user_id,
            'activity' => 'Deleted',
            'description' => 'User Stop Voucher Data.',
            'timestamp' => $timestamp,
        ]);
    }catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }
    $model->edit('membership', $where ,$isi);

    return redirect()->to('member');
}

public function Laporan()
{
    $userLevel = session()->get('Level');
    $allowedLevels = ['petugas', 'admin'];

    if (in_array($userLevel, $allowedLevels)) {
        $user_id = session()->get('id_user');
        $model = new M_lelang();

        // Fetch all logo data
        $logoData = $model->tampil('logo'); // Fetch all logos
        $filteredLogo = $logoData->filter(function ($item) {
            return $item->id_logo == 1; // Adjust this condition as needed
        });
        $data['satu'] = $filteredLogo->first();
        $logs = $model->getActivityLogs();
        $data['users'] = $model->tampil('user', 'id_user');

        try {
            $timestamp = now(); // Use Laravel's now() function for current time
            DB::table('activity_log')->insert([
                'user_id' => $user_id,
                'activity' => 'View',
                'description' => 'User viewed Voucher Data.',
                'timestamp' => $timestamp,
            ]);
        } catch (\Exception $e) {
            // Log the error if activity logging fails
            logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
        }

        // Fetch vouchers data
        $data1['sa'] = $model->tampil('Voucher', 'id_Voucher');

        // Check if any voucher has expired and update its status to '2'
        foreach ($data1['sa'] as $voucher) {
            if (strtotime($voucher->Valid) < time() && $voucher->status != 2) {
                // Update the status to '2' if the voucher has expired
                $where = ['id_Voucher' => $voucher->id_Voucher];
                $isi = ['status' => '2'];
                $model->edit('voucher', $where, $isi);
            }
        }

        // Render the views
        echo view('esensial/header', $data);
        echo view('esensial/menu', $data);
        echo view('website/laporan/laporan', $data1);
        echo view('esensial/footer');
    } else {
        return redirect()->to('http://localhost:8080/home/error_404');
    }
}
public function print ()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Menu Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $e = request()->input('MONTH');
$b = request()->input('YEAR');

           
        $data1['sa'] = $model->Cari('transaksi',$e,$b);



    echo view ('esensial/header', $data);

    echo view('website/laporan/print',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}

public function pdf1 ()
{$userLevel = session()->get('Level');
    $allowedLevels = ['petugas','admin'];

    if (in_array($userLevel, $allowedLevels)) {
    $user_id = session()->get('id_user');
    $model = new M_lelang();

       // Fetch all logo data
       $logoData = $model->tampil('logo'); // Fetch all logos
       $filteredLogo = $logoData->filter(function ($item) {
           return $item->id_logo == 1; // Adjust this condition as needed
       });
       $data['satu'] = $filteredLogo->first();
       $logs = $model->getActivityLogs();
       $data['users'] = $model->tampil('user', 'id_user');
       try {
           $timestamp = now(); // Use Laravel's now() function for current time
           DB::table('activity_log')->insert([
               'user_id' => $user_id,
               'activity' => 'View',
               'description' => 'User viewed Menu Data.',
               'timestamp' => $timestamp,
           ]);
       }catch (\Exception $e) {
               // Log the error if activity logging fails
               logger()->error('Failed to log activity for user ID ' . $user_id . ': ' . $e->getMessage());
           }
           $e = request()->input('MONTH');
$b = request()->input('YEAR');

           
        $data1['sa'] = $model->Cari('transaksi',$e,$b);



    echo view ('esensial/header', $data);

    echo view('website/laporan/pdf',$data1);
    echo view ('esensial/footer');
} else {
    return redirect()->to('http://localhost:8080/home/error_404');
}
}
}

    // Redirect or display transaction and details for debugging
   




	


