<?php

namespace App\Filament\Resources\VendaResource\Widgets;

use App\Models\Venda;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class VendasMesChart extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getHeading(): string
    {
        return 'Vendas Mensal';
    }

    protected function getData(): array
    {
        $data = Trend::model(Venda::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->sum('valor_total');

        return [
            'datasets' => [
                [
                    'label' => 'Vendas Mensal',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
