<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'business_type_id', // Foreign key for business type
        'phone',
        'user_id',
    ];

    /**
     * A business belongs to a business type.
     */
    public function businessType(): BelongsTo
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

    /**
     * A business belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
