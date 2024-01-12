import { Component } from "react";
import { Link } from "react-router-dom";

function Pagination({pagination, to}){
    return (
        <nav aria-label="Paginação">
            <ul className="pagination">
                {pagination.map((item, idx) => {
                    return (
                        <li key={`pag-${idx}`} className={'page-item' + (item.active ? ' active' : '')}>
                            <Link className="page-link" to={`${to}${to.indexOf('?') !== -1 ? '&' : '?'}pg=${item.pg}`} dangerouslySetInnerHTML={{ __html: item.content }} />
                        </li>
                    )
                })}
            </ul>
        </nav>
    )
}

export default Pagination