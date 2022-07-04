<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LightScene extends Model
{
    use HasFactory;

    public $imagePath = "public/light_scene/images";

    protected $fillable = [
        'name',
        'name_ar',
        'room_id',
        'status',
        'image_en',
        'image_ar',
    ];

    protected $hidden = ['commands'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function commands()
    {
        return $this->belongsToMany(Command::class, CommandLightScene::class)->withPivot('sort_order');
    }
    
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
