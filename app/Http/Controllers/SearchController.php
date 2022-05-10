<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\SearchProfile;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, $propertyId, SearchService $searchService){
        
        $property = Property::findOrFail($propertyId);
        $profiles = SearchProfile::where('propertyType', $property->propertyType)->get();
        
        $matches = $searchService->findMatch($property, $profiles);

        return response()->json([
            'data' => $matches
        ]);

    }
}
