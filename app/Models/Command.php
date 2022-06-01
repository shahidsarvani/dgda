<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'room_id',
        'hardware_id',
        'scene_id',
        'description',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hardware()
    {
        return $this->belongsTo(Hardware::class);
    }

    public function scenes()
    {
        return $this->belongsToMany(Scene::class);
    }
}
