@extends('layouts.app')

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Campaigns</h3>
  </div>

  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
    <form method="GET" action="{{ url('/campaigns') }}">
      <div class="input-group">
        <input type="text" name="s" value="{{ old('s') }}" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit">Go!</button>
        </span>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Campaigns</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <!-- start project list -->
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 20%">Campaign</th>
              <th>Advertising Cycle</th>
              <th>Project Progress</th>
              <th>Status</th>
              <th style="width: 20%">#Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($campaigns as $campaign)
            <tr>
              <td>#</td>
              <td>
                <a href="/campaigns/{{ $campaign->id }}">{{ $campaign->project_name }}</a>
                <br />
                <small>Created {{ date('d.m.Y', $campaign->create_time) }}</small>
              </td>
              <td>
                  {{ date('Y/m/d', $campaign->phases[0]->start_time) . ' - ' . ($campaign->phases[0]->end_time > 0 ? date('Y/m/d', $campaign->phases[0]->end_time) : 'TBC') }}
              </td>
              <td class="project_progress">
                
                <?php  $percent = $campaign->phases[0]->total_cap > 0 ? round($campaign->phases[0]->finish_sum*100/$campaign->phases[0]->total_cap, 1) : 'Unlimit'; ?>
                <div class="progress progress_sm">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $percent }}"  aria-valuenow="{{ $percent }}"></div>
                </div>
                <small>{{ is_numeric($percent) ? $percent . '% Complete' : $percent }}</small>
              </td>
              <td>
                <button type="button" class="btn btn-{{ $campaign->project_status == 1 ? 'info' : ($campaign->project_status == 8 ? 'primary' : 'success') }} btn-xs">
                    {{ isset($status[$campaign->project_status]) ? $status[$campaign->project_status] : $campaign->project_status }}
                </button>
              </td>
              <td>
                <a href="/campaigns/{{ $campaign->id }}" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <!-- end project list -->
        {!! $campaigns->render() !!}
      </div>
    </div>
  </div>
</div>
@endsection
