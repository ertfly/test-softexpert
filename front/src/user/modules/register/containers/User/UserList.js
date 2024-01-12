import { connect } from 'react-redux'
import { useEffect } from 'react'
import { bindActionCreators } from 'redux'
import { callUserListGet, callUserDelete, callUserClearView } from '../../actions/users'
import { Link, useSearchParams } from 'react-router-dom'
import Swal from 'sweetalert2'
import TableView from '../../../../../common/containers/TableView'

let UserList = ({ setPageAttr, list, methods: { callUserListGet, callUserDelete, callUserClearView } }) => {
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
                callUserDelete(id, () => {
                    let pg = searchParams.get('pg')
                    pg = pg ? pg : 1
                    callUserListGet({}, pg)
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
                        <Link to={'/users/edit/' + a.id} className='btn btn-sm btn-primary'><i className='fas fa-edit'></i></Link>
                        <span className='btn btn-sm btn-danger ml-2' onClick={() => remove(a.id)}><i className='fas fa-trash'></i></span>
                    </>
                )
            }
        }
    ]

    useEffect(() => {
        callUserClearView()
        let pg = searchParams.get('pg')
        pg = pg ? pg : 1
        callUserListGet({}, pg)
    }, [callUserListGet, callUserClearView, searchParams])

    useEffect(() => {
        setPageAttr({
            title: 'Usuários',
            caption: 'Gestão dos dados dos usuários',
            btns: [
                {
                    type: 'link',
                    class: 'btn btn-primary',
                    icon: 'fas fa-plus',
                    label: 'Adicionar',
                    to: '/users/add'
                }
            ],
            tabs: [
                {
                    active: true,
                    to: '/users',
                    label: 'Informações'
                }
            ]
        })
    }, [setPageAttr])

    return (
        <TableView headers={headers} rows={list.rows} total={list.total} pagination={list.pagination} paginationTo={'/users'} />
    )
}

const mapStateToProps = ({ register: { users: { list } } }) => ({
    list: list,
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            callUserListGet,
            callUserDelete,
            callUserClearView
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(UserList)