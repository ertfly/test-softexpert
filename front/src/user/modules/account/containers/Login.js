import { Link } from "react-router-dom"
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'
import '../styles/Login.css'
import { useState } from "react"
import { callLoginPost } from "../actions/login"

let Login = ({ methods: { callLoginPost } }) => {
    const [email, setEmail] = useState('')
    const [pass, setPass] = useState('')
    const [visible, setVisible] = useState(false)
    const submit = (e) => {
        e.preventDefault()
        callLoginPost({
            email: email,
            pass: pass
        }, () => {
            window.navigate('/')
        })
    }

    const toggleVisible = () => {
        if (visible) {
            setVisible(false)
        } else {
            setVisible(true)
        }
    }

    return (
        <div className="container-login d-flex align-items-stretch">
            <div className="img d-flex align-items-center shadow-video">

            </div>
            <div className="sdk d-flex flex-column p-4 pt-5">
                <div className="text-center"><Link to={'/account/login'} className="logo"><img src="/assets/img/logo.png" alt="Espartaco Soluções" /></Link></div>
                <div className="authfast-sdk mt-4">
                    <div className="box" style={{ width: '100%' }}>
                        <div className="login" style={{ flex: '1 1 0%', maxWidth: '340px' }}>
                            <div className="sign-up">
                                <form onSubmit={submit}>
                                    <div className="form-row">
                                        <div className="col-12 form-group input-group">
                                            <input type="email" placeholder="Digite seu e-mail" className="form-control bg-input" style={{ width: 'auto !important' }} onChange={(e) => setEmail(e.target.value)} value={email} />
                                        </div>
                                        <div className="col-md-12 form-group input-group">
                                            <input placeholder="Digite sua senha" type={visible ? 'text' : 'password'} className="form-control bg-input pass" style={{ width: 'auto !important' }} onChange={(e) => setPass(e.target.value)} value={pass} />
                                            <i className="input-group-text hide-pass" onClick={toggleVisible}>
                                                <i className={'fas ' + (visible ? 'fa-eye' : 'fa-eye-slash') + ' fa-2x'}></i>
                                            </i>
                                        </div>
                                        <div className="col-md-12">
                                            <button type="submit" className="btn btn-primary btn-block btn-lg">Acessar</button>
                                        </div>
                                        <div className="col-md-12 text-center">
                                            <Link to={'/'} className="mt-1"><small>Esqueceu a senha?</small></Link>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

const mapStateToProps = () => ({});
const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callLoginPost
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(Login)
