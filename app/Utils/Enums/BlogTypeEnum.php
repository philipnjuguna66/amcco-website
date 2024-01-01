<?php

namespace App\Utils\Enums;

enum BlogTypeEnum: string
{
    case POST = 'post';

    case UPDATES = 'Updates';

    public function getLabel() : string
    {
        return  match ($this)
        {
            self::POST => "Blogs",
            self::UPDATES => "Updates",
        };
    }
}
