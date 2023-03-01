<?php

namespace App\Filament\Resources\CompraResource\Widgets;

use App\Models\Compra;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ComprasMesChart extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getHeading(): string
    {
        return 'Compras Mensal';
    }

    protected function getData(): array
    {
        $data = Trend::model(Compra::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->sum('valor_total');

        return [
            'datasets' => [
                [
                    'label' => 'Compras Mensal',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
