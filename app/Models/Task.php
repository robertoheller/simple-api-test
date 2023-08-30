<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;

class Task extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
    	'title', 
    	'description',
        'updated_user_id',
        'completed',
    ];


    public function images() {
        return $this->hasMany(Image::class);
    }


}
