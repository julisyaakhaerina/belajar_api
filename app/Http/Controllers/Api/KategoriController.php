<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Str;
use Validator;


class KategoriController extends Controller
{
    public function index(){
        $kategori = Kategori::latest()->get();
        $res = [
            'success' => true,
            'message' => 'Daftar Kategori',
            'data' => $kategori,
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $kategori = new Kategori();
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->slug = Str::slug($request->nama_kategori);
            $kategori->save();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dibuat',
                'data' => $kategori,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try{
            $kategori = Kategori::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'detail kategori',
                'data' => $kategori,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'deta tidak ditemukan',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->slug = Str::slug($request->nama_kategori);
            $kategori->save();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
                'data' => $kategori,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return response()->json([
                'success' => true,
                'message' => 'kategori'  . $kategori->nama_kategori .  'berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'deta tidak ditemukan',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }

}
