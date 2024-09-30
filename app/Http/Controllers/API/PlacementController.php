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
