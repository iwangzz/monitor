import React, { Component } from 'react'
import { render } from 'react-dom'

class ChildNode extends Component {
    constructor(props) {
        super(props)
    }

    render() {
        const { mapData, level, tableName, affId, expand, filterFlag, filterLevel, parent, blockTracks, automate }  = this.props
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
            tfdata.push(<td>{mapData.total[i]['gc']}</td>)
            tfdata.push(<td>{mapData.total[i]['uc']}</td>)
            tfdata.push(<td>{mapData.total[i]['cv']}</td>)
            tfdata.push(<td>{mapData.total[i]['ic']}</td>)
            tfdata.push(<td>{mapData.total[i]['cv'] > 0 ? (mapData.total[i]['ic']*100/mapData.total[i]['cv']).toFixed(2) : 0}%</td>)
            tfdata.push(<td>{mapData.total[i]['gc'] > 0 ? (mapData.total[i]['cv']*100/mapData.total[i]['gc']).toFixed(2) : 0}%</td>)
            tfdata.push(<td>{mapData.total[i]['cv'] > 0 ? (mapData.total[i]['k']*100/mapData.total[i]['cv']).toFixed(2) : 0}%</td>)
            
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
                    <th rowSpan="2" className="th-first text-center"  style={{whiteSpace:'nowrap'}}>{Number(level) == 1 ? 'Affiliate ID' : (Number(level) == 2 ? (filterFlag == 'aff_pub' ? 'Aff-Publisher' : 'Group') : (filterFlag == 'aff_pub' ? 'Group' : 'Aff-Publisher')) }</th>
                    {th1}
                    {((Number(level) != 2 && filterFlag == 'group') || (Number(level) != 3 && filterFlag == 'aff_pub')) ? <th></th> : '' }
                </tr>
                <tr>
                    {th2}
                    {((Number(level) != 2 && filterFlag == 'group') || (Number(level) != 3 && filterFlag == 'aff_pub')) ? <th width="10%">Status</th> : '' }
                </tr>
            </thead>
        )
        tfoot.push(
            <tfoot>
                <tr>
                    <td className="text-center">Total</td>
                    {tfdata}
                    {((Number(level) != 2 && filterFlag == 'group') || (Number(level) != 3 && filterFlag == 'aff_pub')) ? <td></td> : '' }
                </tr>
            </tfoot>
        )
        
        if (mapData.data && Object.keys(mapData).length > 0) {
            for (var i in mapData.data) {
            let curData = mapData.data[i], tdata = [];
            let totalData = curData.hasOwnProperty('total') ? curData.total : curData;
            for (var k in totalData) {
                tdata.push(<td>{totalData[k]['gc']}</td>)
                tdata.push(<td>{totalData[k]['uc']}</td>)
                tdata.push(<td>{totalData[k]['cv']}</td>)
                tdata.push(<td>{totalData[k]['ic']}</td>)
                tdata.push(<td>{totalData[k]['cv'] > 0 ? (totalData[k]['ic']*100/totalData[k]['cv']).toFixed(2) : 0}%</td>)
                tdata.push(<td>{totalData[k]['gc'] > 0 ? (totalData[k]['cv']*100/totalData[k]['gc']).toFixed(2) : 0}%</td>)
                tdata.push(<td>{totalData[k]['cv'] > 0 ? (totalData[k]['k']*100/totalData[k]['cv']).toFixed(2) : 0}%</td>)
            }
            
            tbody.push(
                <tr key={i}>
                    <td className='text-center' width="10%">
                        {
                            Number(level) == 1 ? <a href="javascript:;" onClick={this.props.onClick.bind(this, [affId, i])}>
                                <span className={expand.hasOwnProperty(i) ? "glyphicon glyphicon-chevron-down" : "glyphicon glyphicon-chevron-right"}>{i}</span>
                            </a> : (Number(level) == 2 && Number(filterLevel) == 3 ? <a href="javascript:;" onClick={this.props.onClick.bind(this, [affId, i])}>
                                <span className={expand.hasOwnProperty(affId) && $.inArray(i, expand[affId]) != -1 ? "glyphicon glyphicon-chevron-down" : "glyphicon glyphicon-chevron-right"}>{i}</span>
                            </a> : i)
                        }
                    </td>
                    {tdata}
                    {((Number(level) != 2 && filterFlag == 'group') || (Number(level) != 3 && filterFlag == 'aff_pub')) ? 
                    (<td>
                        <div style={{width:'120px'}}>
                            <div className="dropdown pull-left" style={{marginLeft:'15px'}}>
                              <button className="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" disabled={Number(level) > 1 && blockTracks.hasOwnProperty(parent) && $.inArray('all', blockTracks[parent]) != -1 ? true : false}>
                                <span className="selected-text">
                                    {
                                        Number(level) == 1 ? (blockTracks.hasOwnProperty(i) && $.inArray('all', blockTracks[i]) != -1 ? ($.inArray('all', automate[i]) != -1 ? 'Forever Off' : 'Off') : 'On') : 
                                        (blockTracks.hasOwnProperty(parent) ? (($.inArray('all', blockTracks[parent]) != -1 || $.inArray(i, blockTracks[parent]) != -1) ? (($.inArray('all', automate[parent]) != -1 || $.inArray(i, automate[parent]) != -1) ? 'Forever Off' : 'Off' ) : 'On') : 'On')
                                    }
                                </span> 
                                <span className="caret"></span>
                              </button>
                              <ul className="dropdown-menu" aria-labelledby="dropdownMenu" data-aff={Number(level) == 1 ? i : parent} data-pub={Number(level) == 1 ? 'all' : i}>
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange.bind(this, 1)}>On</a>
                                </li>
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange.bind(this, 0)}>Off</a>
                                </li>
                                <li>
                                    <a href="javascript:;" onClick={this.props.onChange.bind(this, -1)}>Forever Off</a>
                                </li>
                              </ul>
                            </div>
                        </div>
                    </td>) : 
                    ''
                    }
                </tr>
            )
            
            switch(Number(level)) {
                case 1:
                    if (expand.hasOwnProperty(i) && curData.data) {
                        tbody.push(<tr className="well"><td colSpan={colLength}>{<ChildNode level={Number(level) + 1} mapData={curData} blockTracks={blockTracks} automate={automate} parent={Number(level) == 1 ? i : parent} filterLevel={filterLevel} expand={expand} filterFlag={filterFlag} affId={i} tableName={Number(level) + 1 == 2 ? 'second-table' : 'third-table'} onClick={this.props.onClick} onChange={this.props.onChange} />}</td></tr>)
                    }
                    break;
                case 2:
                    if (expand.hasOwnProperty(affId) && $.inArray(i, expand[affId]) != -1 && curData.data) {
                        tbody.push(<tr className="well"><td colSpan={colLength}>{<ChildNode level={Number(level) + 1} mapData={curData} blockTracks={blockTracks} automate={automate} parent={Number(level) == 1 ? i : parent} filterLevel={filterLevel} expand={expand} filterFlag={filterFlag} affId={i} tableName={Number(level) + 1 == 2 ? 'second-table' : 'third-table'} onClick={this.props.onClick} onChange={this.props.onChange} />}</td></tr>)
                    }
                    break;
                }
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
        this.loadData(this.state.filter)

        this.switchDisplay = this.switchDisplay.bind(this)
        this.handleChange = this.handleChange.bind(this)
    }

    getDefaultState() {
        return {
            expand: {},
            entries: [],
            loading: true,
            blockTracks: JSON.parse(this.props.blockTracks),
            automate: JSON.parse(this.props.automate),
            filter: {
                offer_id: this.props.campaignId,
                flag: this.props.flag,
                level: 3
            }
        }
    }

    loadData(args) {
        $.getJSON('/campaigns/blacklist', args, function(res){
            let data  = JSON.parse(res);
            if (data.status == 200) {
                this.setState(Object.assign({},this.state,{ entries: data.result, loading: false, filter: args}))
            }
        }.bind(this))
    }

    handleChange(data, e) {
        // if ($(e.target).hasClass('mark-info')) {
        //     $(e.target).closest('ul').prev().find('.selected-text').html($(e.target).closest('a').text());
        //     let info = $(e.target).data('info');
        //     $('.mark-info-sm').modal();
        //     $('.mark-info-sm').on('show.bs.modal', function(event){
        //         var modal = $(this);
        //         modal.find('.modal-body #option-name').val(info);
        //     });
        // } else {
        //     $(e.target).closest('ul').prev().find('.selected-text').html(e.target.text);
        // }

        $(e.target).closest('ul').prev().find('.selected-text').html(e.target.text);
        let blockTracks = this.state.blockTracks,
            affId = $(e.target).closest('ul').data('aff'),
            affPub = $(e.target).closest('ul').data('pub'),
            postData = {
                ad_id: this.props.campaignId,
                aff_id: affId,
                aff_pub: affPub,
                track: data != 1 ? 1 : 0,
                automate: data == -1 ? 0 : 1
            };
        
        $.post('/campaigns/'+this.props.campaignId+'/drag-into', postData, function(res) {
            if (res.code == 200) {
                this.setState(Object.assign({},this.state,{ blockTracks: res.blockTracks, automate:res.automate}))
            }
        }.bind(this))
    }

    switchDisplay(data) {
        let expand = this.state.expand, initData = $.grep(data, (v) => {return v != ""});
        switch(initData.length){
            case 1:
                if (expand.hasOwnProperty(initData[0])) {
                    delete expand[initData[0]]
                } else {
                    expand[initData[0]] = [];
                }
                break;
            case 2:
                if($.inArray(initData[1], expand[initData[0]]) != -1){
                    expand[initData[0]] = $.grep(expand[initData[0]], (v) => {return v != initData[1]})
                } else {
                    expand[initData[0]].push(initData[1]);
                }
                break;
        };

        this.setState(Object.assign({},this.state,{ expand: expand}))
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
        $(function(){
            $('#filter-flag').select2({
              minimumResultsForSearch: Infinity
            })
            $('#filter-flag').on('change', function(e){
                console.log(e.target.value)
                window.location.href="/campaigns/"+this.props.campaignId+'?f='+e.target.value
            }.bind(this))
        }.bind(this))
    }

    render() {
        return (
            <div>
                <div className="raw">
                    <div className="col-md-2" style={{marginBottom: '15px'}}>
                      <div className="form-group">
                        <select defaultValue={this.props.flag} id="filter-flag" className="form-control">
                            <option value="aff_pub">Aff-Publisher</option>
                            <option value="group">Group</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div className="raw">
                    <div className="col-md-12">
                        <div>
                        {!this.state.loading ? <ChildNode mapData={this.state.entries} blockTracks={this.state.blockTracks} automate={this.state.automate} expand={this.state.expand} filterFlag={this.state.filter.flag} parent='' filterLevel={this.state.filter.level} level="1" affId=""  tableName="first-table" onClick={this.switchDisplay} onChange={this.handleChange} /> :
                                <div className="text-center"><img src="/images/loading.gif" /></div>}
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

window.showTableHtml = function(campaignId, flag, blockTracks, automate) {
    render(
       <Datatable campaignId={campaignId} flag={flag} blockTracks={blockTracks} automate={automate}/>,
       document.getElementById('datatable-select') 
    )   
}

