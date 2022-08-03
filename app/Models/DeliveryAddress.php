<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryAddress extends Model
{
    use HasFactory;

    public static function deliveryAddresses(){
        $user_id = Auth::user()->id;
        $deliveryAdrresses = DeliveryAddress::where('user_id', $user_id)->get();
        return $deliveryAdrresses;
    }
}
