<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Invoices extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'invoiceId';

    protected $fillable = [
        'rrNo',
        'dateIssued',
        'amountPaid',
        'status',
        'customer',
        'user_id'
    ];


    public function users (){
        return $this->belongsTo('App\User','user_id');
    }
}
