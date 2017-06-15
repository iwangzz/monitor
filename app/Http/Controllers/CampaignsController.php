<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Campaign;
use App\Models\CampaignPhase;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryBuilder = Campaign::where('master_id', \Auth::user()->id);
        if ($request->has('s')) {
            $value = trim($request->input('s'));
            is_numeric($value) ? $queryBuilder->where('id', 'like', '%' . $value . '%') : $queryBuilder->where('name', 'like', '%' . $value . '%');
        }
        $campaigns = $queryBuilder
        ->with(['phases' => function ($query) {
            $query->where('phase_id', '=', 'phase_id');
        }])
        ->paginate(15);

        $request->flash();

        return view('campaigns.index')
            ->withCampaigns($campaigns)
            ->withStatus(Campaign::$status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $opt = 'kpi')
    {
        $blockTracks = $automate = [];
        foreach (\App\Models\AffiliateBlackList::select('aff_id', 'aff_pub', 'automate')->where(['ad_id' => $id, 'track' => 1])->get() as $list) {
            if (!isset($blockTracks[$list->aff_id])) {
                $blockTracks[$list->aff_id] = [];
                $blockTracks[$list->aff_id][] = $list->aff_pub;
            } else {
                $blockTracks[$list->aff_id][] = $list->aff_pub;
            }

            if ($list->automate == 0) {
                if (!isset($automate[$list->aff_id])) {
                    $automate[$list->aff_id] = [];
                    $automate[$list->aff_id][] = $list->aff_pub;
                } else {
                    $automate[$list->aff_id][] = $list->aff_pub;
                }
            }
        }

        $campaign = Campaign::findOrFail($id);
        if($campaign) {
            return view('campaigns.campaign-detail')
                ->with([
                    'campaign' => $campaign,
                    'opt' => $opt,
                    'timezones' => \App\Setting::$timezones,
                    'promoType' => Campaign::$promoType,
                    'flag' => $request->has('f') ? $request->input('f') : 'aff_pub',
                    'blockTracks' => $blockTracks,
                    'automate' => $automate
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * switch the options & mark the reason.
     *
     * @param  int  $opt
     * @param  string  $info
     * @return \Illuminate\Http\Response
     */
    public function switchOptions($opt, $info = '')
    {
        
    }

    /**
     * switch the options & mark the reason.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBlacklist(Request $request) {
        // $campaign = Campaign::findOrFail($request->input('offer_id'));
        // $campaignPhase = $campaign->phases()->where('phase_id', $campaign->phase_id)->first();
        // if ($campaignPhase->end_time > 0 && $campaignPhase->end_time < $request->server('REQUEST_TIME')) {
        //     $endDate = date('Y-m-d', $campaignPhase->end_time);
        // } else {
        //     $endDate = date('Y-m-d', $request->server('REQUEST_TIME'));
        // }

        $conditions = array_merge([
            'flag' => 'aff_pub',
            'level' => 2,
            'event' => 2,
            'days' => '1,2,7,30',
            // 'end_date' => $endDate
        ], [
            'offer_id' => 102580,
            'flag' => $request->input('flag'),
            'level' => $request->input('level'),
            'event' => 2,
            'days' => '1,2,7,30',
            'end_date' => '2017-05-24'
        ]);

        $data = \ApiData::getBlacklist(config('moca.api.blacklist'), $conditions);

        return response()->json(json_encode($data));
    }

    /**
     * block  tracks
     *
     * @return \Illuminate\Http\Response
     */
    public function dragInto(Request $request) {
        $blockTracks = $automate = [];
        \App\Models\AffiliateBlackList::updateOrCreate([
            'ad_id' => $request->input('ad_id'),
            'aff_id' => $request->input('aff_id'),
            'aff_pub' => $request->input('aff_pub')
        ], [
            'track' => $request->input('track'),
            'automate' => $request->input('automate')
        ]);

        if ($request->input('track') == 1 && $request->input('aff_pub') == 'all') {
            \App\Models\AffiliateBlackList::where([
                'ad_id' => $request->input('ad_id'),
                'aff_id' => $request->input('aff_id'),
            ])->update([
                'track' => 1,
                'automate' => $request->input('automate')
            ]); 
        }

        foreach (\App\Models\AffiliateBlackList::select('aff_id', 'aff_pub', 'automate')->where(['ad_id' => $request->input('ad_id'), 'track' => 1])->get() as $list) {
            if (!isset($blockTracks[$list->aff_id])) {
                $blockTracks[$list->aff_id] = [];
                $blockTracks[$list->aff_id][] = $list->aff_pub;
            } else {
                $blockTracks[$list->aff_id][] = $list->aff_pub;
            }

            if ($list->automate == 0) {
                if (!isset($automate[$list->aff_id])) {
                    $automate[$list->aff_id] = [];
                    $automate[$list->aff_id][] = $list->aff_pub;
                } else {
                    $automate[$list->aff_id][] = $list->aff_pub;
                }
            }
        }

        return response()->json([
            'code' => 200,
            'msg' => 'success',
            'blockTracks' => $blockTracks,
            'automate' => $automate
        ]);
    }
}
