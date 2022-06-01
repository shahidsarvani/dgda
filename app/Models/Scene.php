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
        'status',
    ];

    protected $hidden = ['commands'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function commands()
    {
        return $this->belongsToMany(Command::class);
    }
}
