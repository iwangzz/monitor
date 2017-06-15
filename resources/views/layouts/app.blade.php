<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Moca Operate Monitor</title>
    <link href="{{ elixir('css/main.css') }}" rel="stylesheet">
</head>
<body class="nav-no" style="background:#fff;">
    <div class="container body">
      <div class="main_container">
        <!-- <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <ul class="nav navbar-nav navbar-left" role="tablist" style="margin-left:22px;">
                <li role="presentation" style="padding-top:12px;margin-left:10px;"><img src="/images/logo.png"  width="130" height="30" /></li>
                <li role="presentation" style="margin-left:50px;"><a href="/">Campaigns</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->user_name }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div> -->
        
        <!-- <div class="right_col col-md-12" role="main"> -->
        <div class="" role="main">
          @yield('content')
        </div>
      <!-- </div>
    </div>

    <div class="modal fade mark-info-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="mySmallModalLabel">the reason of select</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="option-name" class="col-sm-2 control-label">Option</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="option_name" id="option-name" value="" readonly="true">
                </div>
              </div>
              <div class="form-group">
                <label for="mark-info" class="col-sm-2 control-label">Mark Info</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="mark_info" id="mark-info" placeholder="reason ...">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div> -->
      </div>
    </div>

    <script src="{{ elixir('js/main.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
    @stack('scripts')
  </body>
</html>
