import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import api from "../services/api";
import "../styles/editCampaign.css";

function EditCampaign() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    title: "",
    description: "",
    target_amount: "",
    start_date: "",
    end_date: "",
    image_url: ""
  });
  const [image, setImage] = useState(null);
  const [imagePreview, setImagePreview] = useState("");

  useEffect(() => {
    api.get("campaign_detail.php?id=" + id).then(res => {
      setForm(res.data);
      if (res.data.image_url) {
        setImagePreview(res.data.image_url);
      }
    });
  }, [id]);

  const change = e => setForm({ ...form, [e.target.name]: e.target.value });

  const submit = async e => {
    e.preventDefault();
    const data = new FormData();
    Object.entries({ id, ...form }).forEach(([k, v]) => data.append(k, v));
    if (image) {
      data.append("image", image);
    }
try {
  const res = await api.post("update_campaign.php", data);
  console.log(res.data); 
  alert(res.data.message);
  navigate("/dashboard");
} catch (err) {
  alert(err.response?.data?.message || "Cập nhật thất bại");
}

  };

  return (
    <div className="container fade-up">
      <div className="edit-card">
        <div className="edit-header">
          <h1>Edit Campaign</h1>
          <p>Update your campaign information</p>
        </div>

        <div className="edit-layout">
          {/* Cột ảnh */}
          <div>
            {imagePreview && (
              <img
                src={imagePreview}
                className="edit-preview"
                alt="preview"
              />
            )}
          </div>

          {/* Cột form */}
          <div>
            <form onSubmit={submit}>
              <div className="form-group">
                <label>Campaign Title</label>
                <input
                  name="title"
                  value={form.title}
                  onChange={change}
                  placeholder="Tiêu đề"
                />
              </div>

              <div className="form-group">
                <label>Description</label>
                <textarea
                  name="description"
                  value={form.description}
                  onChange={change}
                  placeholder="Mô tả"
                />
              </div>

              <div className="form-group">
                <label>Target Amount</label>
                <input
                  type="number"
                  name="target_amount"
                  value={form.target_amount}
                  onChange={change}
                  placeholder="Số tiền mục tiêu"
                />
              </div>

              <div className="form-group">
                <label>Start Date</label>
                <input
                  type="date"
                  name="start_date"
                  value={form.start_date}
                  onChange={change}
                />
              </div>

              <div className="form-group">
                <label>End Date</label>
                <input
                  type="date"
                  name="end_date"
                  value={form.end_date}
                  onChange={change}
                />
              </div>

              <div className="form-group">
                <label>Campaign Image</label>
                <input
                  type="file"
                  accept="image/*"
                  onChange={(e) => {
                    const file = e.target.files[0];
                    setImage(file);
                    if (file) {
                      setImagePreview(URL.createObjectURL(file));
                    }
                  }}
                />
              </div>

              <button className="btn-save">Lưu thay đổi</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}

export default EditCampaign;
