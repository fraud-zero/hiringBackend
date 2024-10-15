<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlacementRequest;
use App\Models\Placement;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PlacementResource;

/**
 * @group Placement endpoints
 */
class PlacementController extends Controller
{
    /**
     * Display a listing of placements.
     *
     * @bodyParam sort_by string Field to sort by. Possible values: key, platform, total, invalid_total, invalid_total_percent, pixel_stuffing, pixel_stuffing_percent, viewable, viewable_percent, non_viewable, non_viewable_percent, mfa_site_symptoms, mfa_site_symptoms_percent, other_invalid, other_invalid_percent. Example: total
     * @bodyParam sort_order string Sort order. Possible values: asc, desc. Example: desc
     * @bodyParam per_page integer Number of results per page. Example: 10
     * @bodyParam page integer Page number. Example: 1
     * @bodyParam paginate boolean Whether to paginate results. Default value: true. Example: true
     * @bodyParam key string Optional. Filter by key (case-insensitive). Example: ""
     * @bodyParam platform string Optional. Filter by platform. Possible values: ["","app", "web"]. Example: ""
     * @bodyParam min_total integer Optional. Filter placements with total greater than or equal to this value. Example: ""
     * @bodyParam min_invalid_total integer Optional. Filter placements with invalid_total greater than or equal to this value. Example: ""
     *
     * @param PlacementRequest $request
     *
     * @return JsonResponse
     */
    public function index(PlacementRequest $request): JsonResponse
    {
        $slice = 'placement';

        // Get validated parameters with defaults
        $sortBy = $request->input('sort_by', 'total');
        $sortOrder = $request->input('sort_order', 'desc');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $paginate = $request->input('paginate', true);

        // Build the query with sorting
        $query = Placement::orderBy($sortBy, $sortOrder);

        // Retrieve filters
        $filters = $request->only(['key', 'platform', 'min_total', 'min_invalid_total']);

        // Apply filters
        if (!empty($filters['key'])) {
            $key = strtolower($filters['key']);
            $column = $query->getQuery()->getGrammar()->wrap('key');
            $query->whereRaw("LOWER($column) = ?", [$key]);
        }

        if (!empty($filters['platform'])) {
            $query->where('platform', $filters['platform']);
        }


        if (isset($filters['min_total']) && !is_null($filters['min_total'])) {
            $query->where('total', '>=', $filters['min_total']);
        }

        if (isset($filters['min_invalid_total']) && !is_null($filters['min_invalid_total'])) {
            $query->where('invalid_total', '>=', $filters['min_invalid_total']);
        }

        if ($paginate) {
            $placements = $query->paginate($perPage, ['*'], 'page', $page);

            $data = $placements->items();

            $formattedData = PlacementResource::collection($data)->toArray($request);

            $response = [
                'slice' => $slice,
                'data' => $formattedData,
                'pagination' => [
                    'total_hits' => $placements->total(),
                    'per_page' => $placements->perPage(),
                    'current_page' => $placements->currentPage(),
                    'total_pages' => $placements->lastPage(),
                ],
            ];
        } else {
            // Get all results without pagination
            $placements = $query->get();

            $formattedData = PlacementResource::collection($placements)->toArray($request);

            $response = [
                'slice' => $slice,
                'data' => $formattedData,
                'pagination' => null,
            ];
        }

        return response()->json($response);
    }
}
