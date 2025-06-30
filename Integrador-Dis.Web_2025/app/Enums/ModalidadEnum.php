<?php

namespace App\Enums;

enum ModalidadEnum: string
{
    case PRESENCIAL = 'Presencial';
    case VIRTUAL = 'Virtual';
    case HIBRIDA = 'Híbrida';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
