<?php


namespace KejvinGL\OrderTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'status',
        'product',
        'external_id',
        'error_message',
        'price'
    ];
}
