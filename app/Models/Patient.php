<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'rm_number',
        'name',
        'identity_number',
        'dob',
        'gender',
        'address',
        'phone',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
        ];
    }

    public function labRequests(): HasMany
    {
        return $this->hasMany(LabRequest::class);
    }
}
