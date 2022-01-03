<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function addProductRating(Request $request)
    {
        $validator = \Validator::make($request->all(), [ 
            'product_id' => 'required',
            'rating' => 'required'
        ]);
       
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $clientIP = $request->ip();
        $duplicateRatingCheck = Rating::firstWhere(['user_ip' => $clientIP, 'product_id' => $request->input('product_id')]);

        if ($duplicateRatingCheck === null) {
            Rating::create([
                'product_id' => $request->input('product_id'),
                'user_ip' => $clientIP,
                'rating' => $request->input('rating')
            ]);
        } else {
            Rating::where(["user_ip" => $clientIP, "product_id" => $request->input('product_id')])
            ->update(["rating" => $request->input('rating')]);
        }

        return response()->json(['success' => true]);
    }
}
