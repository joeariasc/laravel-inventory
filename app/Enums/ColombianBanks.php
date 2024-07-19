<?php

namespace App\Enums;

enum ColombianBanks: string
{
    case BANCOLOMBIA = 'BANCOLOMBIA';
    case DAVIVIENDA = 'DAVIVIENDA';
    case BANCO_DE_BOGOTA = 'BANCO_DE_BOGOTA';
    case BANCO_POPULAR = 'BANCO_POPULAR';
    case BBVA = 'BBVA';
    case COLPATRIA = 'COLPATRIA';
    case BANCO_AV_VILLAS = 'BANCO_AV_VILLAS';

    public function label(): string
    {
        return match ($this) {
            self::BANCOLOMBIA => __('Bancolombia'),
            self::DAVIVIENDA => __('Davivienda'),
            self::BANCO_DE_BOGOTA => __('Banco de Bogotá'),
            self::BANCO_POPULAR => __('Banco Popular'),
            self::BBVA => __('BBVA'),
            self::COLPATRIA => __('Colpatria'),
            self::BANCO_AV_VILLAS => __('Banco AV Villas'),
        };
    }
}
