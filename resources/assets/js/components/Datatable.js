import React, { Component } from 'react'
import { render } from 'react-dom'

class ChildNode extends Component {
    constructor(props) {
        super(props)
    }

    render() {
        const { mapData, level, tableName, affId, expand }  = this.props
        let thead = [],  tbody = [],  tfoot = [], th1 = [], th2 = [], tfdata = [], colLength = 2,
            thBase = [
            <th style={{whiteSpace:'nowrap'}}>Gross Click</th>,
            <th style={{whiteSpace:'nowrap'}}>Unique Click</th>,
            <th>Conversion</th>,
            <th style={{whiteSpace:'nowrap'}}>Invalid Conversion</th>,
            <th style={{whiteSpace:'nowrap'}}>Invalid Percent</th>,
            <th>CVR</th>,
            <th>KPI</th>,
        ];

        for (var i in mapData.total) {
            th2.push(thBase);
            colLength += 7;
            tfdata.push(<td>{mapData.total[i]['gross_click']}</td>)
            tfdata.push(<td>{mapData.total[i]['unique_click']}</td>)
            tfdata.push(<td>{mapData.total[i]['conversion']}</td>)
            tfdata.push(<td>{mapData.total[i]['invalid_conversion']}</td>)
            tfdata.push(<td>{mapData.total[i]['total_conversion'] > 0 ? (mapData.total[i]['invalid_conversion']*100/mapData.total[i]['total_conversion']).toFixed(2) : 0.00}%</td>)
            tfdata.push(<td>{mapData.total[i]['gross_click'] > 0 ? (mapData.total[i]['conversion']*100/mapData.total[i]['gross_click']).toFixed(2) : 0.00}%</td>)
            tfdata.push(<td>{mapData.total[i]['major'] > 0 ? (mapData.total[i]['conversion']*100/mapData.total[i]['conversion']).toFixed(2) : 0.00}%</td>)
            
            switch(i) {
                case '1':
                    th1.push(<th colSpan="7" className="text-center">Today</th>);
                    break;
                default:
                    th1.push(<th colSpan="7" className="text-center">Last {i} days</th>);
            }
        }
        thead.push(
            <thead>
                <tr>
                    <th rowSpan="2" className="th-first text-center"  style={{whiteSpace:'nowrap'}}>{level == 1 ? 'Affiliate ID' : (level == 2 ? 'Aff-Publisher ID' : 'Group') }</th>
                    {th1}
                    <th></th>
                </tr>
                <tr>
                    {th2}
                    <th width="10%">Status</th>
                </tr>
            </thead>
        )
        tfoot.push(
            <tfoot>
                <tr>
                    <td className="text-center">Total</td>
                    {tfdata}
                    <td></td>
                </tr>
            </tfoot>
        )

        for (var i in mapData.data) {
            let curData = mapData.data[i], tdata = [];
            let totalData = curData.hasOwnProperty('total') ? curData.total : curData;
            for (var k in totalData) {
                tdata.push(<td>{totalData[k]['gross_click']}</td>)
                tdata.push(<td>{totalData[k]['unique_click']}</td>)
                tdata.push(<td>{totalData[k]['conversion']}</td>)
                tdata.push(<td>{totalData[k]['invalid_conversion']}</td>)
                tdata.push(<td>{totalData[k]['total_conversion'] > 0 ? (totalData[k]['invalid_conversion']*100/totalData[k]['total_conversion']).toFixed(2) : 0.00}%</td>)
                tdata.push(<td>{totalData[k]['gross_click'] > 0 ? (totalData[k]['conversion']*100/totalData[k]['gross_click']).toFixed(2) : 0.00}%</td>)
                tdata.push(<td>{totalData[k]['major'] > 0 ? (totalData[k]['conversion']*100/totalData[k]['conversion']).toFixed(2) : 0.00}%</td>)
            }
            
            tbody.push(
                <tr key={i}>
                    <td className='text-center' width="10%">
                        {
                            Number(level) < 3 ? <a href="javascript:;" onClick={this.props.onClick.bind(this, [affId, i])}>
                                <span className={Number(level) == 1 ? (expand.hasOwnProperty(i) ? "glyphicon glyphicon-chevron-down" : "glyphicon glyphicon-chevron-right") : (expand.hasOwnProperty(affId) && $.inArray(i, expand[affId]) != -1 ? "glyphicon glyphicon-chevron-down" : "glyphicon glyphicon-chevron-right")}>{i}</span>
                            </a> : i
                        }
                    </td>
                    {tdata}
                    <td>
                        <div style={{width:'120px'}}>
                            <div className="dropdown pull-left" style={{marginLeft:'15px'}}>
                              <button className="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span className="selected-text">Actions</span> <span className="caret"></span>
                              </button>
                              <ul className="dropdown-menu" aria-labelledby="dropdownMenu">
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange}>On<i className="mark-info glyphicon glyphicon-pencil" data-toggle="modal" data-info="on" onClick={this.props.onChange}></i></a>
                                </li>
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange}>Off<i className="mark-info glyphicon glyphicon-pencil" data-toggle="modal" data-info="off" onClick={this.props.onChange}></i></a>
                                </li>
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange}>Whole Off<i className="mark-info glyphicon glyphicon-pencil" data-toggle="modal" data-info="whole off" onClick={this.props.onChange}></i></a>
                                </li>
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange}>Network Off<i className="mark-info glyphicon glyphicon-pencil" data-toggle="modal" data-info="network off" onClick={this.props.onChange}></i></a>
                                </li>
                                <li role="separator" className="divider"></li>
                                <li><a href="javascript:;" onClick={this.props.onChange}>More</a></li>
                              </ul>
                            </div>
                            <div className="pull-left">
                                <i className="switch-info fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="the reason of selected"></i>
                            </div>
                        </div>
                    </td>
                </tr>
            )
            
            switch(Number(level)) {
                case 1:
                    if (expand.hasOwnProperty(i) && curData.data) {
                        tbody.push(<tr className="well"><td colSpan={colLength}>{<ChildNode level={Number(level) + 1} mapData={curData} expand={expand}  affId={i} tableName={Number(level) + 1 == 2 ? 'second-table' : 'third-table'} onClick={this.props.onClick} onChange={this.props.onChange} />}</td></tr>)
                    }
                    break;
                case 2:
                    if (expand.hasOwnProperty(affId) && $.inArray(i, expand[affId]) != -1 && curData.data) {
                        tbody.push(<tr className="well"><td colSpan={colLength}>{<ChildNode level={Number(level) + 1} mapData={curData} expand={expand}  affId={i} tableName={Number(level) + 1 == 2 ? 'second-table' : 'third-table'} onClick={this.props.onClick} onChange={this.props.onChange} />}</td></tr>)
                    }
                    break;
            }
        }

        return (
            <table className={tableName + " table table-bordered"} data-affId={affId}>
                {thead}
                <tbody>
                    {tbody}
                </tbody>
                {tfoot}
            </table>
        )
    }
}

export default class Datatable extends Component {
    constructor(props) {
        super(props)
        this.state = Object.assign({entries: []}, this.getDefaultState())
        this.loading = true;
        this.loadData()

        this.switchDisplay = this.switchDisplay.bind(this)
        this.handleChange = this.handleChange.bind(this)
        this.setDefaultState = this.setDefaultState.bind(this)
    }

    getDefaultState(flag) {
        if (!flag) {
            return {
                expand: {},
                entries: []
            }
        } else {
            return {
                expand: {},
                entries: []
            }
        }
    }

    loadData(url) {
        $.getJSON('/campaigns/blacklist', function(res){
            let data  = JSON.parse(res);
            if (data.status == 200) {
                this.loading = false;
                this.setState(Object.assign({},this.state,{ entries: data.result }))
            }
        }.bind(this))
    }

    handleChange(e) {
        if ($(e.target).hasClass('mark-info')) {
            $(e.target).closest('ul').prev().find('.selected-text').html($(e.target).closest('a').text());
            let info = $(e.target).data('info');
            $('.mark-info-sm').modal();
            $('.mark-info-sm').on('show.bs.modal', function(event){
                var modal = $(this);
                modal.find('.modal-body #option-name').val(info);
            });
        } else {
            $(e.target).closest('ul').prev().find('.selected-text').html(e.target.text);
        }
    }

    switchDisplay(data) {
        let expand = this.state.expand, initData = $.grep(data, (v) => {return v != ""});
        switch(initData.length){
            case 1:
                if (expand.hasOwnProperty(initData[0])) {
                    delete expand[initData[0]]
                    this.setState({
                        expand: expand,
                    })
                } else {
                    expand[initData[0]] = [];
                    this.setState({
                        expand: expand,
                    })
                }
                break;
            case 2:
                if($.inArray(initData[1], expand[initData[0]]) != -1){
                    expand[initData[0]] = $.grep(expand[initData[0]], (v) => {return v != initData[1]})
                    this.setState({
                        expand: expand,
                    })
                } else {
                    expand[initData[0]].push(initData[1]);
                    this.setState({
                        expand: expand,
                    })
                }
                break;
        };
    }

    setDefaultState() {
        this.setState(this.getDefaultState());
    }

    componentDidUpdate() {
        $(function(){
            if (!$('.first-table').attr('id')) {
                $('.first-table').dataTable({
                    dom:"<'row'<'col-sm-6 date-picker'>>" +
                    "<'row'<'col-sm-6'B><'col-sm-6 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>",
                    buttons: [
                      {
                        extend: "csv",
                        className: "btn-sm"
                      }
                    ],
                    destroy: true,
                    responsive: true,
                    columnDefs: [{
                      targets: [0,-1],
                      searchable: false,
                      orderable: false,
                    }],
                    order: [[ 3, "desc" ]],
                    preDrawCallback:  function(settings) {
                        this.setState(Object.assign({},this.state,{ expand: {}}))
                    }.bind(this)
                })
            }
            $('.second-table').map(function(i, e) {
                e = $(e);
                if(!e.attr('id')){
                    e.dataTable({
                        dom:"<'row'<'col-sm-12'tr>>",
                        responsive: true,
                        buttons: [
                          {
                            extend: "csv",
                            className: "btn-sm"
                          }
                        ],
                        columnDefs: [{
                          targets: [0,-1],
                          searchable: false,
                          orderable: false,
                        }],
                        order: [[ 3, "desc" ]],
                        preDrawCallback: function(settings) {
                            if (e.data('affid')) {
                                var expand = this.state.expand
                                expand[e.data('affid')] = []
                                this.setState(Object.assign({},this.state,{ expand: expand}))
                            }
                        }.bind(this),
                    })
                }
            }.bind(this))

            $('.third-table').map(function(i, e) {
                e = $(e);
                if(!e.attr('id')){
                    e.dataTable({
                        dom:"<'row'<'col-sm-12'tr>>",
                        responsive: true,
                        buttons: [
                          {
                            extend: "csv",
                            className: "btn-sm"
                          }
                        ],
                        columnDefs: [{
                          targets: [0,-1],
                          searchable: false,
                          orderable: false,
                        }],
                        order: [[ 3, "desc" ]],
                    })                    
                }
            })
        }.bind(this))

        $('[data-toggle="tooltip"]').tooltip()
        $('.dropdown-toggle').dropdown()
    }

    componentDidMount() {
        //
    }

    render() {
        const loading = this.loading
        return (
            <div className="raw">
                <div className="col-md-12">
                    <div>
                    {!loading ? <ChildNode mapData={this.state.entries} expand={this.state.expand} level="1" affId=""  tableName="first-table" onClick={this.switchDisplay} onChange={this.handleChange} /> :
                            <div className="text-center"><img src="/images/loading.gif" /></div>}
                    </div>
                </div>
            </div>
        )
    }
}

window.showTableHtml = function(opt) {
    render(
       <Datatable opt={opt} />,
       document.getElementById('datatable-select') 
    )   
}

