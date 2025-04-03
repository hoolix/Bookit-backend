<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
     /**
     * Get all business types.
     */
    public function getBusinessTypes()
    {
        // Get all business types from the database
        $businessTypes = BusinessType::all();

        return response()->json([
            'status' => 'success',
            'data' => $businessTypes,
        ]);
    }
}
