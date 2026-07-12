import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";

function CreateCampaign() {
    const navigate = useNavigate();
    const [form, setForm] = useState({
        title: "",
        description: "",
        target: "",
        startDate: "",
        endDate: ""
    });

    const [image, setImage] = useState(null);

    const handleChange = e =>
        setForm({ ...form, [e.target.name]: e.target.value });

    const submit = async e => {
        e.preventDefault();
        try {
            const formData = new FormData();
            formData.append("title", form.title);
            formData.append("description", form.description);
            formData.append("target_amount", form.target);
            formData.append("start_date", form.startDate);
            formData.append("end_date", form.endDate);

            if (image) {
                formData.append("image", image);
            }

            const res = await api.post("campaign_create.php", formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
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
                <input
                    name="title"
                    placeholder="Tên chiến dịch"
                    value={form.title}
                    onChange={handleChange}
                />
                <br /><br />
                <textarea
                    name="description"
                    placeholder="Mô tả"
                    value={form.description}
                    onChange={handleChange}
                />
                <br /><br />
                <input
                    type="number"
                    name="target"
                    placeholder="Mục tiêu"
                    value={form.target}
                    onChange={handleChange}
                />
                <br /><br />
                <input
                    type="date"
                    name="startDate"
                    value={form.startDate}
                    onChange={handleChange}
                />
                <br /><br />
                <input
                    type="date"
                    name="endDate"
                    value={form.endDate}
                    onChange={handleChange}
                />
                <br /><br />
                <input
                    type="file"
                    accept="image/*"
                    onChange={(e) => setImage(e.target.files[0])}
                />
                <br /><br />
                {image && (
                    <>
                        <img
                            src={URL.createObjectURL(image)}
                            alt="preview"
                            width="250"
                        />
                        <br /><br />
                    </>
                )}
                <button>Tạo chiến dịch</button>
            </form>
        </div>
    );
}

export default CreateCampaign;
