import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";

function Admin() {
  const [campaigns, setCampaigns] = useState([]);
  const [users, setUsers] = useState([]);
  const [donations, setDonations] = useState([]);
  const [statistics, setStatistics] = useState(null);
  const [tab, setTab] = useState("campaign");

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
    loadUsers();
    loadDonations();
    loadStatistics();
  }, [user, loading]);

  const loadCampaigns = async () => {
    try {
      const res = await api.get("admin_all_campaigns.php");
      setCampaigns(res.data);
    } catch (err) {
      console.log(err);
      setCampaigns([]);
    }
  };

  const loadUsers = async () => {
    try {
      const res = await api.get("admin_users.php");
      setUsers(res.data);
    } catch (err) {
      console.log(err);
    }
  };

  const loadDonations = async () => {
    try {
      const res = await api.get("admin_donations.php");
      setDonations(res.data);
    } catch (err) {
      console.log(err);
    }
  };

  const loadStatistics = async () => {
    try {
      const res = await api.get("dashboard.php");
      setStatistics(res.data);
    } catch (err) {
      console.log(err);
    }
  };

  const action = async (url, id, confirmMsg) => {
    if (confirmMsg && !window.confirm(confirmMsg)) return;
    const form = new FormData();
    form.append("id", id);
    await api.post(url, form).catch(console.log);
    loadCampaigns();
  };

  const updateUserRole = async (u) => {
    const formData = new FormData();
    formData.append("id", u.id);
    formData.append("role", u.role === "admin" ? "user" : "admin");
    await api.post("update_role.php", formData).catch(console.log);
    loadUsers();
  };

  return (
    <div style={{ padding: 20 }}>
      <h1>Admin Dashboard</h1>

      {statistics && (
        <div
          style={{
            display: "flex",
            gap: "20px",
            margin: "20px 0",
            flexWrap: "wrap"
          }}
        >
          <div><b>Users</b><br />{statistics.total_users}</div>
          <div><b>Campaigns</b><br />{statistics.total_campaigns}</div>
          <div><b>Donations</b><br />{statistics.total_donations}</div>
          <div>
            <b>Total Amount</b><br />
            {Number(statistics.total_amount).toLocaleString()} VNĐ
          </div>
        </div>
      )}

      <div style={{ marginBottom: 20 }}>
        <button onClick={() => setTab("campaign")}>Chiến dịch</button>
        <button onClick={() => setTab("users")}>Người dùng</button>
        <button onClick={() => setTab("donations")}>Quyên góp</button>
      </div>

      {tab === "campaign" && (
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
                    <button onClick={() => action("approve_campaign.php", c.id)}>
                      Duyệt
                    </button>}
                  {" "}
                  {c.status === "approved" &&
                    <button
                      onClick={() =>
                        action("complete_campaign.php", c.id, "Hoàn thành chiến dịch?")
                      }
                    >
                      Hoàn thành
                    </button>}
                  {" "}
                  {c.status !== "deleted" &&
                    <button onClick={() => action("delete_campaign.php", c.id, "Ẩn chiến dịch?")}>
                      Ẩn
                    </button>}
                  {" "}
                  {c.status === "deleted" &&
                    <button onClick={() => action("restore_campaign.php", c.id)}>
                      Khôi phục
                    </button>}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}

      {tab === "users" && (
        <table border="1" cellPadding="10">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            {users.map(u => (
              <tr key={u.id}>
                <td>{u.id}</td>
                <td>{u.username}</td>
                <td>{u.email}</td>
                <td>{u.role}</td>
                <td>
                  {u.role === "user" &&
                    <button onClick={() => updateUserRole(u)}>Đặt làm Admin</button>}
                  {u.role === "admin" &&
                    <button onClick={() => updateUserRole(u)}>Đặt làm User</button>}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}

      {tab === "donations" && (
        <table border="1" cellPadding="10">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Campaign</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            {donations.map(d => (
              <tr key={d.id}>
                <td>{d.id}</td>
                <td>{d.username}</td>
                <td>{d.campaign_title}</td>
                <td>{d.amount}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}

export default Admin;
