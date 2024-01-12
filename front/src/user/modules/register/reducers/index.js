import { ACTION_CUSTOMER_LIST, ACTION_CUSTOMER_VIEW } from "../actions/customers";
import { ACTION_USER_LIST, ACTION_USER_VIEW } from "../actions/users";

let initialReducer = {
    customers: {
        list: {
            rows: [],
            total: 0,
            pagination: [],
        },
        view: {
            fullname: '',
            email: '',
        },
    },
    users: {
        list: {
            rows: [],
            total: 0,
            pagination: [],
        },
        view: {
            fullname: '',
            email: '',
        },
    },
}

let RegisterReducers = (state = initialReducer, action) => {
    switch (action.type) {
        case ACTION_USER_LIST.type:
            return {
                ...state,
                users: {
                    ...state.users,
                    list: {
                        rows: action.payload.rows,
                        total: action.payload.total,
                        pagination: action.payload.pagination
                    },
                }
            };
        case ACTION_USER_VIEW.type:
            return {
                ...state,
                users: {
                    ...state.users,
                    view: {
                        fullname: action.payload.fullname,
                        email: action.payload.email,
                    },
                },
            };
        case ACTION_CUSTOMER_LIST.type:
            return {
                ...state,
                customers: {
                    ...state.customers,
                    list: {
                        rows: action.payload.rows,
                        total: action.payload.total,
                        pagination: action.payload.pagination
                    },
                }
            };
        case ACTION_CUSTOMER_VIEW.type:
            return {
                ...state,
                customers: {
                    ...state.customers,
                    view: {
                        fullname: action.payload.fullname,
                        email: action.payload.email,
                    },
                },
            };
        default:
            return state;
    }
}

export default RegisterReducers