<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lighting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'room_id',
        'lighting_type_id',
        'command_id',
        'scene_id',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function lighting_type()
    {
        return $this->belongsTo(LightingType::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    public function scene()
    {
        return $this->belongsTo(Scene::class);
    }
}
