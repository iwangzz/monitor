import React, { Component } from 'react'
import ReactDOM, { render } from 'react-dom'
import Charts from '../../components/Charts'
import Content from '../../components/Content'
import Datatable from '../../components/Datatable'

export default class Campaign extends Component {
    componentDidMount() {
        console.log('container did monut');
    }

    render() {
        return (
            <div className="container">
                <div className="raw">
                    <div className="col-md-9">
                        <Charts />
                    </div>
                    <div className="col-md-3">
                        <Content />
                    </div>
                    <div className="col-md-12">
                        <Datatable />
                    </div>
                </div>
            </div>
        )
    }
}