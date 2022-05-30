<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    public $mediaPath = "public/media/";

    protected $fillable = [
        'name',
        'file_key',
        'file_type',
        'size',
        'room_id',
        'scene_id',
        'phase_id',
        'zone_id',
    ];

    public function getMediaPath()
    {
        return $this->mediaPath;
    }
}
