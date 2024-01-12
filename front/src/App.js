import { Routes, Route, useNavigate } from 'react-router-dom'
import { Provider } from "react-redux";
import storeOffice from "./user/store";
import OfficeMiddleware from "./user/middleware";
import UserHeaderLogged from './user/common/containers/HeaderLogged';
import UserDashboard from './user/modules/dashboard/containers/Dashboard';
import UserLogin from './user/modules/account/containers/Login';

function App() {
  window.navigate = useNavigate()
  return (
    <Routes>
      {/* Routes User */}
      <Route path="/account/login" exact element={
        <Provider store={storeOffice}>
          <OfficeMiddleware forceAuth={false} exact={true} header={null}>
            <UserLogin />
          </OfficeMiddleware>
        </Provider>} />
      <Route path="/*" index element={<Provider store={storeOffice}><OfficeMiddleware forceAuth={true} exact={true} header={<UserHeaderLogged />}><UserDashboard /></OfficeMiddleware></Provider>} />
    </Routes>
  );
}

export default App