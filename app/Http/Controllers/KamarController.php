<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        return Kamar::with('foto')->get();
    }

    public function show($id)
    {
        return Kamar::with('foto')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_kamar' => 'required|unique:kamar',
            'lantai' => 'nullable|integer',
            'kapasitas' => 'nullable|integer|min:1',
            'harga_per_malam' => 'required|numeric',
            'status_kamar' => 'nullable|in:kosong,baru dipesan,terisi,perbaikan',
            'deskripsi' => 'nullable|string'
        ]);

        return Kamar::create($data);
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->all());
        return $kamar;
    }

    public function destroy($id)
    {
        Kamar::destroy($id);
        return response()->json(['message' => 'Kamar dihapus']);
    }
}
