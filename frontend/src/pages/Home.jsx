import { useEffect, useState } from "react";
import api from "../services/api";
import { Link } from "react-router-dom";
import "../styles/home.css";

function Home() {
    const [campaigns, setCampaigns] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);

    const pageSize = 6;
    const last = currentPage * pageSize;
    const first = last - pageSize;
    const displayCampaigns = campaigns.slice(first, last);
    const totalPages = Math.ceil(campaigns.length / pageSize);

    useEffect(() => {
        api.get("campaign_list.php")
            .then(res => setCampaigns(res.data))
            .catch(err => console.log(err));
    }, []);

    return (
        <div className="container fade-up">
            {/* Hero Section */}
            <div className="card hero">
                <h1>
                    Support Community Projects
                </h1>
                <p>
                    Discover trusted fundraising campaigns and help
                    people turn meaningful ideas into reality.
                </p>
                <button
                    onClick={() =>
                        document
                            .getElementById("campaign-grid")
                            ?.scrollIntoView({
                                behavior: "smooth",
                            })
                    }
                >
                    Explore Campaigns
                </button>
            </div>

            {/* Section Title */}
            <h2 className="section-title">
                Active Campaigns
            </h2>

            {/* Campaign Grid */}
            <div id="campaign-grid" className="campaign-grid">
                {displayCampaigns.map(campaign => {
                    const progress = Math.min(
                        (campaign.current_amount / campaign.target_amount) * 100,
                        100
                    ).toFixed(2);

                    return (
                        <div key={campaign.id} className="card campaign-card">
                            {campaign.image_url && (
                                <img
    className="campaign-image"
    src={`http://localhost/crowdfunding/backend/uploads/${campaign.image_url}`}
    alt={campaign.title}
/>
                            )}

                            <div className="campaign-body">
                                <h3 className="campaign-title">
                                    {campaign.title}
                                </h3>
                                <span className="campaign-status">
                                    {campaign.status}
                                </span>
                                <div className="campaign-money">
                                    {Number(campaign.current_amount).toLocaleString()}đ /
                                    {Number(campaign.target_amount).toLocaleString()}đ
                                </div>

                                <div className="campaign-progress">
                                    <div className="progress-track">
                                        <div
                                            className="progress-fill"
                                            style={{ width: `${progress}%` }}
                                        ></div>
                                    </div>
                                    <div className="progress-percent">
                                        {progress}%
                                    </div>
                                </div>

                                <Link to={`/campaign/${campaign.id}`}>
                                    <button className="detail-btn">
                                        Xem chi tiết
                                    </button>
                                </Link>
                            </div>
                        </div>
                    );
                })}
            </div>

            {/* Pagination */}
            <div className="pagination">
                <button
                    disabled={currentPage === 1}
                    onClick={() => setCurrentPage(currentPage - 1)}
                >
                    Previous
                </button>

                {Array.from({ length: totalPages }, (_, i) => (
                    <button
                        key={i}
                        className={currentPage === i + 1 ? "active" : ""}
                        onClick={() => setCurrentPage(i + 1)}
                    >
                        {i + 1}
                    </button>
                ))}

                <button
                    disabled={currentPage === totalPages}
                    onClick={() => setCurrentPage(currentPage + 1)}
                >
                    Next
                </button>
            </div>
        </div>
    );
}

export default Home;
