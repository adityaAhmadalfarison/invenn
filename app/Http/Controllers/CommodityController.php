<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
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

class CommodityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Commodity::class, 'commodity');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Commodity::query();
        $query->when(request()->filled('condition'), function ($q) {
            return $q->where('condition', request('condition'));
        });

        $query->when(request()->filled('commodity_location_id'), function ($q) {
            return $q->where('commodity_location_id', request('commodity_location_id'));
        });

        // $query->when(request()->filled('school_operational_assistance_id'), function ($q) {
        //     return $q->where('school_operational_assistance_id', request('school_operational_assistance_id'));
        // });

        $query->when(request()->filled('year_of_purchase'), function ($q) {
            return $q->where('year_of_purchase', request('year_of_purchase'));
        });

        $commodities = $query->latest()->get();
        $year_of_purchases = Commodity::pluck('year_of_purchase')->unique()->sort();
        // $school_operational_assistances = SchoolOperationalAssistance::orderBy('name', 'ASC')->get();
        $commodity_locations = CommodityLocation::orderBy('name', 'ASC')->get();

        return view(
            'commodities.index',
            compact('commodities', 'commodity_locations', 'year_of_purchases')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommodityRequest $request)
    {
        Commodity::create($request->validated());

        return to_route('barang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommodityRequest $request, Commodity $commodity)
    {
        $commodity->update($request->all());

        return to_route('barang.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commodity $commodity)
    {
        $commodity->delete();

        return to_route('barang.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Generate PDF for all commodities.
     */
    public function generatePDF()
    {
        $this->authorize('print barang');

        $commodities = Commodity::all();
        $pdf = Pdf::loadView('commodities.pdf', compact(['commodities']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    /**
     * Generate PDF for a specific commodity.
     */
    public function generatePDFIndividually($id)
    {
        $this->authorize('print individual barang');

        $commodity = Commodity::find($id);
        $pdf = Pdf::loadView('commodities.pdfone', compact(['commodity',]))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    /**
     * Export commodities data to Excel.
     */
    public function export()
    {
        $this->authorize('export barang');

        return Excel::download(new CommoditiesExport, 'daftar-barang-' . date('d-m-Y') . '.xlsx');
    }

    /**
     * Import commodities data from Excel.
     */
    public function import(CommodityImportRequest $request)
    {
        $this->authorize('import barang');

        Excel::import(new CommoditiesImport, $request->file('file'));

        return to_route('barang.index')->with('success', 'Data barang berhasil diimpor!');
    }
}
