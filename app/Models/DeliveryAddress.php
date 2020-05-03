<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'delivery_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'city', 'postcode', 'street', 'order_id'
    ];
}
