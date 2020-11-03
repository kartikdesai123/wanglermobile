<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoiceproduct extends Model
{
     protected $table = 'invoice_product';
    //
    function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }
}
