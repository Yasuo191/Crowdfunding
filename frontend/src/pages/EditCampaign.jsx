import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import api from "../services/api";

function EditCampaign() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    title: "", description: "", target_amount: "", start_date: "", end_date: ""
  });

  useEffect(() => { api.get("campaign_detail.php?id=" + id).then(res => setForm(res.data)); }, [id]);

  const change = e => setForm({ ...form, [e.target.name]: e.target.value });

  const submit = async e => {
    e.preventDefault();
    const data = new FormData();
    Object.entries({ id, ...form }).forEach(([k, v]) => data.append(k, v));
    try {
      const res = await api.post("update_campaign.php", data);
      alert(res.data.message);
      navigate("/dashboard");
    } catch (err) {
      alert(err.response?.data?.message || "Cập nhật thất bại");
    }
  };

  return (
    <div style={{ padding: 20 }}>
      <h2>Sửa chiến dịch</h2>
      <form onSubmit={submit}>
        <input name="title" value={form.title} onChange={change} /><br/><br/>
        <textarea name="description" value={form.description} onChange={change} /><br/><br/>
        <input type="number" name="target_amount" value={form.target_amount} onChange={change} /><br/><br/>
        <input type="date" name="start_date" value={form.start_date} onChange={change} /><br/><br/>
        <input type="date" name="end_date" value={form.end_date} onChange={change} /><br/><br/>
        <button>Lưu thay đổi</button>
      </form>
    </div>
  );
}

export default EditCampaign;
