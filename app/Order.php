<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'status'
    ];
    public function orderItens()
    {

        return $this->hasMany(OrderItem::class)
            ->select( \DB::raw('product_id, sum(valor) as valores, count(1) as qtd'))
            ->groupBy('product_id')
            ->orderBy('product_id', 'desc');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'order_id','id');
    }

    public static function consultaId($where)
    {
        $order = self::where($where)->first(['id']);
        return !empty($order->id) ? $order->id : null;
    }
}

