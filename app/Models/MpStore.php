<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpStore extends Model
{
    use HasFactory;

    protected $table = 'mp_stores';
  
  public function getStoreUrlAttribute()
    {
        // Assuming you want to filter by a specific prefix
        $slug = Slug::where('reference_id', $this->id)
                    ->where('prefix', 'stores') // Replace 'store-prefix' with the actual prefix condition
                    ->first();

        // If the slug exists, return the formatted URL with the slug's key
        if ($slug && $slug->key) {
            return 'https://www.localkonnect.com/stores/' . $slug->key;
        }

        // Return a default URL if no matching slug is found
        return 'https://www.localkonnect.com/stores/default';
    }

    // Optionally, you can add the following method to get all stores with cities
    public static function getAllCitiesWithNames()
    {
        return self::select('id', 'name', 'city')->get();
    }
}

