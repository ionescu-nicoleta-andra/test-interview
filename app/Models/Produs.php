<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produs extends Model
{

    public $table='produse';
    public $primaryKey  = 'sku';

    public $fillable = [
        'nume',
        'url_imagine',
        'categorie',
        'ean',
        'sku',
        'pret_fara_tva',
        'stoc',
        'brand',
        'descriere',
        'atribute_produs',
        'pret_pj_1',

        'new',
        'price_update',
        'stock_update'];

}
