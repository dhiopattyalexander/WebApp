<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use DB;
use App\Models\Staff;
class StaffController extends Controller
{
    public function index() //fungsi untuk menampilkan data staff
    {
        //dapatkan seluruh data staff dengan query builder
        //$ar_staff = DB::table('staff')->get();
	    $ar_staff = Staff::all(); //menggunakan eloquent
        //arahkan ke halaman baru dengan menyertakan data staff(compact)
        //di resources/views/staff/index.blade.php
        return view('staff.index',compact('ar_staff'));
    }
}