import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";

function Register() {
    const navigate = useNavigate();

    const [username, setUsername] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errors, setErrors] = useState({});

    const register = async () => {
        setErrors({});

        try {
            const formData = new FormData();
            formData.append("username", username);
            formData.append("email", email);
            formData.append("password", password);

            const res = await api.post("register.php", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            });

            if (res.data.success) {
                alert(res.data.message);
                navigate("/login");
            }
        } catch (err) {
            console.log(err);
            if (err.response) {
                const data = err.response.data;
                setErrors({ [data.field]: data.message });
            } else {
                alert("Đăng ký thất bại");
            }
        }
    };

    return (
        <div style={{ padding: "30px" }}>
            <h1>Đăng ký</h1>
            <br />

            <input
                placeholder="Tên người dùng"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
            />
            {errors.username && <p style={{ color: "red" }}>{errors.username}</p>}
            <br /><br />

            <input
                type="email"
                placeholder="Email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
            />
            {errors.email && <p style={{ color: "red" }}>{errors.email}</p>}
            <br /><br />

            <input
                type="password"
                placeholder="Mật khẩu"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
            />
            {errors.password && <p style={{ color: "red" }}>{errors.password}</p>}
            <br /><br />

            <button onClick={register}>Đăng ký</button>
        </div>
    );
}

export default Register;
