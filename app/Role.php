<?php

namespace App;

enum Role : string
{
   case Owner = 'owner';
   case Staff = 'staff';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
   
}
