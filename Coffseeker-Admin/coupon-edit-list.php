<?php
$page = $_GET["page"] ?? 1;
$type = $_GET["type"] ?? 1;
require_once("../db_connect.php");

$sqlTotal = "SELECT coupon_id FROM coupon WHERE coupon_valid";
$resultTotal = $conn->query($sqlTotal);
$totalCoupon = $resultTotal->num_rows;

$perPage = 5;
$startItem = ($page - 1) * $perPage;
$totalPage = ceil($totalCoupon / $perPage);

if ($type == 1) {
    $orderBy = "AND coupon_valid";
} elseif ($type == 2) {
    $orderBy = "ORDER BY coupon_id DESC";
} elseif ($type == 3) {
    $orderBy = "ORDER BY expires_at ASC";
} elseif ($type == 4) {
    $orderBy = "ORDER BY expires_at DESC";
} elseif ($type == 5) {
    $orderBy = "AND coupon_valid = 1";
} elseif ($type == 6) {
    $orderBy = "AND coupon_valid = -1";
} else {
    header("location: 404.php");
}

$sqlTotal = "SELECT coupon_id FROM coupon WHERE coupon_valid $orderBy";
$resultTotal = $conn->query($sqlTotal);
$totalCoupon = $resultTotal->num_rows;

$sql = "SELECT coupon_id, coupon_name, coupon_code, coupon_valid, discount_type, discount_value, created_at, expires_at, updated_at, max_usage, usage_restriction, valid_description FROM coupon WHERE coupon_valid $orderBy LIMIT $startItem, $perPage";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>所有優惠卷清單</title>

    <?php include("modal/template.php") ?>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include("modal/sidebar.php") ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include("modal/topbar.php") ?>
                <!-- ↓↓放置內容↓↓-->
                <h1 class="text-center">所有優惠卷清單</h1>
                <div class="container">
                    <div class="py-2">
                        <form action="coupon-search.php">
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="請輸入優惠卷名稱" name="coupon_name">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-warning" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    $coupon_count = $result->num_rows;
                    ?>
                    <div class="py-2 d-flex justify-content-between align-items-center">
                        <a class="btn btn-warning" href="coupon-create.php">新增</a>
                        <div class="">
                            <a href="Coupon-edit-list.php?page=<?= $page ?>&type=1" class="btn btn-warning 
        <?php
        if ($type == 1) echo "active fw-bolder";
        ?>">所有項目<i class="fa-solid"></i></i></a>
                            <a href="Coupon-edit-list.php?page=<?= $page ?>&type=5" class="btn btn-warning 
        <?php
        if ($type == 5) echo "active fw-bolder";
        ?>">可使用<i class="fa-solid"></i></i></a>
                            <a href="Coupon-edit-list.php?page=<?= $page ?>&type=6" class="btn btn-warning 
        <?php
        if ($type == 6) echo "active fw-bolder";
        ?>">已停用<i class="fa-solid"></i></i></a>
                            <a href="Coupon-edit-list.php?page=<?= $page ?>&type=3" class="btn btn-warning 
        <?php
        if ($type == 3) echo "active fw-bolder";
        ?>">到期日 <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="Coupon-edit-list.php?page=<?= $page ?>&type=4" class="btn btn-warning 
        <?php
        if ($type == 4) echo "active fw-bolder";
        ?>">到期日<i class="fa-solid fa-arrow-down-wide-short"></i></i></a>
                        </div>
                    </div>
                    <div class="py-2 d-flex justify-content-end">
                        <div>
                            共 <?= $totalCoupon ?> 張, 第 <?= $page ?> 頁
                        </div>
                    </div>
                    <?php
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>優惠卷名稱</th>
                                <th>優惠卷代碼</th>
                                <th>優惠卷狀態</th>
                                <th>優惠卷種類</th>
                                <th>優惠卷面額</th>
                                <th>登錄時間</th>
                                <th>到期日</th>
                                <th>最後更新</th>
                                <th>可使用次數</th>
                                <th>優惠卷使用條件</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?= $row["coupon_id"] ?></td>
                                    <td><?= $row["coupon_name"] ?></td>
                                    <td><?= $row["coupon_code"] ?></td>
                                    <td><?= $row["valid_description"] ?></td>
                                    <td><?= $row["discount_type"] ?></td>
                                    <td><?= $row["discount_value"] ?></td>
                                    <td><?= $row["created_at"] ?></td>
                                    <td><?= $row["expires_at"] ?></td>
                                    <td><?= $row["updated_at"] ?></td>
                                    <td><?= $row["max_usage"] ?></td>
                                    <td><?= $row["usage_restriction"] ?></td>
                                    <td>
                                        <a href="Coupon-edit.php?coupon_id=<?= $row["coupon_id"] ?>" class="btn btn-warning">編輯</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>

                                <li class="page-item">
                                    <a class="page-link" href="Coupon-edit-list.php?page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a>
                                </li>

                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
                <!-- ↑↑放置內容↑↑ -->
            </div>
            <!-- End of Main Content -->
            <?php include("modal/footer.php") ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>