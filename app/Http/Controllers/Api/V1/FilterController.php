<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Filter\FilterResource;
use App\Models\Api\V1\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::all();
        return FilterResource::collection($filters);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Filter $filter)
    {
        return new FilterResource($filter);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filter $filter)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filter $filter)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filter $filter)
    {
        abort(403);
    }
}
