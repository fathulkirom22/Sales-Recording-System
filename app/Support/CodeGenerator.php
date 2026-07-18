<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CodeGenerator
{
    /**
     * Generate a sequential document code, e.g. SALE-20260717-0001.
     *
     * @param  class-string<Model>  $model
     */
    public static function next(string $model, string $prefix, string $column = 'code'): string
    {
        $date = now()->format('Ymd');
        $base = sprintf('%s-%s-', Str::upper($prefix), $date);

        $latest = $model::query()
            ->where($column, 'like', $base.'%')
            ->orderByDesc($column)
            ->value($column);

        $sequence = 1;

        if ($latest && preg_match('/(\d+)$/', $latest, $matches)) {
            $sequence = (int) $matches[1] + 1;
        }

        return $base.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
