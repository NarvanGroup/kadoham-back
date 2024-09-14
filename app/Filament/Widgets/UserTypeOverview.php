<?php

namespace App\Filament\Widgets;

use App\Models\Api\V1\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Shetabit\Visitor\Models\Visit;

class UserTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->getUsersCount(),
            $this->getUniqueViews(),
            $this->getUserStats(),
            $this->getMostVisitedUrlStat()
            /*            Stat::make('Unique views', '192.1k')
                            ->description('32k increase')
                            ->descriptionIcon('heroicon-m-arrow-trending-up')
                            ->chart([7, 2, 10, 3, 15, 4, 17])
                            ->color('success'),
                        Stat::make('Bounce rate', '21%')
                            ->description('7% increase')
                            ->descriptionIcon('heroicon-m-arrow-trending-down')
                            ->color('danger'),
                        Stat::make('Average time on page', '3:12')
                            ->description('3% increase')
                            ->descriptionIcon('heroicon-m-arrow-trending-up')
                            ->color('success'),*/
        ];
    }

    protected function getUsersCount()
    {
        $usersCount = User::count();

        // Create the Stat card
        return Stat::make('Users count', $usersCount) // Total unique views in the last month
        ->description('Total users count')
            ->descriptionIcon('heroicon-s-user-group');
    }

    protected function getUniqueViews()
    {
        // Get the start date for the last month
        $startDate = Carbon::now()->subMonth();

        // Get unique views for each day in the last month
        $uniqueViewsData = Visit::selectRaw('DATE(created_at) as date, COUNT(DISTINCT ip, visitor_type, visitor_id) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Prepare data for the chart
        $chartData = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $chartData[$date] = $uniqueViewsData->get($date, 0); // Default to 0 if no data for that date
        }

        // Convert the chart data to a simple array for the chart
        $chartValues = array_values($chartData);
        $chartLabels = array_keys($chartData);

        // Create the Stat card
        return Stat::make('Unique views', array_sum($chartValues)) // Total unique views in the last month
        ->description('Monthly unique views')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart($chartValues) // Data for the chart
            ->color('success');
    }

    public function getUserStats()
    {
        // Get the start of the current month and the previous month
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();

        // Count users for the current month
        $currentMonthUserCount = User::where('created_at', '>=', $startOfCurrentMonth)->count();

        // Count users for the previous month
        $previousMonthUserCount = User::where('created_at', '>=', $startOfPreviousMonth)
            ->where('created_at', '<', $startOfCurrentMonth)
            ->count();

        // Determine the amount of change
        $amountChange = $currentMonthUserCount - $previousMonthUserCount;

        // Prepare the Stat card
        if ($amountChange > 0) {
            // If increasing
            return Stat::make('Users this Month', $currentMonthUserCount)
                ->description("$amountChange increased in a month")
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'); // Green color for increasing
        }

        if ($amountChange < 0) {
            // If decreasing
            return Stat::make('Users this Month', $currentMonthUserCount)
                ->description("$amountChange users decreased in a month")
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('danger'); // Red color for decreasing
        }

// If no change
        return Stat::make('Users this Month', $currentMonthUserCount)
            ->description("No change in users this month")
            ->descriptionIcon('heroicon-s-arrow-long-right')
            ->color('neutral'); // Neutral color for no change
    }

    public function getMostVisitedUrlStat()
    {
        // Query to get the top 10 most visited URLs
        $topVisitedUrls = Visit::select('url')
            ->selectRaw('COUNT(*) as visit_count')
            ->groupBy('url')
            ->orderBy('visit_count', 'desc')
            ->limit(10) // Limit to top 10 results
            ->get(); // Retrieve the results

        // Prepare the description for the Stat card
        if ($topVisitedUrls->isNotEmpty()) {
            $description = $topVisitedUrls->map(function ($item) {
                return "{$item->url} - {$item->visit_count} visits";
            })->implode('<br>'); // Join the URLs and counts with line breaks

            return Stat::make('Top 10 Most Visited URLs', '')
                ->description($description)
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'); // You can choose a color that fits your theme
        }

        return Stat::make('Top 10 Most Visited URLs', 'No visits recorded')
            ->description("No data available")
            ->color('neutral'); // Neutral color for no data
    }
}
