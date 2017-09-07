<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $table = 'invoiceItems';

    protected $primaryKey = 'invoiceItemId';

    protected $fillable = [
        'invoiceId',
        'itemTypeId',
        'groupId',
        'currentPrice',
        'qty'
    ];


    public function itemType () {
        return $this->belongsTo('App\ItemType','itemTypeId');
    }

    public function group() {
        return $this->belongsTo('App\Group','groupId');
    }
}
