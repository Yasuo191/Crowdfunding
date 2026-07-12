import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import api from "../services/api";

function CampaignDetail() {
    const { id } = useParams();
    const [campaign, setCampaign] = useState(null);
    const [donations, setDonations] = useState([]);
    const [amount, setAmount] = useState("");
    const [message, setMessage] = useState("");

    useEffect(() => {
        api.get("campaign_detail.php?id=" + id)
            .then((res) => {
                setCampaign(res.data);
            })
            .catch(err => {
                console.log(err);
            });

        api.get("campaign_donations.php?id=" + id)
            .then((res) => {
                if (Array.isArray(res.data)) {
                    setDonations(res.data);
                } else {
                    setDonations([]);
                }
            })
            .catch(err => {
                console.log(err);
            });
    }, [id]);

    const donate = async () => {
        try {
            const formData = new FormData();
            formData.append("campaign_id", id);
            formData.append("amount", amount);
            formData.append("message", message);

            const res = await api.post("donate.php", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            });

            alert(res.data.message);
            window.location.reload();
        } catch (err) {
    console.log(err);

    if (err.response && err.response.data.message) {
        alert(err.response.data.message);
    } else {
        alert("Quyên góp thất bại");
    }
}
    };

    if (!campaign) {
        return <h2>Đang tải...</h2>;
    }

    return (
        <div style={{ padding: "20px" }}>
            <h1>{campaign.title}</h1>
            {campaign.image_url && (
                <img
                    src={"http://localhost/crowdfunding/backend/uploads/" + campaign.image_url}
                    width="500"
                    alt=""
                />
            )}

            <hr />
            <p><b>Mô tả:</b> {campaign.description}</p>
            <p><b>Mục tiêu:</b> {campaign.target_amount} VNĐ</p>
            <p><b>Đã quyên góp:</b> {campaign.current_amount} VNĐ</p>

            <progress
                value={campaign.current_amount}
                max={campaign.target_amount}
                style={{ width: "100%", height: "25px" }}
            ></progress>

            <p>{((campaign.current_amount / campaign.target_amount) * 100).toFixed(2)}%</p>

            <hr />
            <h2>Quyên góp</h2>
            <input
                type="number"
                placeholder="Số tiền"
                value={amount}
                onChange={(e) => setAmount(e.target.value)}
            />
            <br /><br />
            <textarea
                placeholder="Lời nhắn"
                value={message}
                onChange={(e) => setMessage(e.target.value)}
            />
            <br /><br />
            <button onClick={donate}>Quyên góp</button>

            <hr />
            <h2>Lịch sử quyên góp</h2>
            {Array.isArray(donations) && donations.length > 0 ? (
                donations.map((donation) => (
                    <div key={donation.id} style={{ border: "1px solid #ccc", padding: "10px", marginBottom: "10px" }}>
                        <p><b>Số tiền:</b> {donation.amount} VNĐ</p>
                        <p><b>Lời nhắn:</b> {donation.message}</p>
                        <p><b>Ngày:</b> {donation.donated_at}</p>
                    </div>
                ))
            ) : (
                <p>Chưa có lượt quyên góp.</p>
            )}

            <p style={{ marginTop: "20px" }}>
                <b>Trạng thái:</b> {campaign.status}
            </p>
        </div>
    );
}

export default CampaignDetail;
