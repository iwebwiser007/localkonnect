<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    protected $table = 'slugs';

    protected $fillable = ['reference_id', 'key', 'prefix'];  // Include 'prefix' here

    // Define the relationship with the MpStore model
    public function store()
    {
        return $this->belongsTo(MpStore::class, 'reference_id');
    }

    // Add a scope to filter by the store's prefix
    public function scopeByPrefix($query, $prefix)
    {
        return $query->where('prefix', $prefix);
    }
}
