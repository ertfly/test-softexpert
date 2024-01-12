import { toast } from "react-toastify";
import Api from '../../../../axios'
import { callLoader } from '../../../../common/actions/app'

let ACTION_USER_LIST = {
    type: 'USER_LIST',
    payload: {
        rows: [],
        total: 0,
        pagination: [],
    },
};

let ACTION_USER_VIEW = {
    type: 'USER_VIEW',
    payload: {
        fullname: '',
        email: '',
    },
};

let callUserListGet = (filter = {}, pg = 1) => (dispatch) => {
    dispatch(callLoader(true))
    Api.get('/user?pg=' + pg).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_USER_LIST.payload.rows = data.rows
        ACTION_USER_LIST.payload.total = data.total
        ACTION_USER_LIST.payload.pagination = data.pagination
        dispatch(ACTION_USER_LIST)
    })
}

let callUserViewGet = (id) => (dispatch) => {
    dispatch(callLoader(true))
    Api.get('/user/' + id).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_USER_VIEW.payload.fullname = data.fullname
        ACTION_USER_VIEW.payload.email = data.email
        dispatch(ACTION_USER_VIEW)
    })
}

let callUserPost = (data, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.post('/user?urldecode=1', data).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

let callUserPut = (id, data, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.put('/user/' + id + '?urldecode=1', data).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

let callUserClearView = () => (dispatch) => {
    ACTION_USER_VIEW.payload.fullname = ''
    ACTION_USER_VIEW.payload.email = ''
    dispatch(ACTION_USER_VIEW)
}

let callUserDelete = (id, success = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.delete('/user/' + id).then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        toast.success(data.msg)
        success()
    })
}

export { callUserListGet, callUserViewGet, callUserPost, callUserPut, callUserDelete, callUserClearView, ACTION_USER_LIST, ACTION_USER_VIEW }