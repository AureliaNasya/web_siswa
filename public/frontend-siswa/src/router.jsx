import {Navigate, createBrowserRouter} from "react-router-dom";
import Login from "./views/login.jsx";
import Kota from "./views/kota.jsx";
import Dashboard from "./views/dashboard.jsx";
import NotFound from "./views/notFound.jsx";
import DefaultLayout from "./components/defaultLayout.jsx";
import GuestLayout from "./components/guestLayout.jsx";
import Siswa from "./views/siswa.jsx";

const router = createBrowserRouter([
    {
        path: '/', element: <DefaultLayout />,
        children: [
            {
                path: '/dashboard', element: <Dashboard />
            },
            {
                path: '/kota', element: <Kota />
            },
            {
                path: '/siswa', element: <Siswa />
            },
            {
                path: '/', element: <Navigate to="/dashboard" />
            }
        ]
    },

    {
        path: '/', element: <GuestLayout />,
        children: [
            {
                path: '/login', element: <Login />
            }
        ]
    },
    
    
    {
        path: '*', element: <NotFound />
    },
])

export default router;