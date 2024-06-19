<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCommodityLocationRequest;
use App\Http\Requests\UpdateCommodityLocationRequest;

class CommodityLocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(CommodityLocation::class, 'commodity_location');
    }

    public function index()
    {
        $commodity_locations = DB::table('commodity_locations')->orderBy('name', 'ASC')->get();
        return view('commodity-locations.index', compact('commodity_locations'));
    }

    public function create()
    {
        $rooms = DB::table('rooms')->get(); // Fetch all rooms
        return view('commodity-locations.create', compact('rooms'));
    }

    public function store(StoreCommodityLocationRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Create the CommodityLocation
            $commodityLocation = DB::table('commodity_locations')->insertGetId([
                'name' => $validated['name'],
                'guard_name' => 'web'
            ]);

            // Attach selected rooms to the CommodityLocation
            if (isset($validated['rooms'])) {
                foreach ($validated['rooms'] as $roomId) {
                    DB::table('commodity_location_room')->insert([
                        'commodity_location_id' => $commodityLocation,
                        'room_id' => $roomId
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('commodity-locations.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->route('commodity-locations.index')->with('error', 'Data gagal ditambahkan!');
        }
    }

    public function update(UpdateCommodityLocationRequest $request, $id)
    {
        $commodityLocation = DB::table('commodity_locations')->where('id', $id)->update($request->all());

        return to_route('commodity-locations.index')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $commodityLocation = DB::table('commodity_locations')->where('id', $id)->first();

        if (DB::table('commodities')->where('commodity_location_id', $commodityLocation->id)->exists()) {
            return to_route('commodity-locations.index')
                ->with('error', 'Ruangan tidak dapat dihapus karena masih terkait dengan data komoditas!');
        }

        DB::table('commodity_locations')->where('id', $id)->delete();

        return to_route('commodity-locations.index')->with('success', 'Data berhasil dihapus!');
    }

    public function export()
    {
        // Assuming you have a CommodityLocationsExport class for Excel export
        return Excel::download(new CommodityLocationsExport, 'daftar-ruangan-' . date('d-m-Y') . '.xlsx');
    }

    public function import(CommodityLocationImportRequest $request)
    {
        Excel::import(new CommodityLocationsImport, $request->file('file'));

        return to_route('commodity-locations.index')->with('success', 'Data ruangan berhasil diimpor!');
    }
}
