import React, { Component } from 'react'
import { render } from 'react-dom'

export default class Datatable extends Component {
    constructor(props) {
        super(props)
    }

    handleChange(e) {
        console.log(e.target.value);
        // detailTable.api().ajax.reload()
    }

    componentDidMount() {
        console.log('did mount');
        window.detailTable = this.props.opt == 'kpi' ? $('#opt-table').dataTable({
            dom:"<'row'<'col-sm-6 date-picker'><'col-sm-6 mb15 text-right'B>>" +
            "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "serverSide": true,
            ajax: {
              url: "",
              data: function(d) {
                d.startDate = $('#start-date').val();
                d.endDate = $('#end-date').val()
              }
            },
            buttons: [
              {
                extend: "csv",
                className: "btn-sm"
              }
            ],
            columns: [
              {
                data: 'aff_id'
              },
              {
                data: 'aff_pub'
              },
              {
                data: 'pv'
              },
              {
                data: 'uv'
              },
              {
                data: 'conv'
              },
              {
                data: 'cvr',
                render: function(v){
                    return v + '%';
                }
              }
            ]
        }) : $('#opt-table').dataTable({
            dom:"<'row'<'col-sm-6 date-picker'><'col-sm-6 mb15 text-right'B>>" +
            "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "serverSide": true,
            ajax: {
              url: "",
              data: function(d) {
                d.startDate = $('#start-date').val();
                d.endDate = $('#end-date').val()
              }
            },
            buttons: [
              {
                extend: "csv",
                className: "btn-sm"
              }
            ],
            responsive: true,
            columns: [
              {
                data: 'aff_id'
              },
              {
                data: 'aff_pub'
              },
              {
                data: 'conv'
              },
              {
                data: 'fraud_conv'
              },
              {
                data: 'fraud_rate',
                render: function(v){
                    return v ? v + '%' : '';
                }
              }
            ]
        });
    }

    render() {
        return (
            <div className="raw">
                <div className="col-md-2 mb15">
                    <form action="" method="" className="form-inline">
                        <div className="form-horizontal">
                            <select className="form-control" id="category" name="" onChange={this.handleChange.bind(this)}>
                                <option value="aff">Affiliate</option>
                                <option value="aff_pub">Affiliate&Affiliate Publisher</option>
                                <option value="group">Group</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div className="col-md-12">
                    <div>
                        <table id="opt-table" className="table table-striped table-bordered">
                            <thead>
                                { this.props.opt == 'kpi' ? 
                                    (
                                        <tr>
                                            <th>Affiliate ID</th>
                                            <th>Affiliate Publisher</th>
                                            <th>PV</th>
                                            <th>UV</th>
                                            <th>Conversion</th>
                                            <th>CVR</th>
                                        </tr>
                                    )
                                :
                                    (
                                        <tr>
                                            <th>Affiliate ID</th>
                                            <th>Affiliate Publisher</th>
                                            <th>Conversion</th>
                                            <th>Invalid Conversion</th>
                                            <th>Invalid Proportion</th>
                                        </tr>
                                    )
                                }
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        )
    }
}

window.showTableHtml = function(opt) {
    render(
       <Datatable opt={opt}/>,
       document.getElementById('datatable-select') 
    )   
}










