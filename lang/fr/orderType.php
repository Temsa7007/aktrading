<?php

use App\Enums\OrderType;

return [
    OrderType::DELIVERY => 'Livraison',
    OrderType::PICK_UP => 'Retrait',
    OrderType::POS      => 'Point de vente',
];
