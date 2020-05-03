<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'orders';

    public function deliveryAddress()
    {
        return $this->hasOne(DeliveryAddress::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(
            Products::class,
            'orders_products',
            'order_id',
            'product_id'
        )
            ->withPivot('quantity');
    }
}
