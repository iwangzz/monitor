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

        // $conditions = array_merge([
        //     'flag' => 'aff_pub',
        //     'level' => 2,
        //     'event' => 3,
        //     'days' => '1,2,7,30',
        //     // 'end_date' => $endDate
        // ], [
        //     'offer_id' => 102580,
        //     'flag' => 'aff_pub',
        //     'level' => 3,
        //     'event' => 3,
        //     'days' => '1,2,7,30',
        //     'end_date' => '2017-05-24'
        // ]);

        // dd(\ApiData::getBlacklist(config('moca.api.blacklist'), $conditions));


        $campaign = Campaign::findOrFail($id);
        if($campaign) {
            return view('campaigns.campaign-detail')
                ->with([
                    'campaign' => $campaign,
                    'opt' => $opt,
                    'timezones' => \App\Setting::$timezones,
                    'promoType' => Campaign::$promoType,
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
            'event' => 3,
            'days' => '1,2,7,30',
            // 'end_date' => $endDate
        ], [
            'offer_id' => 102580,
            'flag' => 'aff_pub',
            'level' => 3,
            'event' => 3,
            'days' => '1,2,7,30',
            'end_date' => '2017-05-24'
        ]);

        // \Log::info(json_encode(\ApiData::getBlacklist(config('moca.api.blacklist'), $conditions)));

        $data = \ApiData::getBlacklist(config('moca.api.blacklist'), $conditions);

        // $data = [
        //     'status' => 200,
        //     'result' => [
        //         'total' => [
        //             1 => [
        //                 'click' => 10000,
        //                 'unique_click' => 5000,
        //                 'conversion' => 108,
        //                 'cvr' => 10,
        //             ],
        //             2 => [
        //                 'click' => 10000,
        //                 'unique_click' => 4829,
        //                 'conversion' => 2302,
        //                 'cvr' => 10,
        //             ],
        //             7 => [
        //                 'click' => 10000,
        //                 'unique_click' => 500,
        //                 'conversion' => 200,
        //                 'cvr' => 10,
        //             ],
        //             31 => [
        //                 'click' => 10000,
        //                 'unique_click' => 3278,
        //                 'conversion' => 162,
        //                 'cvr' => 10,
        //             ]

        //         ],
        //         'data' => [
        //             10001 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10001_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10002 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 78,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10002_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10003 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10004 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10005 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10006 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10007 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10008 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //             10009 => [
        //                 'total' => [
        //                     1 => [
        //                         'click' => 60,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     2 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     7 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ],
        //                     31 => [
        //                         'click' => 100,
        //                         'unique_click' => 50,
        //                         'conversion' => 20,
        //                         'cvr' => 10,
        //                     ]
        //                 ],
        //                 'data' => [
        //                     '10003_xxx' => [
        //                         'total' => [
        //                             1 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             2 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             7 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ],
        //                             31 => [
        //                                 'click' => 100,
        //                                 'unique_click' => 50,
        //                                 'conversion' => 20,
        //                                 'cvr' => 10,
        //                             ]
        //                         ],
        //                         'data' => [
        //                             '103352' => [
        //                                 1 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 2 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 7 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ],
        //                                 31 => [
        //                                     'click' => 100,
        //                                     'unique_click' => 50,
        //                                     'conversion' => 20,
        //                                     'cvr' => 10,
        //                                 ]
        //                             ]
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //         ]
        //     ] 
        // ];

        return response()->json(json_encode($data));
    }
}
