<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarcodeValidationController extends Controller
{
    /**
     * Validate a barcode and return operator/machine information.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateBarcode(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'barcode' => 'required|string|max:255',
        ]);

        try {
            // Call the stored procedure using SQL Server syntax
            $results = DB::connection('SP_Connection')->select('EXEC [dbo].[gt_data] @Barcode = ?', [
                $validated['barcode']
            ]);

            // Process results - stored procedure returns a single row
            if (count($results) > 0) {
                $result = $results[0];

                // Check if barcode exists
                if ($result->Barcode) {
                    return response()->json([
                        'success' => true,
                        'exists' => true,
                        'data' => [
                            'machine' => $result->Machine,
                            'operator_name' => $result->OperatorName,
                            'operator_code' => $result->OperatorCode
                        ]
                    ]);
                } else {
                    // Barcode doesn't exist
                    return response()->json([
                        'success' => true,
                        'exists' => false,
                        'message' => 'Barcode not found'
                    ]);
                }
            } else {
                // No results returned from stored procedure
                return response()->json([
                    'success' => false,
                    'message' => 'Error validating barcode'
                ], 500);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Barcode validation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while validating the barcode'
            ], 500);
        }
    }
}
