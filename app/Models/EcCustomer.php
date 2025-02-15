<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcCustomer extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'ec_customers'; // If the table name is not the plural of the model name

    // Define the primary key (if it's not the default 'id')
    protected $primaryKey = 'id';

  

    // Disable timestamps if not used in the table (adjust as needed)
    public $timestamps = true;

    // Define the fillable attributes (columns that can be mass-assigned)
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'dob',
        'phone',
        'remember_token',
        'confirmed_at',
        'email_verify_token',
        'status',
        'city',
        'block_reason',
        'private_notes',
        'is_vendor',
        'vendor_verified_at',
        'stripe_account_id',
        'stripe_account_active',
    ];

    // Define any casts for non-standard attribute types
    protected $casts = [
        'dob' => 'date',
        'confirmed_at' => 'datetime',
        'vendor_verified_at' => 'datetime',
    ];

    // Define relationships if needed (example, one-to-many with orders, adjust according to your relationships)
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id'); // Assuming 'customer_id' in orders
    }
    
}
