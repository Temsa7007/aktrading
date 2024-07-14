<?php

use App\Enums\ReturnOrderStatus;

return [
    ReturnOrderStatus::PENDING  => 'En attente',
    ReturnOrderStatus::ACCEPT   => 'Accepté',
    ReturnOrderStatus::REJECTED => 'Rejeté',
];
