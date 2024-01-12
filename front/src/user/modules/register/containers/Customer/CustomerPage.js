import { connect } from 'react-redux'
import { Route, Routes } from 'react-router'
import CustomerList from './CustomerList'
import CustomerEdit from './CustomerEdit'
import { useState } from 'react'
import Sidebar from '../../../../../common/containers/Sidebar'
import Card from '../../../../../common/containers/Card'

let CustomerPage = () => {
    const [pageAttr, setPageAttr] = useState({})

    return (
        <Sidebar pWidth='80%'>
            <Card {...pageAttr} closeTo='/'>
                <Routes>
                    <Route path='/edit/:id' element={<CustomerEdit setPageAttr={setPageAttr} />} />
                    <Route path='/add' element={<CustomerEdit setPageAttr={setPageAttr} />} />
                    <Route index element={<CustomerList setPageAttr={setPageAttr} />} />
                </Routes>
            </Card>
        </Sidebar>
    )
}

export default connect()(CustomerPage)