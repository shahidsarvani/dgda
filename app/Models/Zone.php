<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'phase_id',
        'room_id',
        'scene_id',
        'status',
    ];

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
