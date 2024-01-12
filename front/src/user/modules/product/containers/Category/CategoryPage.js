import { connect } from 'react-redux'
import { Route, Routes } from 'react-router'
import CategoryList from './CategoryList'
import CategoryEdit from './CategoryEdit'
import { useState } from 'react'
import Sidebar from '../../../../../common/containers/Sidebar'
import Card from '../../../../../common/containers/Card'

let CategoryPage = () => {
    const [pageAttr, setPageAttr] = useState({})

    return (
        <Sidebar pWidth='80%'>
            <Card {...pageAttr} closeTo='/'>
                <Routes>
                    <Route path='/edit/:id' element={<CategoryEdit setPageAttr={setPageAttr} />} />
                    <Route path='/add' element={<CategoryEdit setPageAttr={setPageAttr} />} />
                    <Route index element={<CategoryList setPageAttr={setPageAttr} />} />
                </Routes>
            </Card>
        </Sidebar>
    )
}

export default connect()(CategoryPage)