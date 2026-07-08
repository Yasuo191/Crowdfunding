import { useEffect, useState } from "react";
import api from "../services/api";
import { Link } from "react-router-dom";
function Home() {

    const [campaigns, setCampaigns] = useState([]);

    useEffect(() => {

        api.get("campaign_list.php")
            .then((res) => {

                setCampaigns(res.data);

            })
            .catch((err) => {

                console.log(err);

            });

    }, []);

    return (

        <div style={{ padding: "20px" }}>

            <h1>Danh sách chiến dịch</h1>

            <hr />

            {
                campaigns.map((campaign) => (

                    <div
                        key={campaign.id}
                        style={{
                            border: "1px solid #ccc",
                            marginBottom: "15px",
                            padding: "15px"
                        }}
                    >

                        <h2>

    <Link to={`/campaign/${campaign.id}`}>

        {campaign.title}

    </Link>

</h2>

                        <p>{campaign.description}</p>

                        <p>
                            Mục tiêu:
                            {" "}
                            {campaign.target_amount} VNĐ
                        </p>

                        <p>
                            Đã quyên góp:
                            {" "}
                            {campaign.current_amount} VNĐ
                        </p>

                        <p>
                            Trạng thái:
                            {" "}
                            {campaign.status}
                        </p>

                    </div>

                ))
            }

        </div>

    );

}

export default Home;