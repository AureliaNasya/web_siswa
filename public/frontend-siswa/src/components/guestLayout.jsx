import { useStateContext } from "../contexts/contextProvider";
import { Navigate, Outlet } from "react-router-dom";

export default function GuestLayout() {
    const {token} = useStateContext()
    if(token) {
        return <Navigate to="/" />
    }
    return (
        <div>
            
            <Outlet />
        </div>
    )
}