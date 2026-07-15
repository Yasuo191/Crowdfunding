import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import api from "../services/api";
import { toast } from "sonner";
import "../styles/campaign-detail.css";

function CampaignDetail() {
  const { id } = useParams();
  const [campaign, setCampaign] = useState(null);
  const [donations, setDonations] = useState([]);
  const [amount, setAmount] = useState("");
  const [message, setMessage] = useState("");
  const [favorite, setFavorite] = useState(false);

  const [comments, setComments] = useState([]);
  const [content, setContent] = useState("");

  useEffect(() => {
    loadCampaign();
    loadDonations();
    loadFavorite();
    loadComments();
  }, [id]);

  const loadCampaign = async () => {
    try {
      const res = await api.get("campaign_detail.php?id=" + id);
      setCampaign(res.data);
    } catch (err) {
      console.log(err);
      toast.error("Không thể tải thông tin chiến dịch");
    }
  };

  const loadDonations = async () => {
    try {
      const res = await api.get("campaign_donations.php?id=" + id);
      if (Array.isArray(res.data)) {
        setDonations(res.data);
      } else {
        setDonations([]);
      }
    } catch (err) {
      console.log(err);
      toast.error("Không thể tải lịch sử quyên góp");
    }
  };

  const loadFavorite = async () => {
    try {
      const res = await api.get(`is_favorite.php?campaign_id=${id}`);
      setFavorite(res.data.favorite);
    } catch (err) {
      console.log(err);
      toast.error("Không thể tải trạng thái yêu thích");
    }
  };

  const toggleFavorite = async () => {
    try {
      const formData = new FormData();
      formData.append("campaign_id", id);

      const res = await api.post("toggle_favorite.php", formData);
      setFavorite(res.data.status === "added");

      if (res.data.status === "added") {
        toast.success("Đã thêm vào yêu thích");
      } else {
        toast.success("Đã bỏ khỏi yêu thích");
      }
    } catch (err) {
      console.log(err);
      toast.error("Không thể thay đổi trạng thái yêu thích");
    }
  };

  const loadComments = async () => {
    try {
      const res = await api.get("get_comments.php?campaign_id=" + id);
      if (Array.isArray(res.data)) {
        setComments(res.data);
      } else {
        setComments([]);
      }
    } catch (err) {
      console.log(err);
      setComments([]);
      toast.error("Không thể tải bình luận");
    }
  };

  const addComment = async () => {
    if (!content.trim()) {
      toast.warning("Nhập nội dung bình luận");
      return;
    }

    try {
      const formData = new FormData();
      formData.append("campaign_id", id);
      formData.append("content", content);

      await api.post("add_comment.php", formData);

      toast.success("Đã gửi bình luận");
      setContent("");
      loadComments();
    } catch (err) {
      console.log(err);
      if (err.response?.data?.message) {
        toast.error(err.response.data.message);
      } else {
        toast.error("Không thể bình luận");
      }
    }
  };

  const donate = async () => {
    try {
      const formData = new FormData();
      formData.append("campaign_id", id);
      formData.append("amount", amount);
      formData.append("message", message);

      await api.post("donate.php", formData, {
        headers: { "Content-Type": "multipart/form-data" }
      });

      toast.success("Quyên góp thành công");
      window.location.reload();
    } catch (err) {
      console.log(err);
      if (err.response && err.response.data.message) {
        toast.error(err.response.data.message);
      } else {
        toast.error("Quyên góp thất bại");
      }
    }
  };

  if (!campaign) {
    return <h2>Đang tải...</h2>;
  }

  return (
    <div className="detail-container">
      <div className="detail-left">
        <h1>{campaign.title}</h1>
        <button onClick={toggleFavorite} style={{ marginBottom: "10px" }}>
          {favorite ? "💖 Bỏ yêu thích" : "🤍 Yêu thích"}
        </button>

        {campaign.image_url && (
          <img
            src={
              "http://localhost/crowdfunding/backend/uploads/" +
              campaign.image_url
            }
            width="500"
            alt=""
          />
        )}

        <p><b>Mô tả:</b> {campaign.description}</p>
        <p><b>Mục tiêu:</b> {campaign.target_amount} VNĐ</p>
        <p><b>Đã quyên góp:</b> {campaign.current_amount} VNĐ</p>

        <progress
          value={Math.min(
            Number(campaign.current_amount),
            Number(campaign.target_amount)
          )}
          max={campaign.target_amount}
          style={{ width: "100%", height: "25px" }}
        ></progress>

        <p>
          {Math.min(
            (campaign.current_amount / campaign.target_amount) * 100,
            100
          ).toFixed(2)}%
        </p>

        <p style={{ marginTop: "20px" }}>
          <b>Trạng thái:</b>{" "}
          {campaign.status === "active" && "Đang hoạt động"}
          {campaign.status === "pending" && "Đang chờ duyệt"}
          {campaign.status === "completed" && "✅ Đã hoàn thành"}
          {campaign.status === "deleted" && "🚫 Đã xóa"}
        </p>
      </div>

      <div className="detail-right">
        {campaign.status === "active" ? (
          <>
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
          </>
        ) : campaign.status === "completed" ? (
          <h2 style={{ color: "green" }}>✅ Chiến dịch đã hoàn thành</h2>
        ) : (
          <h2 style={{ color: "red" }}>🚫 Chiến dịch hiện không thể nhận quyên góp</h2>
        )}

        <hr />
        <h2>Lịch sử quyên góp</h2>
        {Array.isArray(donations) && donations.length > 0 ? (
          donations.map((donation) => (
            <div key={donation.id} className="donation-box">
              <p><b>Số tiền:</b> {Number(donation.amount).toLocaleString()} VNĐ</p>
              <p><b>Lời nhắn:</b> {donation.message}</p>
              <p><b>Ngày:</b> {donation.donated_at}</p>
            </div>
          ))
        ) : (
          <p>Chưa có lượt quyên góp.</p>
        )}

        <hr />
        <h2>Bình luận</h2>
        <textarea
          rows="3"
          style={{ width: "100%" }}
          placeholder="Nhập bình luận..."
          value={content}
          onChange={(e) => setContent(e.target.value)}
        />
        <br /><br />
        <button onClick={addComment}>Gửi bình luận</button>
        <br /><br />
        {comments.length > 0 ? (
          comments.map(comment => (
            <div key={comment.id} className="comment-box">
              <b>{comment.username}</b>
              <p>{comment.content}</p>
              <small>{comment.created_at}</small>
            </div>
          ))
        ) : (
          <p>Chưa có bình luận.</p>
        )}
      </div>
    </div>
  );
}

export default CampaignDetail;
