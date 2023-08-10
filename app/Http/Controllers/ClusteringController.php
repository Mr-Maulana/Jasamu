<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Review;
use App\Models\DailyReport;
use Illuminate\Support\Facades\DB;

class ClusteringController extends Controller
{
    public function clusterServices()
    {
        $services = Service::select('id', 'name', 'category')
            ->withCount('reviews')
            ->get();

        $serviceReviews = Review::select('service_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('service_id')
            ->get();

        $interactions = DailyReport::select('service_id', DB::raw('SUM(interactions) as total_interactions'))
            ->groupBy('service_id')
            ->get();

        $minInteractions = $interactions->min('total_interactions');
        $maxInteractions = $interactions->max('total_interactions');

        $normalizedServices = [];
        foreach ($services as $service) {
            $averageRating = $serviceReviews->where('service_id', $service->id)->first()->average_rating ?? 0;

            $interactionData = $interactions->where('service_id', $service->id)->first();
            $normalizedInteractions = $interactionData
                ? ($interactionData->total_interactions - $minInteractions) / ($maxInteractions - $minInteractions)
                : 0;

            $normalizedServices[] = [
                'id' => $service->id,
                'name' => $service->name,
                'category' => $service->category,
                'normalized_rating' => $averageRating,
                'normalized_interactions' => $normalizedInteractions,
            ];
        }

        $categoryStats = [];

        foreach ($normalizedServices as $service) {
            $category = $service['category'];
            $rating = $service['normalized_rating'];
            $interactions = $service['normalized_interactions'];

            if (!isset($categoryStats[$category])) {
                $categoryStats[$category] = [
                    'total_rating' => 0,
                    'total_interactions' => 0,
                    'num_services' => 0,
                ];
            }

            $categoryStats[$category]['total_rating'] += $rating;
            $categoryStats[$category]['total_interactions'] += $interactions;
            $categoryStats[$category]['num_services']++;
        }

        foreach ($categoryStats as $category => $stats) {
            $averageRating = $stats['total_rating'] / $stats['num_services'];
            $averageInteractions = $stats['total_interactions'] / $stats['num_services'];

            $categoryStats[$category]['average_rating'] = $averageRating;
            $categoryStats[$category]['average_interactions'] = $averageInteractions;
        }

        $mostPopular = [];
        $popular = [];
        $lessPopular = [];
        $leastPopular = [];

        foreach ($categoryStats as $category => $stats) {
            $averageRating = $stats['average_rating'];
            $averageInteractions = $stats['average_interactions'];

            if ($averageRating >= 0.8 && $averageInteractions >= 1.0) {
                $mostPopular[] = $category;
            } elseif ($averageRating >= 0.5 && $averageInteractions >= 0.7) {
                $popular[] = $category;
            } elseif ($averageRating >= 0.1 && $averageInteractions >= 0.4) {
                $lessPopular[] = $category;
            } else {
                $leastPopular[] = $category;
            }
        }

        return view('clustered-services', [
            'services' => $normalizedServices,
            'mostPopularCategories' => $mostPopular,
            'popularCategories' => $popular,
            'lessPopularCategories' => $lessPopular,
            'leastPopularCategories' => $leastPopular,
        ]);
    }
}
