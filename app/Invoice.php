<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'invoice_number' => 'integer',
        'customer_id' => 'integer',
        'total' => 'integer',
        'subtotal' => 'integer',
        'tax' => 'integer',
        'status' => 'string',
        'note' => 'string',
        'is_paid' => 'boolean',
        'invoice_date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
        'paid_at' => 'date:Y-m-d',
    ];

    //Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //Accessors, Mutators, Helpers, Etc.
    public function getFormattedStatusAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getFormattedTotalAttribute() //move to a helper or trait to be used by product as well
    {
        return money_format('%i', $this->total / 100);
    }
}
