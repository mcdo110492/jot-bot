<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceCategory extends Model
{
    protected $table  = 'tblprice_categories';
    protected $primaryKey = 'price_cat_id';

    protected $fillable = [
   		'description',
   		'price',
        'parent_id'
    ];


    public function subCategory () 

    {
        return $this->hasMany($this,'parent_id');
    }

}
