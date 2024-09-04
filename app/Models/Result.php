<?php

// In Result.php (Model)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject_id', 'grade'];

    // Define relationships if needed
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
