<?php

namespace App\Enums;

enum DiaSemanaEnum: string
{
    case DOMINGO = 'Domingo';
    case LUNES = 'Lunes';
    case MARTES = 'Martes';
    case MIERCOLES = 'Miércoles';
    case JUEVES = 'Jueves';
    case VIERNES = 'Viernes';
    case SABADO = 'Sábado';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
