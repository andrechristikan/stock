<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFlow extends Model
{
    protected $table = 'item_flows';

    protected $fillable = [
        'user_id', 'item_id', 'type', 'quantity'
    ];


    public function scopeGetByItemId($query, $item_id){
        return $query->where('item_flows.item_id','=', $item_id);
    }
}
