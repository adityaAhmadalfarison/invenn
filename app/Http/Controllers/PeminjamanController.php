<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Peminjaman;
use App\Models\CommodityLocation;
use App\Models\SchoolOperationalAssistance;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\CommoditiesExport;
use App\Http\Requests\CommodityImportRequest;
use App\Http\Requests\StoreCommodityRequest;
use App\Http\Requests\UpdateCommodityRequest;
use App\Imports\CommoditiesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the peminjaman.
     */

     public function create()
     {
         $commodity_locations = CommodityLocation::all();
         $data = DB::table('commodities')->get(); // Fetch all rooms
        //  dd($data);
 
         return view('peminjaman.modal.create', compact('commodity_locations','data'));
     }
 


    public function index()
    {
        $query = Commodity::all();
        // $user = User::all();
        $commodity_locations = CommodityLocation::all();
        $query->when(request()->filled('name'), function ($q) {
            return $q->where('name', request('name'));
        });
        $query->when(request()->filled('commodity_location_id'), function ($q) {
            return $q->where('commodity_location_id', request('commodity_location_id'));
        });
        $query->when(request()->filled('condition'), function ($q) {
            return $q->where('condition', request('condition'));
        });

        // Retrieve all records from the peminjamans table
        $peminjamans = Peminjaman::get();

        // Return a view with the peminjaman data
        return view('peminjaman.index', compact('peminjamans','query','commodity_locations'));
    }

    /**
     * Display the specified peminjaman.
     */
    public function show($id)
    {
        // Retrieve a single record by its id
        $peminjaman = DB::table('peminjamans')->find($id);

        // If the peminjaman doesn't exist, throw a 404 error
        if (!$peminjaman) {
            abort(404);
        }

        // Return a view with the single peminjaman data
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            // 'name' => 'required',
            'commodity_location_id' => 'required',
            'condition' => 'required',
            'id_user' => 'required',
            'id_barang' => 'required',
        ]);

        // Simpan data ke database
        DB::table('peminjamans')->insert([
            'name' => $request->name,
            'id_location' => $request->id_location,
            'condition' => $request->condition,
            'id_user' => Auth::id(),
            'id_barang' => $request->id_barang,
            // Tambahkan atribut lainnya jika diperlukan
        ]);

        // Redirect atau tampilkan pesan sukses
        return redirect('/peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }
}
