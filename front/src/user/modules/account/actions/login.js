import Api from '../../../../axios'
import { callLoader } from '../../../../common/actions/app'
import { ACTION_APP_SESSION } from '../../../common/actions/app'

let callLoginPost = (data, callback = () => { }) => (dispatch) => {
    dispatch(callLoader(true))
    Api.post('/auth', data).then(data => {
        dispatch(callLoader(false))
        if (!data)
            return;

        ACTION_APP_SESSION.payload.logged = data.logged
        ACTION_APP_SESSION.payload.name = data.name
        dispatch(ACTION_APP_SESSION)

        callback()
    })
}

export { callLoginPost }