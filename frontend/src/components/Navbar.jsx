import { Link } from "react-router-dom";

function Navbar() {

    return (

        <nav
            style={{
                background: "#1976d2",
                color: "white",
                padding: "15px",
                display: "flex",
                gap: "20px"
            }}
        >

            <Link to="/">Trang chủ</Link>

            <Link to="/login">Đăng nhập</Link>

            <Link to="/register">Đăng ký</Link>

            <Link to="/dashboard">Dashboard</Link>

            <Link to="/admin">Admin</Link>

        </nav>

    );

}

export default Navbar;