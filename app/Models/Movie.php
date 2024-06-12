<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'favourite'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
