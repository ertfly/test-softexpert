import { Link } from 'react-router-dom'

let Card = ({ title, caption, btns = [], tabs = [], children, showClose = true, closeTo = '/' }) => {

    if (showClose) {
        btns.push({
            type: 'link_icon',
            class: 'btn btn-secondary',
            icon: 'fas fa-times',
            to: `${closeTo}?v=${(new Date()).getMilliseconds()}`
        })
    }

    return (
        <div className='container-fluid'>
            <div className='row'>
                <div className='col-md-12 mt-3 mb-3'>
                    <div className="card">
                        <div className="card-body">
                            <div className="d-flex justify-content-between">
                                <div>
                                    <h2 className="card-title">{title}</h2>
                                    <p className="card-text">{caption}</p>
                                </div>
                                <div>
                                    {btns.map((a, ai) => {
                                        switch (a.type) {
                                            case 'button':
                                                return <button key={ai} className={a.class + (ai > 0 ? ' ml-3' : '')} type="button" onClick={e => { e.preventDefault(); a.click() }}>{a.icon ? <i className={'mr-1 ' + a.icon}></i> : <></>}{a.label}</button>
                                            case 'button_icon':
                                                return <button key={ai} className={a.class + (ai > 0 ? ' ml-3' : '')} type="button" onClick={e => { e.preventDefault(); a.click() }}><i className={a.icon}></i></button>
                                            case 'info':
                                                return (
                                                    <span key={ai} className={a.class + (ai > 0 ? ' ml-3' : '')}>{a.label}</span>
                                                )
                                            case 'link':
                                                return (
                                                    <Link key={ai} className={a.class + (ai > 0 ? ' ml-3' : '')} to={a.to}><i className={'mr-1 ' + a.icon}></i>{a.label}</Link>
                                                )
                                            case 'link_icon':
                                                return (
                                                    <Link key={ai} className={a.class + (ai > 0 ? ' ml-3' : '')} to={a.to}><i className={a.icon}></i></Link>
                                                )
                                            default:
                                                return null
                                        }
                                    })}
                                </div>
                            </div>
                            <ul className="nav nav-tabs mt-4">
                                {tabs.map((a, ai) => {
                                    if (a.type === undefined) {
                                        a.type = 'link'
                                    }

                                    switch (a.type) {
                                        case 'btn':
                                            return (
                                                <li className="nav-item" key={ai}>
                                                    <Link className={'nav-link' + (a.active ? ' active' : '')} to={'#'} onClick={a.click}>{a.label}</Link>
                                                </li>
                                            )
                                        case 'link':
                                            return (
                                                <li className="nav-item" key={ai}>
                                                    <Link className={'nav-link' + (a.active ? ' active' : '')} to={a.to}>{a.label}</Link>
                                                </li>
                                            )
                                        default:
                                            return <></>
                                    }
                                })}
                            </ul>
                            <div className="tabcontent-border">{children}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Card