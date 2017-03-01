import React, { Component } from 'react'
import { render } from 'react-dom'

class ChildNode extends Component {
    constructor(props) {
        super(props)
    }

    render() {
        const { affData, affPubData, groupData, affExpand, affPubExpand }  = this.props
        let tbody = [], curData = this.props.colName == 'aff' ? affData : (this.props.colName == 'pub' ? affPubData[this.props.curIndex] : groupData[this.props.curIndex])

        curData.map(function(row, index) {
            tbody.push(
                <tr key={index}>
                    <td className='text-center'>
                        {this.props.colName == 'aff' ? (<a href="javascript:;" onClick={this.props.onClick.bind(this, 'aff_id-'+row.aff_id)}><span className={$.inArray(row.aff_id, affExpand) == -1 ? "glyphicon glyphicon-chevron-right" : "glyphicon glyphicon-chevron-down"}>{row.aff_id}</span></a>) : (this.props.colName == 'pub' ? (<a href="javascript:;" onClick={this.props.onClick.bind(this, 'aff_pub-'+row.aff_pub)}><span className={$.inArray(row.aff_pub, affPubExpand) == -1 ? "glyphicon glyphicon-chevron-right" : "glyphicon glyphicon-chevron-down"}>{row.aff_pub}</span></a>) : row.group)}
                    </td>
                    <td>{row.t_pv}</td>
                    <td>{row.t_uv}</td>
                    <td>{row.t_c}</td>
                    <td>{row.t_cvr}</td>
                    <td>{row.p_pv}</td>
                    <td>{row.p_uv}</td>
                    <td>{row.p_c}</td>
                    <td>{row.p_cvr}</td>
                    <td className="text-center">
                        <select onChange={this.props.onChange}>
                            <option value="off">Off</option>
                            <option value="long off">Permanently Off</option>
                            <option value="on">On</option>
                            <option value="more">More</option>
                        </select>
                        <i className="switch-info fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="the reason of selected"></i>
                    </td>
                </tr>
            )

            if (this.props.colName == 'aff' && affPubData[row.aff_id]) {
                tbody.push(<tr className="well" key={row.aff_id}><td colSpan="10">{<ChildNode {...this.props} colName='pub'  tableName="pub-table" curIndex={row.aff_id} onClick={this.props.onClick} onChange={this.props.onChange} />}</td></tr>)
            }

            if (this.props.colName == 'pub' && groupData[row.aff_pub]) {
                tbody.push(<tr className="well" key={row.aff_pub}><td colSpan="10">{<ChildNode {...this.props} colName='group' tableName="group-table" curIndex={row.aff_pub} onClick={this.props.onClick} onChange={this.props.onChange} />}</td></tr>)
            }
        }.bind(this))

        return (
            <table className={this.props.tableName + " table table-bordered"}>
                <thead>
                    <tr>
                        <th rowSpan="2" className="th-first text-center">{this.props.colName == 'aff' ? 'Aff ID' : (this.props.colName == 'pub' ?  'Aff-Publisher ID' : 'Group Id')}</th>
                        <th colSpan="4" className="text-center">Today</th>
                        <th colSpan="4" className="text-center">Last 7 days</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>PV</th>
                        <th>UV</th>
                        <th>Conversion</th>
                        <th>CVR</th>
                        <th>PV</th>
                        <th>UV</th>
                        <th>Conversion</th>
                        <th>CVR</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    {tbody}
                </tbody>
            </table>
        )
    }
}

export default class Datatable extends Component {
    constructor(props) {
        super(props)
        this.state = Object.assign({affData: []}, this.getDefaultState())
        this.loadData()
        this.first = true;
        this.switchDisplay = this.switchDisplay.bind(this)
        this.handleChange = this.handleChange.bind(this)
        this.setDefaultState = this.setDefaultState.bind(this)
    }

    getDefaultState(flag) {
        if (!flag) {
            return {
                affExpand: [],
                affPubExpand: [],
                affPubData: {},
                groupData: {}
            }
        } else {
            return {
                affExpand: this.state.affExpand,
                affPubExpand: [],
                affPubData: this.state.affPubData,
                groupData: {} 
            }
        }
    }

    loadData(url) {
        !url ? 
        this.state.affData = [
            {aff_id:1002,t_pv:100000,t_uv:10000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            {aff_id:1003,t_pv:200000,t_uv:20000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            {aff_id:1004,t_pv:300000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            {aff_id:1005,t_pv:400000,t_uv:40000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            {aff_id:1006,t_pv:500000,t_uv:50000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
        ] : 
        (url.split('=')[0] == 'aff_id' ? 
        this.state.affPubData = {
            1002: [
                {aff_pub:'1002_xx1',t_pv:100000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1002_xx2',t_pv:200000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1002_xx3',t_pv:300000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1002_xx4',t_pv:400000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1002_xx5',t_pv:500000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            ],
            1006: [
                {aff_pub:'1006_xx1',t_pv:100000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1006_xx2',t_pv:200000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1006_xx3',t_pv:300000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1006_xx4',t_pv:400000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {aff_pub:'1006_xx5',t_pv:500000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            ]
        } : this.state.groupData = {
            '1002_xx1': [
                {group:'2001',t_pv:100000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {group:'2001',t_pv:200000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {group:'2001',t_pv:300000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {group:'2001',t_pv:400000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
                {group:'2001',t_pv:500000,t_uv:30000,t_c:20,t_cvr:2,p_pv:100000,p_uv:30000,p_c:20,p_cvr:2},
            ]
        })
    }

    handleChange(e) {
        let value = e.target.value;
        // console.log(value);
    }

    switchDisplay(info) {
        let id = info.split('-')[1], affExpand = this.state.affExpand, affPubExpand = this.state.affPubExpand, affPubData = this.state.affPubData, groupData = this.state.groupData;
        if (info.split('-')[0] == 'aff_id') {
            id = Number(id);
            if ($.inArray(id, affExpand) != -1) {
                this.setState({
                    affExpand: $.grep(affExpand, (v) => {return v != id}),
                    affPubData: $.grep(affPubData, (v, i) => {return i != id})
                })
            } else {
                affExpand.push(id);
                this.loadData('aff_id='+id);
                this.setState({
                    affExpand: affExpand
                })
            }
        }

        if (info.split('-')[0] == 'aff_pub') {
            if ($.inArray(id, affPubExpand) != -1) {
                this.setState({
                    affPubExpand: $.grep(affPubExpand, (v) => {return v != id}),
                    groupData: $.grep(groupData, (v, i) => {return i != id})
                })
            } else {
                affPubExpand.push(id);
                this.loadData('aff_pub='+id);
                this.setState({
                    affPubExpand: affPubExpand,
                })
            }
        }
    }

    setDefaultState() {
        this.setState(this.getDefaultState());
    }

    componentDidUpdate() {
        $('.pub-table').map(function(i, e) {
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
                    preDrawCallback:  function(settings) {
                        if (!this.first) {
                            this.setState(this.getDefaultState('aff_pub'))
                        }
                    }.bind(this)
                })
            }
        }.bind(this))

        $('.group-table').map(function(i, e) {
            e = $(e);
            if(!e.attr('id')) {
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

        $('[data-toggle="tooltip"]').tooltip()
    }

    componentDidMount() {
         $('.aff-table').dataTable({
            dom:"<'row'<'col-sm-6 date-picker'><'col-sm-6 mb15 text-right'B>>" +
            "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
              {
                extend: "csv",
                className: "btn-sm"
              }
            ],
            responsive: true,
            columnDefs: [{
              targets: [0,-1],
              searchable: false,
              orderable: false,
            }],
            order: [[ 3, "desc" ]],
            preDrawCallback:  function(settings) {
                if (!this.first) {
                    this.setState(this.getDefaultState())
                }
            }.bind(this)
        })

        this.first =false;

        $('[data-toggle="tooltip"]').tooltip()
    }

    render() {
        return (
            <div className="raw">
                <div className="col-md-4 mb15">
                    <form action="" method="" className="form-inline">
                        <div className="form-group mr15">
                            <select className="form-control" id="category" name="" onChange={this.handleChange.bind(this)}>
                                <option value="aff">Affiliate</option>
                                <option value="aff_pub">Affiliate&Affiliate Publisher</option>
                                <option value="group">Group</option>
                            </select>
                        </div>
                        <div className="form-group">
                            <select className="form-control" id="conv-time" name="" onChange={this.handleChange.bind(this)}>
                                <option value="5">5 secs</option>
                                <option value="30">30 secs</option>
                                <option value="60">60 secs</option>
                                <option value="90">90 secs</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div className="col-md-12">
                    <div>
                        <ChildNode {...this.state} tableName="aff-table" colName='aff' onClick={this.switchDisplay} onChange={this.handleChange} />
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

