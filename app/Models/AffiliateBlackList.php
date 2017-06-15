<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateBlackList extends Model
{
    protected $table = 'TB_AFFILIATE_FORBID';
    protected $fillable = ['aff_id', 'aff_pub', 'ad_id', 'track', 'postback', 'remark', 'is_manual', 'deleted'];
    public $timestamps = false;

    public function getAffPublishIdAttribute($value)
    {
        return $value == 'all' ? '--' : $value;
    }

    public function getGroupIdAttribute($value)
    {
        return $value ?: '--';
    }
}
