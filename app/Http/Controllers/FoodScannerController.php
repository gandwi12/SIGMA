<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FoodScannerService;

class FoodScannerController extends Controller
{
    protected $foodScannerService;

    public function __construct(FoodScannerService $foodScannerService)
    {
        $this->foodScannerService = $foodScannerService;
    }

    public function scan(Request $request)
    {
        $request->validate([
            'food_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $imagePath = $request->file('food_image')->getPathname();

        $response = $this->foodScannerService->scanFood($imagePath);

        if (isset($response['success']) && !$response['success']) {
            return response()->json($response, 400);
        }

        return response()->json($response);
    }
}
