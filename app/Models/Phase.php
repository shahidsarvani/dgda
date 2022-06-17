<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    public $imagePath = "public/phase/images";

    protected $fillable = [
        'name',
        'name_ar',
        'room_id',
        'status',
        'image',
        'image_ar',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
