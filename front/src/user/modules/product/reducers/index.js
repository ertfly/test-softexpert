import { ACTION_PRODUCT_CATEGORY_LIST, ACTION_PRODUCT_CATEGORY_VIEW } from "../actions/productCategories";

let initialReducer = {
    categories: {
        list: {
            rows: [],
            total: 0,
            pagination: [],
        },
        view: {
            name: '',
            fee: '',
        },
    },
}

let ProductReducers = (state = initialReducer, action) => {
    switch (action.type) {
        case ACTION_PRODUCT_CATEGORY_LIST.type:
            return {
                ...state,
                categories: {
                    ...state.categories,
                    list: {
                        rows: action.payload.rows,
                        total: action.payload.total,
                        pagination: action.payload.pagination
                    },
                }
            };
        case ACTION_PRODUCT_CATEGORY_VIEW.type:
            return {
                ...state,
                categories: {
                    ...state.categories,
                    view: {
                        name: action.payload.name,
                        fee: action.payload.fee,
                    },
                },
            };
        default:
            return state;
    }
}

export default ProductReducers