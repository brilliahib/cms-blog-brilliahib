<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;

class AStatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $now = now();
        $lastWeek = $now->copy()->subWeek();

        $countBlogs = Blog::count();
        $countCategories = Category::count();
        $countTags = Tag::count();

        $lastWeekBlogs = Blog::where('created_at', '>=', $lastWeek)->count();
        $lastWeekCategories = Category::where('created_at', '>=', $lastWeek)->count();
        $lastWeekTags = Tag::where('created_at', '>=', $lastWeek)->count();

        $blogGrowth = $this->calculateGrowth($lastWeekBlogs, $countBlogs);
        $categoryGrowth = $this->calculateGrowth($lastWeekCategories, $countCategories);
        $tagGrowth = $this->calculateGrowth($lastWeekTags, $countTags);

        return [
            Stat::make('Total Blogs', $countBlogs)
                ->description("Up {$blogGrowth}% compared to last week")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Total Categories', $countCategories)
                ->description("Up {$categoryGrowth}% compared to last week")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Total Tags', $countTags)
                ->description("Up {$tagGrowth}% compared to last week")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
        ];
    }

    protected function calculateGrowth(int $lastWeek, int $current): int
    {
        if ($lastWeek === 0) {
            return $current > 0 ? 100 : 0;
        }

        return intval((($current - $lastWeek) / $lastWeek) * 100);
    }
}
