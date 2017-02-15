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

    componentWillMount() {
        window.detailTable = '';
    }

    componentDidMount() {
        console.log('did mount');
        window.detailTable = this.props.opt == 'kpi' ? $('#opt-table').dataTable({
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
              targets: 0,
              searchable: false,
              orderable: false,
            }],
            order: [[ 3, "desc" ]],
            // serverSide: true,
            // ajax: {
            //   url: "",
            //   data: function(d) {
            //     d.startDate = $('#start-date').val();
            //     d.endDate = $('#end-date').val()
            //   }
            // },
            // columns: [
            //   {
            //     data: 'null',
            //     orderable: false,
            //     className: 'details-control',
            //     defaultContent: ''
            //   },
            //   {
            //     data: 'aff_id'
            //   },
            //   {
            //     data: 'aff_pub'
            //   },
            //   {
            //     data: 'pv'
            //   },
            //   {
            //     data: 'uv'
            //   },
            //   {
            //     data: 'conv'
            //   },
            //   {
            //     data: 'cvr',
            //     render: function(v){
            //         return v + '%';
            //     }
            //   }
            // ]
        }) : $('#opt-table').dataTable({
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
            serverSide: true,
            ajax: {
              url: "",
              data: function(d) {
                d.startDate = $('#start-date').val();
                d.endDate = $('#end-date').val()
              }
            },
            columns: [
              {
                data: 'null',
                orderable: false,
                className: 'details-control',
                defaultContent: ''
              },
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
                        <table id="opt-table" className="table table-striped table-bordered">
                            <thead>
                                { this.props.opt == 'kpi' ? 
                                    (
                                        <tr>
                                            <th></th>
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
                                            <th></th>
                                            <th>Affiliate ID</th>
                                            <th>Affiliate Publisher</th>
                                            <th>Conversion</th>
                                            <th>Invalid Conversion</th>
                                            <th>Invalid Proportion</th>
                                        </tr>
                                    )
                                }
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>1002</td>
                                    <td>1002-xxx</td>
                                    <td>100000</td>
                                    <td>30000</td>
                                    <td>20</td>
                                    <td>2</td>
                                </tr>
                            </tbody>
                        </table>
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

$(function() {
    function format (d) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
                '<td>Full name:</td>'+
                '<td>'+d.name+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Extension number:</td>'+
                '<td>'+d.extn+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Extra info:</td>'+
                '<td>And any further details here (images etc)...</td>'+
            '</tr>'+
        '</table>';
    }
     
    // Add event listener for opening and closing details
    $('#opt-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
})










