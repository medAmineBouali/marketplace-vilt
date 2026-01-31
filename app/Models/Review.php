<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment'
    ];

    // Relation : Un avis appartient à un utilisateur (l'auteur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Un avis appartient à un produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
