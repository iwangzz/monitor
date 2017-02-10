import * as actionTypes from '../constants/actionTypes'

const initialState = [];

export default function (state=initialState, action) {
    switch(action.type) {
        case actionTypes.Charts:
            return state;
            break;
    }
    return state;
}
