import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";

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
    console.log("login clicked"); // Bước 1

    if (!email.trim()) {
      console.log("empty email"); // Bước 2
      setError("Vui lòng nhập email.");
      return;
    }

    if (!password.trim()) {
      console.log("empty password"); // Bước 3
      setError("Vui lòng nhập mật khẩu.");
      return;
    }

    const formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    try {
      const res = await api.post("login.php", formData, {
        headers: { "Content-Type": "multipart/form-data" }
      });

      console.log("API response:", res.data); // log dữ liệu trả về từ backend

      if (res.data.success) {
        await loadProfile();
        alert("Đăng nhập thành công");
        navigate("/");
      } else {
        setError(res.data.message);
      }
    } catch (err) {
      console.log("API error:", err);
      if (err.response?.data?.message) {
        setError(err.response.data.message);
      } else {
        setError("Không thể kết nối tới máy chủ.");
      }
    }
  };

  return (
    <div style={{ padding: "30px" }}>
      <h1>Đăng nhập</h1>
      <br />
      <input
        type="email"
        placeholder="Email"
        value={email}
        onChange={e => setEmail(e.target.value)}
      />
      <br /><br />
      <input
        type="password"
        placeholder="Password"
        value={password}
        onChange={e => setPassword(e.target.value)}
      />
      <br /><br />
      <button onClick={login}>Đăng nhập</button>
      {error && (
        <p style={{ color: "red" }}>
          {error}
        </p>
      )}
    </div>
  );
}

export default Login;
