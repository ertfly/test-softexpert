import { useEffect, useState } from "react"
import { connect } from "react-redux"
import { Link, useParams } from "react-router-dom"
import { bindActionCreators } from "redux"
import { callProductViewGet, callProductPost, callProductPut } from "../../actions/products"
import { callProductCategorySelectGet } from "../../actions/productCategories"
import InputMask from "../../../../../common/containers/InputMask"
import { Typeahead } from 'react-bootstrap-typeahead';
import 'react-bootstrap-typeahead/css/Typeahead.css';

let ProductEdit = ({ setPageAttr, methods: { callProductPost, callProductViewGet, callProductPut, callProductCategorySelectGet }, view, selectCategories }) => {
    const params = useParams()
    const [id] = useState(!params.id ? '' : params.id)
    const [categoryId, setCategoryId] = useState([])
    const [name, setName] = useState('')
    const [price, setPrice] = useState('')
    const [cost, setCost] = useState('')

    useEffect(() => {
        callProductCategorySelectGet()
        let tabs
        if (!id) {
            tabs = [
                {
                    active: false,
                    to: '/products',
                    label: 'Informações'
                },
                {
                    active: true,
                    to: '/products/add',
                    label: 'Adicionar'
                }
            ]
        } else {
            callProductViewGet(id)
            tabs = [
                {
                    active: false,
                    to: '/products',
                    label: 'Informações'
                },
                {
                    active: true,
                    to: '/products/edit/' + id,
                    label: 'Editar'
                }
            ]
        }

        setPageAttr({
            title: 'Produto - ' + (!id ? 'Novo' : 'Editar'),
            caption: 'Preencha os campos para inserir as informações',
            btns: [],
            tabs: tabs
        })
    }, [setPageAttr, id, callProductViewGet, callProductCategorySelectGet])

    useEffect(() => {
        setCategoryId([{ id: view.categoryId, description: view.category }])
        setName(view.name)
        setPrice(view.price)
        setCost(view.cost)
    }, [view])

    const finishedSubmit = () => {
        setCategoryId([])
        setName('')
        setPrice('')
        setCost('')
        window.navigate('/products')
    }

    const submit = (e) => {
        e.preventDefault()
        let data = {
            categoryId: categoryId.length>0 ? categoryId[0].id : '',
            name: encodeURI(name),
            price: price,
            cost: cost
        }

        if (!id) {
            callProductPost(data, () => finishedSubmit())
        } else {
            callProductPut(id, data, () => finishedSubmit())
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
                            <label className="required">Categoria</label>
                            <Typeahead
                                id="category"
                                labelKey="description"
                                onChange={(e) => setCategoryId(e)}
                                options={selectCategories}
                                placeholder="Selecione a categoria"
                                selected={categoryId}
                            />
                        </div>
                        <div className="col-md-6 form-group">
                            <label className="required">Preço(R$):</label>
                            <InputMask mask="dec_2" value={price} onChange={v => setPrice(v)} />
                        </div>
                        <div className="col-md-6 form-group">
                            <label className="required">Custo(R$):</label>
                            <InputMask mask="dec_2" value={cost} onChange={v => setCost(v)} />
                        </div>
                    </div>
                </div>
            </div>
            <div className="clearfix text-left mt-3">
                <button className="btn btn-primary" type="submit"><i className="mr-1 fas fa-save fa-white"></i>Salvar</button>
                <Link to={'/products'} className="btn btn-secondary ml-3"><i className="fas fa-arrow-left mr-1"></i>Voltar</Link>
            </div>
        </form>
    )
}

const mapStateToProps = ({ product: { products: { view }, categories } }) => ({
    view: view,
    selectCategories: categories.select
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callProductViewGet,
            callProductPost,
            callProductPut,
            callProductCategorySelectGet
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(ProductEdit)