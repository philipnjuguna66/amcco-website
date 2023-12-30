<?php

namespace App\Utils\Enums;

enum ProjectStatusEnum: string
{
    case FOR_SALE = 'For Sale';

    case SOLD_OUT = 'Sold Out';
    case DRAFT = 'draft';
}
