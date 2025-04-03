<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessType extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Business type name

    /**
     * A business type can be assigned to multiple users.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'business_type_id');
    }
}
