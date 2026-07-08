import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";

function Login() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();

    const login = async () => {
        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);

        try {
            const res = await api.post("login.php", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            });

            alert(res.data.message);
            navigate("/");
        } catch (err) {
            console.log(err);
            if (err.response) {
                alert(err.response.data.message);
            } else {
                alert("Đăng nhập thất bại");
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
                onChange={(e) => setEmail(e.target.value)}
            />
            <br /><br />
            <input
                type="password"
                placeholder="Password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
            />
            <br /><br />
            <button onClick={login}>Đăng nhập</button>
        </div>
    );
}

export default Login;
