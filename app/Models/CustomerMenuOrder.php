<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMenuOrder extends Model
{
    use HasFactory;


    protected $table = 'customer_menu_order';

    protected $fillable = [
        'menu_id',
        'customer_id',
    ];


    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

}
