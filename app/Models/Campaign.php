<?php

namespace App\Models;

use App\Moca\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $connection = 'adv';

    public $timestamps = false;

    protected $table = 'PROJECT_ADV';

    public function phases() {
        return $this->hasMany('\App\Models\CampaignPhase', 'offer_id');
    }

    public function inProressPhase() {
        //return $this->hasMany('App/Models/CampaignPhase', 'project_id');
    }

    public static $status = [
        'Saved',
        'Locked',
        8 => 'Run',
       'Done' 
    ];

    public static $promoType = [
        'CPA' => 'CPA: Cost Per Action', 
        'CPI' => 'CPI: Cost Per Install',
        'CPC' => 'CPC: Cost Per Click',
        'CPV' => 'CPV: Cost Per Visit',
        'CPM' => 'CPM: Cost Per Mile',
        'CPS' => 'CPS: Cost Per Sale',
        'CPL' => 'CPL: Cost Per Lead',
        'PPC' => 'PPC: Pay Per Call',
        'SUB' => 'Subscription',
    ];

}
