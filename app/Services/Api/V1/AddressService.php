<?php

namespace App\Services\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use SaliBhdr\TyphoonIranCities\Models\IranCity;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;

class AddressService extends Controller
{
    use ResponderTrait;

    public function __construct(protected readonly IranProvince $province, protected readonly IranCity $city)
    {
    }

    public function getAllProvinces(): JsonResponse
    {
        $provinces = $this->province::getAll()->map(static function ($province) {
            return [
                'id' => $province->id,
                'name' => $province->name
            ];
        });

        return $this->responseShow($provinces);
    }

    public function getCities(int $provinceId): JsonResponse
    {
        $cities = $this->province->findOrFail($provinceId)->cities->map(static function ($province) {
            return [
                'id' => $province->id,
                'name' => $province->name
            ];
        });
        return $this->responseShow($cities);
    }
}
