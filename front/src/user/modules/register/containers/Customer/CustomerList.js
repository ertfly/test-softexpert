import { connect } from 'react-redux'
import { useEffect } from 'react'
import { bindActionCreators } from 'redux'
import { callCustomerListGet, callCustomerDelete, callCustomerClearView } from '../../actions/customers'
import { Link, useSearchParams } from 'react-router-dom'
import Swal from 'sweetalert2'
import TableView from '../../../../../common/containers/TableView'

let CustomerList = ({ setPageAttr, list, methods: { callCustomerListGet, callCustomerDelete, callCustomerClearView } }) => {
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
                callCustomerDelete(id, () => {
                    let pg = searchParams.get('pg')
                    pg = pg ? pg : 1
                    callCustomerListGet({}, pg)
                })
            }
        })
    }
    const headers = [
        {
            type: 'info',
            name: 'fullname',
            align: 'left',
            label: 'Nome Completo'
        },
        {
            type: 'info',
            name: 'email',
            align: 'left',
            label: 'E-mail'
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
                        <Link to={'/customers/edit/' + a.id} className='btn btn-sm btn-primary'><i className='fas fa-edit'></i></Link>
                        <span className='btn btn-sm btn-danger ml-2' onClick={() => remove(a.id)}><i className='fas fa-trash'></i></span>
                    </>
                )
            }
        }
    ]

    useEffect(() => {
        callCustomerClearView()
        let pg = searchParams.get('pg')
        pg = pg ? pg : 1
        callCustomerListGet({}, pg)
    }, [callCustomerListGet, callCustomerClearView, searchParams])

    useEffect(() => {
        setPageAttr({
            title: 'Clientes',
            caption: 'Gestão dos dados dos clientes',
            btns: [
                {
                    type: 'link',
                    class: 'btn btn-primary',
                    icon: 'fas fa-plus',
                    label: 'Adicionar',
                    to: '/customers/add'
                }
            ],
            tabs: [
                {
                    active: true,
                    to: '/customers',
                    label: 'Informações'
                }
            ]
        })
    }, [setPageAttr])

    return (
        <TableView headers={headers} rows={list.rows} total={list.total} pagination={list.pagination} paginationTo={'/customers'} />
    )
}

const mapStateToProps = ({ register: { customers: { list } } }) => ({
    list: list,
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callCustomerListGet,
            callCustomerDelete,
            callCustomerClearView
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(CustomerList)