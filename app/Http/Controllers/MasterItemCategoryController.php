<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MasterItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_items_category.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = Category::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('kode', 'nama', 'deskripsi')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = Category::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('master_items_category.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = Category::where('kode', $kode)->first();
        return view('master_items_category.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new Category;
            $kode = Category::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = Category::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->deskripsi = $request->deskripsi;
        $data_item->kode = $kode;
        $data_item->save();

        return redirect('master-items-category');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        return redirect('master-items-category');
    }


    public function exportPdf($id)
    {
        $category = Category::with('masterItems')->findOrFail($id);
        
        $data = [
            'category' => $category,
            'items' => $category->masterItems,
            'total_items' => $category->masterItems->count(),
            'printed_at' => now()
        ];
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('master_items_category.single.pdf', $data);
        
        $pdf->setPaper('A4');
        
        return $pdf->download('kategori_' . $category->kode_category . '_' . date('Ymd_His') . '.pdf');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterItemCategory  $masterItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MasterItemCategory $masterItemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterItemCategory  $masterItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterItemCategory $masterItemCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterItemCategory  $masterItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterItemCategory $masterItemCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterItemCategory  $masterItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterItemCategory $masterItemCategory)
    {
        //
    }
}
