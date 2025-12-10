<?php

namespace App\Http\Controllers;

use App\Models\FotoKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoKamarController extends Controller
{
    /**
     * Hanya untuk keperluan API jika diperlukan
     */
    public function destroy($id)
    {
        $foto = FotoKamar::findOrFail($id);
        
        if ($foto->url) {
            $path = str_replace('/storage/', '', $foto->url);
            Storage::disk('public')->delete($path);
        }
        
        $foto->delete();

        return response()->json(['message' => 'Foto dihapus']);
    }
}
