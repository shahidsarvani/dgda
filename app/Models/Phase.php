<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'room_id',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
