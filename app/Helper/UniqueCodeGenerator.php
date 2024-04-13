<?php

namespace App\Helper;

use Illuminate\Database\Eloquent\Model;

class UniqueCodeGenerator
{
    public const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public static function generateCode(int $codeLength = 4): string
    {
        $charactersLength = strlen(self::CHARACTERS);

        $code = '';
        for ($i = 0; $i < $codeLength; $i++) {
            $code .= self::CHARACTERS[random_int(0, $charactersLength - 1)];
        }

        return $code;
    }

    public static function generateUniqueCode(Model $model, string $column, int $codeLength = 4): string
    {
        $charactersLength = strlen(self::CHARACTERS);

        do {
            $code = '';
            for ($i = 0; $i < $codeLength; $i++) {
                $code .= self::CHARACTERS[random_int(0, $charactersLength - 1)];
            }
        } while (self::codeExists($model, $column, $code));

        return $code;
    }

    private static function codeExists(Model $model, string $column, string $code): bool
    {
        return $model->where($column, $code)->exists();
    }
}
