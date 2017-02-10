import React, { Component } from 'react'
import ReactDOM, { render } from 'react-dom'
import { Provider } from 'react-redux'
import configureStore from './stores/configureStore'
import Campaign from './containers/Campaign'

const campaignDetail = {}
const store = configureStore()
// store.dispatch(actions.setDetails(campaignDetail));

render(
    <Provider store={store} >
        <Campaign />
    </Provider>,
    document.getElementById('campaign')
)




