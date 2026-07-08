import { Link } from "react-router-dom";
import api from "../services/api";

function MyCampaignCard({ campaign, reload }) {
    const remove = async () => {
        if (!window.confirm("Xóa chiến dịch?")) return;
        const form = new FormData();
        form.append("id", campaign.id);
        await api.post("delete_campaign.php", form).catch(console.log);
        reload();
    };

    return (
        <div style={{ border: "1px solid #ccc", padding: 15, marginBottom: 15, borderRadius: 10 }}>
            <h3>{campaign.title}</h3>
            <p>{campaign.description}</p>
            <p>{campaign.current_amount}/{campaign.target_amount}</p>
            <p><b>{campaign.status}</b></p>

            <Link to={`/campaign/${campaign.id}`}>Chi tiết</Link>{" | "}
            <Link to={`/edit-campaign/${campaign.id}`}>Sửa</Link>{" | "}
            <button onClick={remove}>Xóa</button>
        </div>
    );
}

export default MyCampaignCard;
