import { connect } from 'react-redux'
import { Route, Routes } from 'react-router'
import ProductList from './ProductList'
import ProductEdit from './ProductEdit'
import { useState } from 'react'
import Sidebar from '../../../../../common/containers/Sidebar'
import Card from '../../../../../common/containers/Card'

let ProductPage = () => {
    const [pageAttr, setPageAttr] = useState({})

    return (
        <Sidebar pWidth='80%'>
            <Card {...pageAttr} closeTo='/'>
                <Routes>
                    <Route path='/edit/:id' element={<ProductEdit setPageAttr={setPageAttr} />} />
                    <Route path='/add' element={<ProductEdit setPageAttr={setPageAttr} />} />
                    <Route index element={<ProductList setPageAttr={setPageAttr} />} />
                </Routes>
            </Card>
        </Sidebar>
    )
}

export default connect()(ProductPage)