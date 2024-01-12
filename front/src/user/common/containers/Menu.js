import { useEffect, useMemo, useState } from "react"
import { Link, useLocation } from "react-router-dom"

const Menu = () => {
    const [iMain, setIMain] = useState(0)
    const [iSub, setISub] = useState()
    const location = useLocation()

    const menu = useMemo(() => [
        {
            label: 'Tela Inicial',
            icon: 'fas fa-home',
            to: '/',
        },
        {
            label: 'Usuários',
            icon: 'fas fa-users',
            to: '/users',
        },
        {
            label: 'Clientes',
            icon: 'fas fa-cog',
            to: '/customers',
        },
        {
            label: 'Categoria de Produtos',
            icon: 'fas fa-cog',
            to: '/products/categories',
        },
        {
            label: 'Produtos',
            icon: 'fas fa-cog',
            to: '/products',
        },
    ], [])

    const openMain = (e, ai) => {
        setIMain(ai)
    }
    const openSub = (e, bi) => {
        setISub(bi)
    }

    useEffect(() => {
        let i = menu.findIndex((obj) => location.pathname === '/')
        if (i !== -1) {
            setISub(null)
            setIMain(0)
        }
    }, [location, menu])

    return (
        <ul className='nav'>
            {menu.map((a, ai) => (
                <li key={'main-' + ai} className={`${ai === iMain ? 'active' : ''}${ai === 0 ? ' home' : ''}`}>
                    {(a.child ?? []).length > 0 ? (
                        <>
                            <span onClick={e => openMain(e, ai)} className='link-main'><i className={a.icon}></i><span className="flex-fill">{a.label}</span><i className="fas fa-chevron-down"></i></span>
                            <ul className="sub">
                                {a.child.map((b, bi) => (
                                    <li key={'sub-' + bi} className={(iSub === bi ? 'active' : '')}>
                                        <Link onClick={e => openSub(e, bi)} className='link-sub' to={b.to}><i className={b.icon}></i><span className="flex-fill">{b.label}</span></Link>
                                    </li>
                                ))}
                            </ul>
                        </>
                    ) : (
                        <Link onClick={e => openMain(e, ai)} className="link-main" to={a.to ?? '/'}><i className={a.icon}></i><span className="flex-fill">{a.label}</span></Link>
                    )}
                </li>
            ))}
        </ul>
    )
}

export default Menu