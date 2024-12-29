<?php

namespace App\Service;

class PromoCodeGeneratorService
{
    public function generate()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($characters), 0, 6);
    }
}
