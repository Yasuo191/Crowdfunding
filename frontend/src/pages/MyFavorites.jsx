import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import api from "../services/api";
import { useAuth } from "../context/AuthContext";

function MyFavorites() {
    const [campaigns, setCampaigns] = useState([]);
    const navigate = useNavigate();
    const { user, loading } = useAuth();

    useEffect(() => {
        if (loading) return;

        if (!user) {
            navigate("/login", { replace: true });
            return;
        }

        loadFavorites();
    }, [user, loading]);

    const loadFavorites = async () => {
        try {
            const res = await api.get("my_favorites.php");
            setCampaigns(res.data);
        } catch (err) {
            console.log(err);
            setCampaigns([]);
        }
    };

    return (
        <div style={{ padding: 20 }}>
            <h1>Chiến dịch yêu thích</h1>

            {campaigns.length === 0 ? (
                <p>Chưa có chiến dịch yêu thích.</p>
            ) : (
                campaigns.map(c => (
                    <div
                        key={c.id}
                        style={{
                            border: "1px solid #ccc",
                            padding: 15,
                            marginBottom: 20
                        }}
                    >
                        <h3>{c.title}</h3>
                        <p>{c.description}</p>
                        <p>
                            {Number(c.current_amount).toLocaleString()}
                            {" / "}
                            {Number(c.target_amount).toLocaleString()} VNĐ
                        </p>
                        <Link to={`/campaign/${c.id}`}>
                            Xem chi tiết
                        </Link>
                    </div>
                ))
            )}
        </div>
    );
}

export default MyFavorites;
