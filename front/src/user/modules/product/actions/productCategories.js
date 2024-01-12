import { toast } from "react-toastify";
import Api from '../../../../axios'
import { callLoader } from '../../../../common/actions/app'

let ACTION_PRODUCT_CATEGORY_LIST = {
    type: 'PRODUCT_CATEGORY_LIST',
    payload: {
        rows: [],
        total: 0,
        pagination: [],
    },
};

let ACTION_PRODUCT_CATEGORY_VIEW = {
    type: 'PRODUCT_CATEGORY_VIEW',
    payload: {
        name: '',
        fee: '',
    },
};

let callProductCategoryListGet = (filter = {}, pg = 1) => (dispatch) => {
    dispatch(callLoader(true))
    Api.get('/product/category?pg=' + pg).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_PRODUCT_CATEGORY_LIST.payload.rows = data.rows
        ACTION_PRODUCT_CATEGORY_LIST.payload.total = data.total
        ACTION_PRODUCT_CATEGORY_LIST.payload.pagination = data.pagination
        dispatch(ACTION_PRODUCT_CATEGORY_LIST)
    })
}

let callProductCategoryViewGet = (id) => (dispatch) => {
    dispatch(callLoader(true))
    Api.get('/product/category/' + id).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_PRODUCT_CATEGORY_VIEW.payload.name = data.name
        ACTION_PRODUCT_CATEGORY_VIEW.payload.fee = data.fee
        dispatch(ACTION_PRODUCT_CATEGORY_VIEW)
    })
}

let callProductCategoryPost = (data, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.post('/product/category', data).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

let callProductCategoryPut = (id, data, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.put('/product/category/' + id, data).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

let callProductCategoryClearView = () => (dispatch) => {
    ACTION_PRODUCT_CATEGORY_VIEW.payload.name = ''
    ACTION_PRODUCT_CATEGORY_VIEW.payload.fee = ''
    dispatch(ACTION_PRODUCT_CATEGORY_VIEW)
}

let callProductCategoryDelete = (id, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.delete('/product/category/' + id).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

export { callProductCategoryListGet, callProductCategoryViewGet, callProductCategoryPost, callProductCategoryPut, callProductCategoryDelete, callProductCategoryClearView, ACTION_PRODUCT_CATEGORY_LIST, ACTION_PRODUCT_CATEGORY_VIEW }