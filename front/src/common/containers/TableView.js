import moment from "moment"
import { Link } from "react-router-dom"

let TableView = ({ headers = [], rows = [], total = null, pagination = null, paginationTo = '/' }) => {
    moment.locale('pt-br')
    return (
        <div className="table-responsive">
            <table className="table table-hover table-striped">
                <thead>
                    <tr>
                        {headers.map((a, ai) => <th key={ai} className={'text-' + a.align} style={{ ...a.style ?? {} }}>{a.label}</th>)}
                    </tr>
                </thead>
                <tbody>
                    {rows.map((a, ai) => (
                        <tr key={ai}>
                            {headers.map((b, bi) => {
                                switch (b.type) {
                                    case 'info':
                                        return <td key={bi} className={'text-' + b.align}>{a[b.name]}</td>
                                    case 'datetime':
                                        let date = a[b.name]
                                        if(date){
                                            date = date.replace(/T/igm,' ').replace(/Z/igm,'')
                                        }
                                        return <td key={bi} className={'text-' + b.align}>{moment(date).format("DD/MM/YYYY HH:mm")}</td>
                                    case 'custom':
                                        return <td key={bi} className={'text-' + b.align}>{b.custom(a)}</td>
                                    default:
                                        return <></>
                                }
                            })}
                        </tr>
                    ))}
                    {rows.length <= 0 ? (
                        <tr>
                            <td colSpan={headers.length}>Nenhum registro encontrado!</td>
                        </tr>
                    ) : <></>}
                </tbody>
                {total !== null || pagination !== null ? (
                    <tfoot>
                        <tr>
                            <td colSpan={20}>
                                <div className="clearfix">
                                    {total !== null ? <div className="float-left">{total} registro(s) encontrado(s).</div> : <></>}
                                    {pagination !== null ? (
                                        <nav className="float-right">
                                            <nav aria-label="Paginação">
                                                <ul className="pagination">
                                                    {pagination.map((a, ai) => {
                                                        return (
                                                            <li key={ai} className={'page-item' + (a.active ? ' active' : '')}>
                                                                <Link className="page-link" to={`${paginationTo}${paginationTo.indexOf('?') !== -1 ? '&' : '?'}pg=${a.pg}`} dangerouslySetInnerHTML={{ __html: a.content }} />
                                                            </li>
                                                        )
                                                    })}
                                                </ul>
                                            </nav>
                                        </nav>
                                    ) : <></>}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                ) : <></>}
            </table>
        </div>
    )
}

export default TableView