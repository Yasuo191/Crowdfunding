import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";

function CreateCampaign() {
    const navigate = useNavigate();
    const [form, setForm] = useState({
        title: "", description: "", target: "", startDate: "", endDate: ""
    });

    const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

    const submit = async e => {
        e.preventDefault();
        try {
            const res = await api.post("campaign_create.php", {
                title: form.title,
                description: form.description,
                target_amount: form.target,
                start_date: form.startDate,
                end_date: form.endDate
            });
            alert(res.data.message);
            navigate("/dashboard");
        } catch (err) {
            console.log(err);
            alert(err.response?.data?.message || "Tạo chiến dịch thất bại");
        }
    };

    return (
        <div style={{ padding: 20 }}>
            <h2>Tạo chiến dịch</h2>
            <form onSubmit={submit}>
                <input name="title" placeholder="Tên chiến dịch" value={form.title} onChange={handleChange} />
                <br /><br />
                <textarea name="description" placeholder="Mô tả" value={form.description} onChange={handleChange} />
                <br /><br />
                <input type="number" name="target" placeholder="Mục tiêu" value={form.target} onChange={handleChange} />
                <br /><br />
                <input type="date" name="startDate" value={form.startDate} onChange={handleChange} />
                <br /><br />
                <input type="date" name="endDate" value={form.endDate} onChange={handleChange} />
                <br /><br />
                <button>Tạo chiến dịch</button>
            </form>
        </div>
    );
}

export default CreateCampaign;
