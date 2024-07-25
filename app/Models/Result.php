<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    // Définir la table associée au modèle
    protected $table = 'results';

    // Définir les attributs mass assignable
    protected $fillable = [
        'user_id',
        'subject_id',
        'grade',
    ];

    // Définir les relations, si nécessaire
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
