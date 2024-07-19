<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;

    case ASSEMBLER = 2;

    case OPERATOR = 3;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('Admin'),
            self::ASSEMBLER => __('Assembler'),
            self::OPERATOR => __('Operator'),
        };
    }
}
