import React from 'react'
import { connect } from 'react-redux'
import Campaign from './presenter'

function mapStateToProps(state) {
    return state;
}

function mapDispatchToProps(dispatch) {
    return {};
}

export default connect(mapStateToProps, mapDispatchToProps)(Campaign)