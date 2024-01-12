import { ACTION_PRODUCT_CATEGORY_LIST, ACTION_PRODUCT_CATEGORY_SELECT, ACTION_PRODUCT_CATEGORY_VIEW } from "../actions/productCategories";
import { ACTION_PRODUCT_LIST, ACTION_PRODUCT_VIEW } from "../actions/products";

let initialReducer = {
    products: {
        list: {
            rows: [],
            total: 0,
            pagination: [],
        },
        view: {
            categoryId: '',
            category: '',
            name: '',
            price: '',
            cost: ''
        },
    },
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
        select: []
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
        case ACTION_PRODUCT_CATEGORY_SELECT.type:
            return {
                ...state,
                categories: {
                    ...state.categories,
                    select: action.payload,
                },
            };
        case ACTION_PRODUCT_LIST.type:
            return {
                ...state,
                products: {
                    ...state.products,
                    list: {
                        rows: action.payload.rows,
                        total: action.payload.total,
                        pagination: action.payload.pagination
                    },
                }
            };
        case ACTION_PRODUCT_VIEW.type:
            return {
                ...state,
                products: {
                    ...state.products,
                    view: {
                        categoryId: action.payload.categoryId,
                        category: action.payload.category,
                        name: action.payload.name,
                        price: action.payload.price,
                        cost: action.payload.cost
                    },
                },
            };
        default:
            return state;
    }
}

export default ProductReducers