import { connect } from 'react-redux'
import { Route, Routes } from 'react-router'
import UserList from './UserList'
import UserEdit from './UserEdit'
import { useState } from 'react'
import Sidebar from '../../../../../common/containers/Sidebar'
import Card from '../../../../../common/containers/Card'

let UserPage = () => {
    const [pageAttr, setPageAttr] = useState({})

    return (
        <Sidebar pWidth='80%'>
            <Card {...pageAttr} closeTo='/'>
                <Routes>
                    <Route path='/edit/:id' element={<UserEdit setPageAttr={setPageAttr} />} />
                    <Route path='/add' element={<UserEdit setPageAttr={setPageAttr} />} />
                    <Route index element={<UserList setPageAttr={setPageAttr} />} />
                </Routes>
            </Card>
        </Sidebar>
    )
}

export default connect()(UserPage)