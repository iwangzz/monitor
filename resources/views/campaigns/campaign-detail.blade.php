@extends('layouts.app')

@section('content')
<?php
  $now = time();
?>
<div class="raw page-title">
  <div class="col-md-12 title_left">
    <h3>Campaign Detail</h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ $campaign->project_name }}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-9 col-sm-9 col-xs-12 text-center">

          <ul class="stats-overview">
            <li>
              <a href="/campaigns/{{ $campaign->id }}/kpi">
                <span class="name">Key Performance Indicator</span>
                <span class="value text-success" @if($opt == 'kpi') style="color: #e74c3c;" @endif> 2300 </span>
              </a>
            </li>
            <li>
              <a href="/campaigns/{{ $campaign->id }}/invalid-conversion">
                <span class="name"> Invalid Conversion </span>
                <span class="value text-success" @if($opt == 'invalid-conversion') style="color: #e74c3c;" @endif> 2000 </span>
              </a>
            </li>
          </ul>
          <br />

          <div id="mainb" style="height:350px;"></div>

          <br />
          <br />
        </div>
        <!-- start project-detail sidebar -->
        <div class="col-md-3 col-sm-3 col-xs-12">

          <section class="panel">

            <div class="x_title">
              <h2>Campaign Contents</h2>
              <div class="clearfix"></div>
            </div>
            <div class="panel-body">
              <h3>@if ($campaign->content_image) <img src="{{$campaign->content_image}}" class="media-object campaign-thumbnail" /> @else <img src="/images/logo.png" class="media-object campaign-thumbnail" /> @endif </h3>
              <h3 class="green">{{ $campaign->name }}</h3>

              <br />
              <ul class="list-unstyled project_files">
                <li><b>Campaign ID</b>: {{ $campaign->id }}</b>
                </li>
                <li><b>Campaign Name</b>: {{ $campaign->name }}
                </li>
                <li><b>Timezone</b>: {{ $campaign->time_zone != '' ? $timezones[$campaign->time_zone] : '--' }}
                </li>
                <li><b>Pricing Model</b>: {{ $campaign->promo_type ? $promoType[$campaign->promo_type] : '--' }}
                </li>
                <li><b>Valid duration from click to install</b>: {{ (int)($campaign->valid_duration / 86400) }} days, {{ $campaign->valid_duration / 360 % 240 / 10 }} hours</li>
                <li><b>Created At</b>: {{ date('Y-m-d H:i:s', $campaign->create_time) }}
                </li>
              </ul>
            </div>

          </section>
        </div>
        <div class="col-sm-12">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" @if($opt == 'kpi') class="active" @endif>
                  <a href="/campaigns/{{ $campaign->id }}/kpi">Key Performance Indicator</a>
              </li>
              <li role="presentation" @if($opt == 'invalid-conversion') class="active" @endif>
                  <a href="/campaigns/{{ $campaign->id }}/invalid-conversion">Invalid Conversion </a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                  <div id="datatable-select"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script src="{{ elixir('js/components/datatable-select.js') }}"></script>
<script>
$(function() {
    $.ajaxSetup({
      'headers': {
        'ticket': 'eyJpdiI6IlwvS1ZMNTJOWitSeXhpRnhISlpHcWlRPT0iLCJ2YWx1ZSI6IkszbGNKU1MzTE5LQTEzWGd4Tll1ZW9QZ0pEc2p2MmdVakF4UHFGZmhLQnhpdWZDSTB4K2Vmb2h0VXRNWVpsTk5FZUViVHYrREVqZ2VwRnZFNExGd3pBPT0iLCJtYWMiOiIzZDZhODMyMjYzYzZkMmJlYjhjNzg5ZWEzYmY0Njk3YzM2MGE1ZmU4MWU3Y2EzYWVlOWU0MTI1NzRlNjE5NGRlIn0',
      }
    })
    showTableHtml('{{ $opt }}');
    var html = '<div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-bottom: 20px;">' + 
              '<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>' +
              '<span>December 30, 2014 - January 28, 2016</span> <b class="caret"></b>' +
              '<input type="hidden" value="{{ date('Y-m-d', $now-86400*6) }}" id="start-date">' +
              '<input type="hidden" value="{{ date('Y-m-d', $now) }}" id="end-date">' +
            '</div>';
    $('.date-picker').html(html);
    var cb = function(start, end, label) {
      $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      $('#start-date').val(start.format('YYYY-MM-DD'));
      $('#end-date').val(end.format('YYYY-MM-DD'));
      detailTable.api().ajax.reload()
    };
    var option = {
      startDate: moment().subtract(6, 'days'),
      endDate: moment(),
      // minDate: '01/01/2012',
      // maxDate: '12/31/2015',
      dateLimit: {
        days: 60
      },
      showDropdowns: true,
      showWeekNumbers: true,
      timePicker: false,
      timePickerIncrement: 1,
      timePicker12Hour: true,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      // opens: 'left',
      opens: 'right',
      buttonClasses: ['btn btn-default'],
      applyClass: 'btn-small btn-primary',
      cancelClass: 'btn-small',
      format: 'MM/DD/YYYY',
      separator: ' to ',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Clear',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
      }
    };
    $('#reportrange_right span').html(moment().subtract(6, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange_right').daterangepicker(option, cb);
    
    var theme = {
          color: [
              '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
              '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
              itemGap: 8,
              textStyle: {
                  fontWeight: 'normal',
                  color: '#408829'
              }
          },

          dataRange: {
              color: ['#1f610a', '#97b58d']
          },

          toolbox: {
              color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
              backgroundColor: 'rgba(0,0,0,0.5)',
              axisPointer: {
                  type: 'line',
                  lineStyle: {
                      color: '#408829',
                      type: 'dashed'
                  },
                  crossStyle: {
                      color: '#408829'
                  },
                  shadowStyle: {
                      color: 'rgba(200,200,200,0.3)'
                  }
              }
          },

          dataZoom: {
              dataBackgroundColor: '#eee',
              fillerColor: 'rgba(64,136,41,0.2)',
              handleColor: '#408829'
          },
          grid: {
              borderWidth: 0
          },

          categoryAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },

          valueAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitArea: {
                  show: true,
                  areaStyle: {
                      color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },
          timeline: {
              lineStyle: {
                  color: '#408829'
              },
              controlStyle: {
                  normal: {color: '#408829'},
                  emphasis: {color: '#408829'}
              }
          },

          k: {
              itemStyle: {
                  normal: {
                      color: '#68a54a',
                      color0: '#a9cba2',
                      lineStyle: {
                          width: 1,
                          color: '#408829',
                          color0: '#86b379'
                      }
                  }
              }
          },
          map: {
              itemStyle: {
                  normal: {
                      areaStyle: {
                          color: '#ddd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  },
                  emphasis: {
                      areaStyle: {
                          color: '#99d2dd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  }
              }
          },
          force: {
              itemStyle: {
                  normal: {
                      linkStyle: {
                          strokeColor: '#408829'
                      }
                  }
              }
          },
          chord: {
              padding: 4,
              itemStyle: {
                  normal: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  },
                  emphasis: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  }
              }
          },
          gauge: {
              startAngle: 225,
              endAngle: -45,
              axisLine: {
                  show: true,
                  lineStyle: {
                      color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                      width: 8
                  }
              },
              axisTick: {
                  splitNumber: 10,
                  length: 12,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              axisLabel: {
                  textStyle: {
                      color: 'auto'
                  }
              },
              splitLine: {
                  length: 18,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              pointer: {
                  length: '90%',
                  color: 'auto'
              },
              title: {
                  textStyle: {
                      color: '#333'
                  }
              },
              detail: {
                  textStyle: {
                      color: 'auto'
                  }
              }
          },
          textStyle: {
              fontFamily: 'Arial, Verdana, sans-serif'
          }
    };
    var echartBarLine = echarts.init(document.getElementById('mainb'), theme);
    echartBarLine.setOption({
      title: {
        x: 'center',
        y: 'top',
        padding: [0, 0, 20, 0],
        text: 'Project Perfomance :: Revenue vs Input vs Time Spent',
        textStyle: {
          fontSize: 15,
          fontWeight: 'normal'
        }
      },
      tooltip: {
        trigger: 'axis'
      },
      toolbox: {
        show: true,
        feature: {
          dataView: {
            show: true,
            readOnly: false,
            title: "Text View",
            lang: [
              "Text View",
              "Close",
              "Refresh",
            ],
          },
          restore: {
            show: true,
            title: 'Restore'
          },
          saveAsImage: {
            show: true,
            title: 'Save'
          }
        }
      },
      calculable: true,
      legend: {
        data: ['Revenue', 'Cash Input', 'Time Spent'],
        y: 'bottom'
      },
      xAxis: [{
        type: 'category',
        data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      }],
      yAxis: [{
        type: 'value',
        name: 'Amount',
        axisLabel: {
          formatter: '{value} ml'
        }
      }, {
        type: 'value',
        name: 'Hours',
        axisLabel: {
          formatter: '{value} h'
        }
      }],
      series: [{
        name: 'Revenue',
        type: 'bar',
        data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
      }, {
        name: 'Cash Input',
        type: 'bar',
        data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
      }, {
        name: 'Time Spent',
        type: 'line',
        yAxisIndex: 1,
        data: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
      }]
    });

  // 异步加载数据
  // $.get('data.json').done(function (data) {
      // 填入数据
      // myChart.setOption({
      //     xAxis: {
      //         data: data.categories
      //     },
      //     series: [{
      //         // 根据名字对应到相应的系列
      //         name: '销量',
      //         data: data.data
      //     }]
      // });
  // });

})
</script>
@endpush
