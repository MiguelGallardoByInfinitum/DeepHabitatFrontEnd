<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moodboard extends Model
{
    protected $table = 'moodboards';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'moodboard_id'
    ];

    public $timestamps = false;
}


?>