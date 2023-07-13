<?php
if (!isset($_GET["coupon_id"])) {
    // die("資料不存在");
    header("location: 404.php");
}
$id = $_GET["coupon_id"];

require_once("../db_connect.php");
$sql = "SELECT * FROM coupon WHERE coupon_id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>編輯優惠券</title>

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

                <h1 class="text-center">Coupon-Edit</h1>
                <!-- modal start -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id=""><?= $row["coupon_name"] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                確認刪除？
                            </div>
                            <div class="modal-footer">
                                <a href="action/coupon/doDelete.php?coupon_id=<?= $id ?>" class="btn btn-danger">確認</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end -->
                <div class="container">
                    <div class="m-2">
                        <form action="action/coupon/doUpdate.php" method="post">
                            <table class="table table-bordered ">
                                <input type="hidden" name="coupon_id" value="<?= $row["coupon_id"] ?>">
                                <tr>
                                    <th>優惠卷名稱</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["coupon_name"] ?>" name="coupon_name">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷狀態</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="coupon_valid" id="dcoupon_valid1" value="1">
                                            <label class="form-check-label" for="exampleRadios1">
                                                可使用
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="coupon_valid" id="coupon_valid2" value="-1">
                                            <label class="form-check-label" for="exampleRadios2">
                                                停用
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷類型</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_type" id="discount_type1" value="百分比">
                                            <label class="form-check-label" for="exampleRadios1">
                                                依售價百分比折價
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_type" id="discount_type2" value="金額">
                                            <label class="form-check-label" for="exampleRadios2">
                                                依優惠金額折價
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷折價百分比 / 優惠卷面額大小</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["discount_value"] ?>" name="discount_value">
                                    </td>
                                </tr>
                                <tr>
                                    <th>可使用次數</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["max_usage"] ?>" name="max_usage">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷到期日</th>
                                    <td>
                                        <input type="date" value="<?= $row["expries_at"] ?>" name="expries_at">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷使用條件</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["usage_restriction"] ?>" name="usage_restriction">
                                    </td>
                                </tr>
                            </table>
                            <div class="py-2 d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-success" type="submit">儲存</button>
                                    <a class="btn btn-success" href="Coupon-list.php?coupon_id=<?= $row["coupon_id"] ?>">取消</a>
                                </div>
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">刪除</button>
                            </div>
                        </form>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">

                </script>
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