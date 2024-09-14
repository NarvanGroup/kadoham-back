<?php

namespace App\Providers;

use Filament\Tables\Columns\Column;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Column::configureUsing(static function (Column $column): void {
            $column
                ->sortable()
                ->toggleable()
                ->searchable();
        });
    }
}
