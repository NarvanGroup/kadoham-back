<?php

namespace Modules\Payment\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Payment\App\Enums\Novinpal\IpgPortEnum;
use Modules\Payment\App\Enums\Novinpal\IpgStatusEnum;

class IpgTransaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'ipg_transactions';

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $casts = [
        'ports' => IpgPortEnum::class,
        'status' => IpgStatusEnum::class,
    ];

}
