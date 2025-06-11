import { useStateContext } from "../contexts/contextProvider";
import { Link, Navigate, Outlet } from "react-router-dom";

export default function DefaultLayout() {
    const {user, token} = useStateContext()

    if(!token) {
        return <Navigate to="/login" />
    }

    const onLogout = (ev) => {
        ev.preventDefault()
    }

    return (
        <div id="defaultLayout">
            <aside>
                <Link to="/dashboard">Dashboard</Link>
                <Link to="/siswa">Siswa</Link>
                <Link to="/kota">Kota</Link>
            </aside>
            <div className="content">
                <header>
                    <div>
                        Header
                    </div>
                    <div>
                        {user.username}
                        <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
                    </div>
                </header>
                <main>
                    <Outlet />
                </main>
            </div>
        </div>
    )
}