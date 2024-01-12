import { toast } from "react-toastify";
import Api from '../../../../axios'
import { callLoader } from '../../../../common/actions/app'

let ACTION_CUSTOMER_LIST = {
    type: 'CUSTOMER_LIST',
    payload: {
        rows: [],
        total: 0,
        pagination: [],
    },
};

let ACTION_CUSTOMER_VIEW = {
    type: 'CUSTOMER_VIEW',
    payload: {
        fullname: '',
        email: '',
    },
};

let callCustomerListGet = (filter = {}, pg = 1) => (dispatch) => {
    dispatch(callLoader(true))
    Api.get('/customer?pg=' + pg).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_CUSTOMER_LIST.payload.rows = data.rows
        ACTION_CUSTOMER_LIST.payload.total = data.total
        ACTION_CUSTOMER_LIST.payload.pagination = data.pagination
        dispatch(ACTION_CUSTOMER_LIST)
    })
}

let callCustomerViewGet = (id) => (dispatch) => {
    dispatch(callLoader(true))
    Api.get('/customer/' + id).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_CUSTOMER_VIEW.payload.fullname = data.fullname
        ACTION_CUSTOMER_VIEW.payload.email = data.email
        dispatch(ACTION_CUSTOMER_VIEW)
    })
}

let callCustomerPost = (data, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.post('/customer?urldecode=1', data).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

let callCustomerPut = (id, data, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.put('/customer/' + id + '?urldecode=1', data).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

let callCustomerClearView = () => (dispatch) => {
    ACTION_CUSTOMER_VIEW.payload.fullname = ''
    ACTION_CUSTOMER_VIEW.payload.email = ''
    dispatch(ACTION_CUSTOMER_VIEW)
}

let callCustomerDelete = (id, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.delete('/customer/' + id).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

export { callCustomerListGet, callCustomerViewGet, callCustomerPost, callCustomerPut, callCustomerDelete, callCustomerClearView, ACTION_CUSTOMER_LIST, ACTION_CUSTOMER_VIEW }