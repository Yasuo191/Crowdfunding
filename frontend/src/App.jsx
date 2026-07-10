import { Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";
import CampaignDetail from "./pages/CampaignDetail";
import Dashboard from "./pages/Dashboard";
import Admin from "./pages/Admin";
import CreateCampaign from "./pages/CreateCampaign";
import EditCampaign from "./pages/EditCampaign";

function App() {
    return (
        <>
            <Navbar />
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/campaign/:id" element={<CampaignDetail />} />
                <Route path="/dashboard" element={<Dashboard />} />
                <Route
                        path="/edit-campaign/:id"
                        element={<EditCampaign />}
                    />
                    <Route
                        path="/admin"
                        element={<Admin/>}
                    />
                <Route path="/create-campaign" element={<CreateCampaign />} />
            </Routes>
        </>
    );
}

export default App;
