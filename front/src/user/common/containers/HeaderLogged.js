import { Link } from 'react-router-dom'
import './../styles/HeaderLogged.css'
import Swal from 'sweetalert2'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'
import { callAuthDelete } from '../actions/app'

const HeaderLogged = ({ callAuthDelete, name }) => {
    const logout = () => {
        Swal.fire({
            title: 'Deseja se desconectar do sistema?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Sim',
            denyButtonText: `Não`,
        }).then((result) => {
            if (result.isConfirmed) {
                callAuthDelete()
            }
        })
    }

    return (
        <header className='px-3'>
            <div className="logo">
                <Link to={'/'} className='d-block'><img src="/assets/img/logo.png" alt="Test SoftExpert" className='img-fluid' /></Link>
            </div>
            <div className='icons d-flex justify-content-end flex-fill'>
                <div className='icons-item notification cursor-pointer'>
                    <i className='fas fa-bell'></i>
                </div>
                <div className='icons-item profile cursor-pointer'>
                    <i className='fas fa-user'></i>
                    <span>{name}</span>
                </div>
                <div className='icons-item logout cursor-pointer' onClick={logout}>
                    <i className='fas fa-sign-out-alt'></i>
                </div>
            </div>
        </header>
    )
}

const mapStateToProps = ({ office: { session } }) => ({
    name: session.name,
});

const mapDispatchToProps = (dispatch) =>
    bindActionCreators(
        {
            callAuthDelete
        },
        dispatch
    );


export default connect(mapStateToProps, mapDispatchToProps)(HeaderLogged)