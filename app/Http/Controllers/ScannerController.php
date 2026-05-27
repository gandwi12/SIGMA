<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NutritionScannerService;

class ScannerController extends Controller
{
    protected $scannerService;

    public function __construct(NutritionScannerService $scannerService)
    {
        $this->scannerService = $scannerService;
    }

    /**
     * Endpoint untuk Scanner AI di halaman tambah/edit menu mitra.
     * Return JSON supaya bisa autofill input kalori/protein/lemak.
     */
    public function analyzeFood(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:5120',
        ]);

        $result = $this->scannerService->scan($request->file('foto')->getRealPath());

        if (!$result) {
            return response()->json([
                'food_name'   => 'Gagal analisis AI',
                'calories'    => 0,
                'protein'     => 0,
                'fat'         => 0,
                'confidence'  => 0,
                'description' => 'Gagal mendeteksi makanan. Coba upload foto yang lebih jelas.',
            ], 500);
        }

        return response()->json([
            'food_name'   => $result['nama'],
            'calories'    => $result['kalori'],
            'protein'     => $result['protein'],
            'fat'         => $result['lemak'],
            'confidence'  => 90,
            'description' => 'Terdeteksi sebagai ' . $result['nama'] . ' oleh Gemini Vision AI.',
        ]);
    }
}