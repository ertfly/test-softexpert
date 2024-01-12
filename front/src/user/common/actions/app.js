import Api from '../../../axios'
import { callLoader } from '../../../common/actions/app';

let ACTION_APP_SESSION = {
    type: 'SESSION',
    payload: {
        logged: false,
        name: '',
    },
};

let callAuthGet = () => async (dispatch) => {
    dispatch(callLoader(true))
    await Api.get('/auth').then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_APP_SESSION.payload.logged = data.logged
        ACTION_APP_SESSION.payload.name = data.name
        dispatch(ACTION_APP_SESSION)
    })
}

let callAuthDelete = () => (dispatch) => {
    dispatch(callLoader(true))
    Api.delete('/auth').then((data) => {
        dispatch(callLoader(false))
        if (!data)
            return

        ACTION_APP_SESSION.payload.logged = false
        ACTION_APP_SESSION.payload.name = ''
        dispatch(ACTION_APP_SESSION)
        window.navigate('/account/login')
    })
}


export { callAuthGet, callAuthDelete, ACTION_APP_SESSION }