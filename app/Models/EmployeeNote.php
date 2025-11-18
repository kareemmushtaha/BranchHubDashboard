<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'note_date',
        'title',
        'content',
        'user_id',
    ];

    protected $casts = [
        'note_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

