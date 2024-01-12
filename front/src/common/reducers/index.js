import { ACTION_APP_LOADER } from "../actions/app"

let initialReducer = {
    loader: true
}

let AppReducer = (state = initialReducer, action) => {
    switch (action.type) {
        case ACTION_APP_LOADER.type:
            return {
                ...state,
                loader: action.payload
            }
        default:
            return state
    }
}

export default AppReducer