<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $imagePath = "public/room/images";

    protected $fillable = [
        'name',
        'name_ar',
        'type',
        'status',
        'image',
        'image_ar',
    ];
    
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
