import Api from '../../axios'

let ACTION_APP_LOADER = {
    type: 'LOADER',
    payload: true,
};

let callTokenPost = (callback=()=>{}) => async (dispatch) => {
    dispatch(callLoader(true))
    await Api.post('/token', {}).then((data) => {
        if (!data || !data.token)
            return

        localStorage.setItem('token', data.token)

        callback()
    })
    
}

let callLoader = (show = false) => (dispatch) => {
    ACTION_APP_LOADER.payload = show
    dispatch(ACTION_APP_LOADER)
}

export { callTokenPost, callLoader, ACTION_APP_LOADER }