import { useEffect, useState } from "react";
import api from "../services/api";
import MyCampaignCard from "../components/MyCampaignCard";
import { Link } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import "../styles/dashboard.css";

function Dashboard() {
  const { user } = useAuth();
  const [campaigns, setCampaigns] = useState([]);
  const [donations, setDonations] = useState([]);
  const [favorites, setFavorites] = useState([]);

  useEffect(() => {
    loadDashboard();
  }, []);

  const loadDashboard = async () => {
    api.get("my_campaigns.php")
      .then(res => setCampaigns(Array.isArray(res.data) ? res.data : []))
      .catch(() => setCampaigns([]));

    api.get("my_donations.php")
      .then(res => setDonations(Array.isArray(res.data) ? res.data : []))
      .catch(() => setDonations([]));

    api.get("my_favorites.php")
      .then(res => setFavorites(Array.isArray(res.data) ? res.data : []))
      .catch(() => setFavorites([]));
  };

  return (
    <div style={{ padding: "20px" }}>
      <div className="dashboard-header">
        <h1>Dashboard</h1>
        <p>
          Welcome back, <strong>{user?.username}</strong>
        </p>

        <div className="stats-grid">
          <div className="stat-card">
            <span>Campaigns</span>
            <h2>{campaigns.length}</h2>
          </div>
          <div className="stat-card">
            <span>Donations</span>
            <h2>{donations.length}</h2>
          </div>
          <div className="stat-card">
            <span>Favorites</span>
            <h2>{favorites.length}</h2>
          </div>
        </div>
      </div>

      {user?.role === "admin" && (
        <Link to="/admin">
          <button>Admin Panel</button>
        </Link>
      )}
      <Link to="/create-campaign">
        <button>Tạo chiến dịch</button>
      </Link>

      <hr />

      <h2>Thông tin tài khoản</h2>
      <p><b>ID:</b> {user?.id}</p>
      <p><b>Username:</b> {user?.username}</p>
      <p><b>Email:</b> {user?.email}</p>
      <p><b>Role:</b> {user?.role}</p>
      <hr />

      <h2>Chiến dịch của tôi</h2>
      {campaigns.length > 0 ? (
        campaigns.map(campaign => (
          <MyCampaignCard
            key={campaign.id}
            campaign={campaign}
            reload={loadDashboard}
          />
        ))
      ) : (
        <p>Bạn chưa tạo chiến dịch nào.</p>
      )}

      <hr />

      <h2>Lịch sử quyên góp</h2>
      {donations.length > 0 ? (
        donations.map(donation => (
          <div key={donation.id} className="donation-card">
            <p><b>Số tiền:</b> {donation.amount} VNĐ</p>
            <p><b>Lời nhắn:</b> {donation.message || "Không có lời nhắn"}</p>
          </div>
        ))
      ) : (
        <p>Bạn chưa thực hiện cuộc quyên góp nào.</p>
      )}
    </div>
  );
}

export default Dashboard;
