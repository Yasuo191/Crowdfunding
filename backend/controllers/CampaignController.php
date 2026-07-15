<?php
require_once "../config/database.php";
require_once "../services/CampaignService.php";

class CampaignController
{
    private CampaignService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new CampaignService($pdo);
    }

    private function checkAuth()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["success"=>false,"message"=>"Bạn chưa đăng nhập"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

public function create()
{
    // Nếu $_POST rỗng thì thử đọc dữ liệu JSON từ body
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents("php://input"), true) ?? [];
    }

    $this->checkAuth();
    header("Content-Type: application/json; charset=UTF-8");

    $image = null;
    if (isset($_FILES["image"])) {
        $imageName = time()."_".basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/".$imageName);
        $image = $imageName;
    }

        $result = $this->service->createCampaign(
            $_SESSION["user_id"],
            $_POST["title"] ?? null,
            $_POST["description"] ?? null,
            $_POST["target_amount"] ?? 0,
            $image,
            $_POST["start_date"] ?? null,
            $_POST["end_date"] ?? null
        );

    if ($result === true) {
        echo json_encode(["success"=>true,"message"=>"Tạo chiến dịch thành công"], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode(["success"=>false,"message"=>$result], JSON_UNESCAPED_UNICODE);
    }
}

    public function index()
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($this->service->getAllCampaigns(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        header("Content-Type: application/json; charset=UTF-8");
        $campaign = $this->service->getCampaignById($id);
        if ($campaign) {
            echo json_encode($campaign, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["success"=>false,"message"=>"Không tìm thấy chiến dịch"], JSON_UNESCAPED_UNICODE);
        }
    }

public function update()
{
    $this->checkAuth();
    header("Content-Type: application/json; charset=UTF-8");

    // Lấy campaign hiện tại để giữ ảnh cũ nếu không upload mới
    $current = $this->service->getCampaignById($_POST["id"]);
    $imageUrl = $current["image_url"] ?? null;

    // Nếu có file ảnh mới
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $uploadPath = "../uploads/" . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
            $imageUrl = $fileName;
        }
    }

    $result = $this->service->updateCampaign(
    $_POST["id"] ?? null,
    $_SESSION["user_id"],
    $_POST["title"] ?? null,
    $_POST["description"] ?? null,
    $_POST["target_amount"] ?? 0,
    $_POST["start_date"] ?? null,
    $_POST["end_date"] ?? null,
    $imageUrl
);

if ($result === true) {
    echo json_encode([
        "success" => true,
        "message" => "Cập nhật thành công"
    ], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $result
    ], JSON_UNESCAPED_UNICODE);
}
}


public function delete()
{
    $this->checkAuth();
    header("Content-Type: application/json; charset=UTF-8");

    $result = $this->service->deleteCampaign($_POST["id"]??null, $_SESSION["user_id"], $_SESSION["role"]??"user");
    if ($result === true) {
        echo json_encode(["success"=>true,"message"=>"Xóa chiến dịch thành công"], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode(["success"=>false,"message"=>$result], JSON_UNESCAPED_UNICODE);
    }
}


    public function myCampaigns()
    {
        $this->checkAuth();
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($this->service->getMyCampaigns($_SESSION["user_id"]), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }

    public function search()
    {
        header("Content-Type: application/json; charset=UTF-8");
        $keyword = $_GET["keyword"]??"";
        $campaigns = $this->service->searchCampaign($keyword);

        if (empty($campaigns)) {
            http_response_code(404);
            echo json_encode(["success"=>false,"message"=>"Không tìm thấy chiến dịch"], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($campaigns, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }
    }

    public function adminCampaigns()
    {
        $this->checkAuth();
        if ($_SESSION["role"]!="admin") {
            http_response_code(403);
            echo json_encode(["success"=>false,"message"=>"Không có quyền"], JSON_UNESCAPED_UNICODE);
            exit;
        }
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($this->service->getAllCampaignsForAdmin(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }

public function restore()
{
    $this->checkAuth();
    if ($_SESSION["role"]!="admin") {
        http_response_code(403);
        echo json_encode(["success"=>false,"message"=>"Không có quyền"], JSON_UNESCAPED_UNICODE);
        exit;
    }
    header("Content-Type: application/json; charset=UTF-8");

    $result = $this->service->restoreCampaign($_POST["id"] ?? null);

    if ($result === true) {
        echo json_encode(["success"=>true,"message"=>"Khôi phục thành công"], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode([
            "success"=>false,
            "message"=>$result
        ], JSON_UNESCAPED_UNICODE);
    }
}

public function complete()
{
    $this->checkAuth();
    if ($_SESSION["role"]!="admin") {
        http_response_code(403);
        echo json_encode(["success"=>false,"message"=>"Không có quyền"], JSON_UNESCAPED_UNICODE);
        exit;
    }
    header("Content-Type: application/json; charset=UTF-8");

    $result = $this->service->completeCampaign($_POST["id"] ?? null);

    if ($result === true) {
        echo json_encode(["success"=>true,"message"=>"Chiến dịch đã hoàn thành"], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode([
            "success"=>false,
            "message"=>$result
        ], JSON_UNESCAPED_UNICODE);
    }
}
}
