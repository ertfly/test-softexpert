import { connect } from 'react-redux'
import { useEffect } from 'react'
import { bindActionCreators } from 'redux'
import { callProductCategoryListGet, callProductCategoryDelete, callProductCategoryClearView } from '../../actions/productCategories'
import { Link, useSearchParams } from 'react-router-dom'
import Swal from 'sweetalert2'
import TableView from '../../../../../common/containers/TableView'

let CategoryList = ({ setPageAttr, list, methods: { callProductCategoryListGet, callProductCategoryDelete, callProductCategoryClearView } }) => {
    let [searchParams] = useSearchParams();
    const remove = (id) => {
        Swal.fire({
            title: 'Tem certeza que deseja deletar? Essa ação não poderá ser desfeita!',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Sim',
            denyButtonText: `Não`,
        }).then((result) => {
            if (result.isConfirmed) {
                callProductCategoryDelete(id, () => {
                    let pg = searchParams.get('pg')
                    pg = pg ? pg : 1
                    callProductCategoryListGet({}, pg)
                })
            }
        })
    }
    const headers = [
        {
            type: 'info',
            name: 'name',
            align: 'left',
            label: 'Nome'
        },
        {
            type: 'info',
            name: 'fee',
            align: 'left',
            label: 'Taxa(%)'
        },
        {
            type: 'info',
            name: 'createdAt',
            align: 'right',
            label: 'Cadastro'
        },
        {
            type: 'custom',
            align: 'right',
            label: 'Opções',
            custom: (a) => {
                return (
                    <>
                        <Link to={'/products/categories/edit/' + a.id} className='btn btn-sm btn-primary'><i className='fas fa-edit'></i></Link>
                        <span className='btn btn-sm btn-danger ml-2' onClick={() => remove(a.id)}><i className='fas fa-trash'></i></span>
                    </>
                )
            }
        }
    ]

    useEffect(() => {
        callProductCategoryClearView()
        let pg = searchParams.get('pg')
        pg = pg ? pg : 1
        callProductCategoryListGet({}, pg)
    }, [callProductCategoryListGet, callProductCategoryClearView, searchParams])

    useEffect(() => {
        setPageAttr({
            title: 'Categoria de Produtos',
            caption: 'Gestão das categoria de produtos',
            btns: [
                {
                    type: 'link',
                    class: 'btn btn-primary',
                    icon: 'fas fa-plus',
                    label: 'Adicionar',
                    to: '/products/categories/add'
                }
            ],
            tabs: [
                {
                    active: true,
                    to: '/products/categories',
                    label: 'Informações'
                }
            ]
        })
    }, [setPageAttr])

    return (
        <TableView headers={headers} rows={list.rows} total={list.total} pagination={list.pagination} paginationTo={'/products/categories'} />
    )
}

const mapStateToProps = ({ product: { categories: { list } } }) => ({
    list: list,
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callProductCategoryListGet,
            callProductCategoryDelete,
            callProductCategoryClearView
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(CategoryList)