<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    
    protected $table = 'items';

    protected $fillable = [
        'name', 'amount', 'photo'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'photo' => 'string',
    ];
    
    public function getPhotoAttribute($value)
{
	return $value ?? '';
}

    public function scopeGetAllItem($query){
        return $query->select(
            'items.id as id',
            'items.name as name',
            'items.amount as amount',
            'items.photo as photo',
            DB::raw('( select SUM(quantity) from item_flows where item_flows.item_id = items.id ) as quantity')
        )->having('quantity', '>', 0);
    }

    public function scopeGetOneItemById($query, $id){
        return $query->select(
            'items.id as id',
            'items.name as name',
            'items.amount as amount',
            'items.photo as photo',
            DB::raw('( select SUM(quantity) from item_flows where item_flows.item_id = items.id ) as quantity')
        )->where('items.id', '=', $id)->having('quantity', '>', 0);
    }
}
