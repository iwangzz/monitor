import { combineReducers } from 'redux'
import charts from './charts'
import content from './content'
import datatable from './datatable'

export default combineReducers({
    charts,
    content,
    datatable
})