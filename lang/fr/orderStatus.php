<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::PENDING    => 'En attente',
    OrderStatus::CONFIRMED  => 'Confirmé',
    OrderStatus::ON_THE_WAY => 'En route',
    OrderStatus::DELIVERED  => 'Livré',
    OrderStatus::CANCELED   => 'Annulé',
    OrderStatus::REJECTED   => 'Rejeté',
];
