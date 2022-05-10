<?php

namespace App\Services;

class SearchService{

    public function findMatch($property, $profiles){
        $propertyFields = $property['fields'];

        $matchingProfiles = [];

        foreach ($profiles as $key => $profile) {
            //search through each profile
            $profile['score'] = 0;
            $profile['strictMatchesCount'] = 0;
            $profile['looseMatchesCount'] = 0;
            $profile['searchProfileId'] = $profile['id'];

            $searchFields = $profile['searchFields'];

            foreach ($propertyFields as $propKey => $propertyField) {
                // search through each field of the property to find matches per profile
                
                if (array_key_exists($propKey, $searchFields)){
                    // $matchingProfiles
                    if ($this->isStrictMatch($searchFields[$propKey], $propertyField)){
                        $profile['score'] += 2;
                        $profile['strictMatchesCount'] += 1;
                    }elseif($this->isLooseMatch($searchFields[$propKey], $propertyField)){
                        $profile['score'] += 1;
                        $profile['looseMatchesCount'] += 1;
                    }
                }
            }
            if ($profile['score'] > 0){
                array_push($matchingProfiles, $profile);
            }
        }

        return collect($matchingProfiles)->sortByDesc('score');
    }

    public function isStrictMatch($pattern, $value){
        if (is_numeric($pattern) && ($pattern == $value)){
            return true;
        }
        if ($pattern == $value){
            return true;
        }
        if (is_array($pattern)){
            if ($pattern[0] == null && array_key_exists(1, $pattern)){
                return $value <= $pattern[1];
            }
            if (array_key_exists(1, $pattern) && ($pattern[1] == null)){
                return $value >= $pattern[0];
            }
        }
        //value is within range
        if (is_array($pattern) && (($value >= $pattern[0]) && ($value <= $pattern[1]))){
            return true;
        }
    }

    public function isLooseMatch($pattern, $value){
        $allowed_deviation = 25; // we can set this to come from an external config
        if (is_array($pattern) && array_key_exists(0, $pattern) && $pattern[0] != null && array_key_exists(1, $pattern) && $pattern[1] != null){
            $lowerBoundary = $pattern[0];
            $upperBoundary = $pattern[1];

            $lowerDeviationBoundary = ((100 - $allowed_deviation)/100) * $lowerBoundary;
            $upperDeviationBoundary = ((100 + $allowed_deviation)/100) * $upperBoundary;

            return ($value >= $lowerDeviationBoundary) && ($value <= $upperDeviationBoundary);

        }
        return false;
    }
}