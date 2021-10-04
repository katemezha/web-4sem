<?php

declare(strict_types=1);

namespace App\Api\Adress\Dto;

class AdressListResponseDto
{
    public array $data;

    public function __construct(AdressResponseDto ... $data)
    {
        $this->data = $data;
    }
}
