<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'device',
        'ip',
        'port',
        'room_id',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
