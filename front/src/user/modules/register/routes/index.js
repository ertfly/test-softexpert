import CustomerPage from "../containers/Customer/CustomerPage"
import UserPage from "../containers/User/UserPage"

let RegisterRoutes = [
    {
        path: 'customers/*',
        container: CustomerPage,
    },
    {
        path: 'users/*',
        container: UserPage,
    }
]

export default RegisterRoutes