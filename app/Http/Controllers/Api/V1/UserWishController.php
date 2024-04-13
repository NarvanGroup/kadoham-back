<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\UniqueCodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WishLists\StoreWishListRequest;
use App\Http\Resources\Api\V1\WishList\WishListResource;
use App\Models\Api\v1\UserWish;
use Illuminate\Http\Request;

class UserWishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserWish $userWish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserWish $userWish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserWish $userWish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserWish $userWish)
    {
        //
    }
}
