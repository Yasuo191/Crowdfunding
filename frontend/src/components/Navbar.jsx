import { Link, useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";

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

      {!user && (
        <>
          <Link to="/login">Đăng nhập</Link>
          <Link to="/register">Đăng ký</Link>
        </>
      )}

      {user && (
        <>
          <Link to="/dashboard">Dashboard</Link>
          {user.role === "admin" && <Link to="/admin">Admin</Link>}
          <button
            onClick={logout}
            style={{
              background: "#d32f2f",
              color: "white",
              border: "none",
              padding: "6px 12px",
              cursor: "pointer",
              borderRadius: "5px"
            }}
          >
            Đăng xuất
          </button>
        </>
      )}
    </nav>
  );
}

export default Navbar;
