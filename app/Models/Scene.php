<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'room_id',
        'command_id',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }
}