<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'name', 'comment', 'rating'];

    public function property()
    {
    return $this->belongsTo(Property::class, 'property_id');
    }

}
