import { useEffect, useState } from "react"
import { connect } from "react-redux"
import { Link, useParams } from "react-router-dom"
import { bindActionCreators } from "redux"
import { callUserViewGet, callUserPost, callUserPut } from "../../actions/users"

let UserEdit = ({ setPageAttr, methods: { callUserPost, callUserViewGet, callUserPut }, view }) => {
    const params = useParams()
    const [id] = useState(!params.id ? '' : params.id)
    const [fullname, setFullname] = useState('')
    const [email, setEmail] = useState('')
    const [pass, setPass] = useState('')
    const [passConfirm, setPassConfirm] = useState('')

    useEffect(() => {
        let tabs
        if (!id) {
            tabs = [
                {
                    active: false,
                    to: '/users',
                    label: 'Informações'
                },
                {
                    active: true,
                    to: '/users/add',
                    label: 'Adicionar'
                }
            ]
        } else {
            callUserViewGet(id)
            tabs = [
                {
                    active: false,
                    to: '/users',
                    label: 'Informações'
                },
                {
                    active: true,
                    to: '/users/edit/' + id,
                    label: 'Editar'
                }
            ]
        }

        setPageAttr({
            title: 'Usuário - ' + (!id ? 'Novo' : 'Editar'),
            caption: 'Preencha os campos para inserir as informações',
            btns: [],
            tabs: tabs
        })
    }, [setPageAttr, id, callUserViewGet])

    useEffect(() => {
        setFullname(view.fullname)
        setEmail(view.email)
    }, [view])

    const finishedSubmit = () => {
        setFullname('')
        setEmail('')
        setPass('')
        setPassConfirm('')
        window.navigate('/users')
    }

    const submit = (e) => {
        e.preventDefault()

        let data = {
            fullname,
            email,
            pass,
            passConfirm
        }

        if (!id) {
            callUserPost(data, () => finishedSubmit())
        } else {
            callUserPut(id, data, () => finishedSubmit())
        }
    }

    return (
        <form onSubmit={submit}>
            <div className="form-row">
                <div className="col-md-12">
                    <div className="form-row">
                        <div className="col-md-6 form-group">
                            <label className="required">Nome Completo:</label>
                            <input type="text" className="form-control" value={fullname} onChange={e => setFullname(e.target.value)} />
                        </div>
                        <div className="col-md-6 form-group">
                            <label className="required">E-mail:</label>
                            <input type="email" className="form-control" value={email} onChange={e => setEmail(e.target.value)} />
                        </div>
                        <div className="col-md-6 form-group">
                            <label className="required">Senha:</label>
                            <input type="password" className="form-control" value={pass} onChange={e => setPass(e.target.value)} />
                        </div>
                        <div className="col-md-6 form-group">
                            <label className="required">Confirmar Senha:</label>
                            <input type="password" className="form-control" value={passConfirm} onChange={e => setPassConfirm(e.target.value)} />
                        </div>
                    </div>
                </div>
            </div>
            <div className="clearfix text-left mt-3">
                <button className="btn btn-primary" type="submit"><i className="mr-1 fas fa-save fa-white"></i>Salvar</button>
                <Link to={'/users'} className="btn btn-secondary ml-3"><i className="fas fa-arrow-left mr-1"></i>Voltar</Link>
            </div>
        </form>
    )
}

const mapStateToProps = ({ register: { users: { view } } }) => ({
    view: view,
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callUserViewGet,
            callUserPost,
            callUserPut,
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(UserEdit)