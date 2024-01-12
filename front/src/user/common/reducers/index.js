import { ACTION_APP_SESSION } from "./../actions/app"

let initialReducer = {
    session: {
        logged: null,
        name : '',
    },
}

let OfficeReducer = (state = initialReducer, action) => {
    switch (action.type) {
        case ACTION_APP_SESSION.type:
            return {
                ...state,
                session: {
                    logged: action.payload.logged,
                    name: action.payload.name,
                }
            }
        default:
            return state
    }
}

export default OfficeReducer