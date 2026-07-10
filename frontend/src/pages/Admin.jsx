import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";

function Admin() {
  const [campaigns, setCampaigns] = useState([]);
  const navigate = useNavigate();
  const { user, loading } = useAuth();

  useEffect(() => {
    if (loading) return;

    if (!user) {
      navigate("/login", { replace: true });
      return;
    }

    if (user.role !== "admin") {
      navigate("/", { replace: true });
      return;
    }

    loadCampaigns();
  }, [user, loading]);

  const loadCampaigns = async () => {
    try {
      const res = await api.get("campaign_list.php");
      setCampaigns(res.data);
    } catch (err) {
      console.log(err);
      setCampaigns([]);
    }
  };

  const action = async (url, id, confirmMsg) => {
    if (confirmMsg && !window.confirm(confirmMsg)) return;
    const form = new FormData();
    form.append("id", id);
    await api.post(url, form).catch(console.log);
    loadCampaigns();
  };

  return (
    <div style={{ padding: 20 }}>
      <h1>Admin Panel</h1>
      <table border="1" cellPadding="10">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          {campaigns.map(c => (
            <tr key={c.id}>
              <td>{c.id}</td>
              <td>{c.title}</td>
              <td>{c.status}</td>
              <td>
                {c.status === "pending" &&
                  <button onClick={() => action("approve_campaign.php", c.id)}>Duyệt</button>}
                {" "}
                {c.status !== "deleted" &&
                  <button onClick={() => action("delete_campaign.php", c.id, "Xóa chiến dịch?")}>Xóa</button>}
                {" "}
                {c.status === "deleted" &&
                  <button onClick={() => action("restore_campaign.php", c.id)}>Khôi phục</button>}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default Admin;
