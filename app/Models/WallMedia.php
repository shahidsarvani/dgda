<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WallMedia extends Model
{
    use HasFactory;

    public $mediaPath = "public/media/";

    protected $fillable = [
        'name',
        'title_ar',
        'title_en',
        'room_id',
        'duration',
    ];

    public function getMediaPath()
    {
        return $this->mediaPath;
    }
}
