import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";

function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();
  const { user, loadProfile } = useAuth();

  useEffect(() => {
    if (user) navigate("/");
  }, [user, navigate]);

  const login = async () => {
    const formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    try {
      const res = await api.post("login.php", formData, {
        headers: { "Content-Type": "multipart/form-data" }
      });

      await loadProfile();   // cập nhật context
      alert(res.data.message);
    } catch (err) {
      console.log(err);
      console.log(err.response);
      console.log(err.response?.data);
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
    </div>
  );
}

export default Login;
