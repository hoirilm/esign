<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LabRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'lab_number',
        'request_number',
        'request_date',
        'specimen_date',
        'finished_date',
        'sender_doctor',
        'pathologist_doctor',
        'printed_by',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'request_date' => 'datetime',
            'specimen_date' => 'datetime',
            'finished_date' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(LabResult::class);
    }

    public function verification(): HasOne
    {
        return $this->hasOne(Verification::class);
    }
}
