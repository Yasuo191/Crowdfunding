import { Link, NavLink, useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";
import "../styles/navbar.css";

function Navbar() {
  const navigate = useNavigate();
  const { user, loadProfile } = useAuth();

  const logout = async () => {
    try {
      await api.get("logout.php");
      await loadProfile();
      navigate("/login");
    } catch (err) {
      console.log(err);
      alert("Đăng xuất thất bại");
    }
  };

  const isAdmin = user && user.role === "admin";

  return (
    <nav className="navbar">
      <div className="navbar-container">
        <Link to="/" className="logo">
          Crowdfunding
        </Link>

        <div className="nav-links">
          <NavLink
            to="/"
            className={({ isActive }) => (isActive ? "active" : "")}
          >
            Home
          </NavLink>

          {user && (
            <>
              <NavLink
                to="/favorites"
                className={({ isActive }) => (isActive ? "active" : "")}
              >
                Favorites
              </NavLink>

              <NavLink
                to="/dashboard"
                className={({ isActive }) => (isActive ? "active" : "")}
              >
                Dashboard
              </NavLink>

              {isAdmin && (
                <NavLink
                  to="/admin"
                  className={({ isActive }) => (isActive ? "active" : "")}
                >
                  Admin
                </NavLink>
              )}

              <button onClick={logout}>Logout</button>

              <div className="user-box">
                <span className="avatar">
                  {user.username.charAt(0).toUpperCase()}
                </span>
                <span>👤 {user.username}</span>
              </div>
            </>
          )}

          {!user && (
            <>
              <NavLink
                to="/login"
                className={({ isActive }) => (isActive ? "active" : "")}
              >
                Login
              </NavLink>
              <NavLink
                to="/register"
                className={({ isActive }) => (isActive ? "active" : "")}
              >
                Register
              </NavLink>
            </>
          )}
        </div>
      </div>
    </nav>
  );
}

export default Navbar;
