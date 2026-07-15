import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";
import { toast } from "sonner";
import "../styles/favorites.css";

function MyFavorites() {
  const [favorites, setFavorites] = useState([]);
  const navigate = useNavigate();
  const { user, loading } = useAuth();

  useEffect(() => {
    if (loading) return;

    if (!user) {
      toast.warning("Bạn cần đăng nhập để xem chiến dịch yêu thích");
      navigate("/login", { replace: true });
      return;
    }

    loadFavorites();
  }, [user, loading]);

  const loadFavorites = async () => {
    try {
      const res = await api.get("my_favorites.php");
      setFavorites(Array.isArray(res.data) ? res.data : []);
    } catch (err) {
      console.log(err);
      setFavorites([]);
      toast.error("Không thể tải danh sách yêu thích");
    }
  };

  return (
    <div style={{ padding: 20 }}>
      <div className="favorites-header">
        <h1>My Favorites</h1>
        <p>All campaigns you've saved in one place.</p>
      </div>

      {favorites.length === 0 ? (
        <div className="empty-state">
          <h2>No favorite campaigns yet</h2>
          <p>
            Save campaigns you care about and they'll appear here.
          </p>
        </div>
      ) : (
        <div className="campaign-grid">
          {favorites.map(c => (
            <div
              key={c.id}
              className="campaign-card"
            >
              <h3>{c.title}</h3>
              <p>{c.description}</p>
              <p>
                {Number(c.current_amount).toLocaleString()} /{" "}
                {Number(c.target_amount).toLocaleString()} VNĐ
              </p>
              <Link to={`/campaign/${c.id}`}>
                Xem chi tiết
              </Link>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

export default MyFavorites;
