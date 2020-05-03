<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'quantity'
    ];

    /**
     * Check if product is in stock
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->quantity > 0;
    }
}
