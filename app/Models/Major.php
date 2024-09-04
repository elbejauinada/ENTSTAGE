<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the students for the major.
     */
    public function students()
    {
        return $this->hasMany(User::class, 'major_id');
    }
}
