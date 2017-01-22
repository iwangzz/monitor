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
        $campaign = Campaign::findOrFail($id);
        if($campaign) {
            return view('campaigns.campaign-detail')
                ->withCampaign($campaign)
                ->withOpt($opt);
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
}
