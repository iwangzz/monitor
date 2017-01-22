<?php

namespace App\Models;

use App\Moca\Database\Eloquent\Model;

class CampaignPhase extends Model
{
    protected $connection = 'adv';

    public $timestamps = false;

    protected $table = 'PROJECT_ADV_PHASE';

    public function campaign() {
        return $this->belongsTo('\App\Models\Campaign', 'offer_id');
    } 

}
