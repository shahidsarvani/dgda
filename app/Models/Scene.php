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
        'model_up_delay',
        'model_down_delay',
        'model_up_delay_ar',
        'model_down_delay_ar',
        'is_default',
    ];

    protected $hidden = ['commands'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function commands()
    {
        return $this->belongsToMany(Command::class)->withPivot('sort_order');
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }
}
