<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        return Penyewa::all();
    }

    public function show($id)
    {
        return Penyewa::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_penyewa' => 'required|string',
            'tgl_lahir' => 'nullable|date',
            'umur' => 'nullable|integer',
            'jk' => 'nullable|in:L,P',
            'no_tlp' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        return Penyewa::create($data);
    }

    public function update(Request $request, $id)
    {
        $penyewa = Penyewa::findOrFail($id);
        $penyewa->update($request->all());
        return $penyewa;
    }

    public function destroy($id)
    {
        Penyewa::destroy($id);
        return response()->json(['message' => 'Penyewa dihapus']);
    }
}
