<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'peminjamans';

    // Define the fillable attributes
    protected $fillable = [
        'name',
        'id_location',
        'condition',
        'id_user',  
        'id_barang',
    ];

    // If your table uses timestamps, you can leave these lines; otherwise, set to false
    public $timestamps = true;

    public function commodities(){
        return $this->belongsTo('App\commodities','id_barang');
    }
    public function commodity_locations(){
        return $this->belongsTo('App\commodity_locations','id_location');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user');
    }
    
}
