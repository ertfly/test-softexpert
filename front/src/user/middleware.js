import { connect } from 'react-redux'
import { bindActionCreators } from 'redux';
import { ToastContainer } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css';
import { Navigate, Route, Routes } from 'react-router-dom';
import Loader from './../common/containers/Loader'
import { useEffect, useState } from 'react';
import { callTokenPost } from '../common/actions/app';
import { callAuthGet } from './common/actions/app';
import routes from './routes';
import Menu from './common/containers/Menu';


let Middleware = ({ loader, header, forceAuth, children, session, configMethods }) => {
    const {
        callTokenPost,
        callAuthGet
    } = configMethods
    const [first, setFirst] = useState(true)

    useEffect(() => {
        if (first) {
            setFirst(false)
            if (!localStorage.getItem('token')) {
                callTokenPost(() => {
                    callAuthGet()
                })
            } else {
                callAuthGet()
            }
        }
    }, [first, setFirst, callTokenPost, callAuthGet])

    if (session.logged === null) {
        return (
            <>
                <ToastContainer position="top-right" autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover />
                <Loader show={loader} />
            </>

        )
    }
    if (session.logged === false && forceAuth === true) {
        return <Navigate to={'/account/login'} />
    }

    if (session.logged !== false && forceAuth === false) {
        return <Navigate to={'/'} />
    }

    return (
        <>
            <Loader show={loader} />
            <ToastContainer position="bottom-left" autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover />
            <div className='wrapper-office'>
                {(header ?? null) ? header : <></>}
                {session.logged ? (
                    <>
                        <div className='menu'><Menu /></div>
                        {routes.length > 0 ?
                            (
                                <Routes>
                                    {routes.map((a, ai) => <Route path={a.path} key={ai} element={<a.container />} />)}
                                </Routes>
                            ) : <></>}
                        <div className='content'>{children}</div>
                    </>
                ) : (
                    children
                )}
            </div>
        </>
    )
}

const mapStateToProps = ({ app, office }) => ({
    session: office.session,
    loader: app.loader
});

const mapDispatchToProps = (dispatch) => ({
    configMethods: bindActionCreators(
        {
            callTokenPost,
            callAuthGet
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(Middleware)