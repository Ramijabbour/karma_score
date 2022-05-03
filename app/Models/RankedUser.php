<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankedUser extends Model
{
    use HasFactory;

    protected $fillable = ['username','karma_score','image_id'];

    protected $hidden = ['created_at','updated_at'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
