import { useEffect, useState } from "react"
import { connect } from "react-redux"
import { Link, useParams } from "react-router-dom"
import { bindActionCreators } from "redux"
import { callProductCategoryViewGet, callProductCategoryPost, callProductCategoryPut } from "../../actions/productCategories"
import InputMask from "../../../../../common/containers/InputMask"

let ProductEdit = ({ setPageAttr, methods: { callProductCategoryPost, callProductCategoryViewGet, callProductCategoryPut }, view }) => {
    const params = useParams()
    const [id] = useState(!params.id ? '' : params.id)
    const [name, setName] = useState('')
    const [fee, setFee] = useState('')

    useEffect(() => {
        let tabs
        if (!id) {
            tabs = [
                {
                    active: false,
                    to: '/products/categories',
                    label: 'Informações'
                },
                {
                    active: true,
                    to: '/products/categories/add',
                    label: 'Adicionar'
                }
            ]
        } else {
            callProductCategoryViewGet(id)
            tabs = [
                {
                    active: false,
                    to: '/products/categories',
                    label: 'Informações'
                },
                {
                    active: true,
                    to: '/products/categories/edit/' + id,
                    label: 'Editar'
                }
            ]
        }

        setPageAttr({
            title: 'Categoria de Produto - ' + (!id ? 'Novo' : 'Editar'),
            caption: 'Preencha os campos para inserir as informações',
            btns: [],
            tabs: tabs
        })
    }, [setPageAttr, id, callProductCategoryViewGet])

    useEffect(() => {
        setName(view.name)
        setFee(view.fee)
    }, [view])

    const finishedSubmit = () => {
        setName('')
        setFee('')
        window.navigate('/products/categories')
    }

    const submit = (e) => {
        e.preventDefault()

        let data = {
            name: encodeURI(name),
            fee: encodeURI(fee),
        }

        if (!id) {
            callProductCategoryPost(data, () => finishedSubmit())
        } else {
            callProductCategoryPut(id, data, () => finishedSubmit())
        }
    }

    return (
        <form onSubmit={submit}>
            <div className="form-row">
                <div className="col-md-12">
                    <div className="form-row">
                        <div className="col-md-6 form-group">
                            <label className="required">Nome:</label>
                            <input type="text" className="form-control" value={name} onChange={e => setName(e.target.value)} />
                        </div>
                        <div className="col-md-6 form-group">
                            <label className="required">Taxa(%):</label>
                            <InputMask mask="dec_2" value={fee} onChange={v => setFee(v)} />
                        </div>
                    </div>
                </div>
            </div>
            <div className="clearfix text-left mt-3">
                <button className="btn btn-primary" type="submit"><i className="mr-1 fas fa-save fa-white"></i>Salvar</button>
                <Link to={'/products/categories'} className="btn btn-secondary ml-3"><i className="fas fa-arrow-left mr-1"></i>Voltar</Link>
            </div>
        </form>
    )
}

const mapStateToProps = ({ product: { categories: { view } } }) => ({
    view: view,
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callProductCategoryViewGet,
            callProductCategoryPost,
            callProductCategoryPut,
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(ProductEdit)