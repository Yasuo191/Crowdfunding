import { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";
import { toast } from "sonner";   
import "../styles/login.css";


function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();
  const { user, loadProfile } = useAuth();

  useEffect(() => {
    if (user) navigate("/");
  }, [user, navigate]);

  const login = async () => {
    if (!email.trim() || !password.trim()) {
      setError("Vui lòng nhập đầy đủ thông tin.");
      toast.warning("Vui lòng nhập đầy đủ thông tin");
      return;
    }

    const formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    try {
      const res = await api.post("login.php", formData, {
        headers: { "Content-Type": "multipart/form-data" }
      });

      if (res.data.success) {
        await loadProfile();
        toast.success("Đăng nhập thành công");
        navigate("/");
      } else {
        setError(res.data.message);
        toast.error(res.data.message || "Sai email hoặc mật khẩu");
      }
    } catch (err) {
      if (err.response?.data?.message) {
        setError(err.response.data.message);
        toast.error(err.response.data.message);
      } else {
        setError("Không thể kết nối tới máy chủ.");
        toast.error("Không thể kết nối máy chủ");
      }
    }
  };

  return (
    <div className="login-page">
      <div className="login-card">
        <h1 className="login-title">
          Crowdfunding
        </h1>
        <p className="login-subtitle">
          Support meaningful community projects
        </p>

        <div className="login-group">
          <label>Email</label>
          <input
            type="email"
            placeholder="Email"
            value={email}
            onChange={(e) => {
              setEmail(e.target.value);
              setError("");
            }}
          />
        </div>

<div className="login-group">
  <label>Password</label>
  <input
    type="password"
    placeholder="Password"
    value={password}
    onChange={(e) => {
      setPassword(e.target.value);
      setError("");
    }}
  />
</div>

{error && (
  <div className="login-error">
    {error}
  </div>
)}

<button
  className="login-btn"
  onClick={login}
>
  Sign In
</button>

<p className="login-footer">
  Don't have an account?{" "}
  <Link to="/register">
    Register
  </Link>
</p>
      </div>
    </div>
  );
}

export default Login;
