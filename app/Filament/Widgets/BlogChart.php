<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BlogChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Stats';

    protected function getData(): array
    {
        $data = Trend::model(Blog::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog Count',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => \Carbon\Carbon::parse($value->date)->translatedFormat('F'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
