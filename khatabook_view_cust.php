<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <title>Khatabook | View Customer</title>
</head>

<body>
    <?php
    include 'header.php';
    include_once 'dbCon.php';
    $con = OpenCon();
    if (isset($_POST['edit_trans_id'])) {
        $trans_id = $_POST['edit_trans_id'];
        $cust_name = $_POST['cust_name'];
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $remark = $_POST['remark'];
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('Y-m-d H:i:s');
        $sql = "UPDATE `khatabook_statements` SET `amount`='$amount', `date`='$date', `remark`='$remark', `added_on`='$curr_date' WHERE `trans_id`='$trans_id'";
        $result = mysqli_query($con, $sql);
        $sql = "SELECT * FROM `khatabook_statements` WHERE `cust_name`='$cust_name'";
        $result1 = mysqli_query($con, $sql);
        $rowNos = mysqli_num_rows($result1);
        $balance = 0;
        for ($x = 0; $x < $rowNos; $x++) {
            $row = mysqli_fetch_assoc($result1);
            $amount = $row['amount'];
            $balance = $balance + $amount;
            $format_balance = number_format($balance);
        }
        $sql = "UPDATE `khatabook_all_cust` SET `balance`='$balance' WHERE `cust_name`='$cust_name'";
        $result2 = mysqli_query($con, $sql);
        if ($result && $result1 && $result2) {
            echo "<div class=\"alert alert-success alert-dismissible fade show py-2\" role=\"alert\">
                            <strong>Transaction ID $trans_id updated!</strong> 
                            <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
        } else {
            echo "<div class=\"alert alert-danger alert-dismissible fade show py-2\" role=\"alert\">
                            <strong>Some error occurred, Transaction ID $trans_id not updated!</strong> 
                            <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
        }
    } else if (isset($_POST['cust_name'])) {
        $cust_name = $_POST['cust_name'];
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $remark = $_POST['remark'];
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `khatabook_statements` VALUES (0,'$cust_name','$amount','$date','$remark','$curr_date')";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $sql = "SELECT * FROM `khatabook_all_cust` WHERE `cust_name`='$cust_name'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $balance = $row['balance'];
            $balance = $balance + $amount;
            $format_balance = number_format($balance);
            $sql = "UPDATE `khatabook_all_cust` SET `balance`='$balance' WHERE `cust_name`='$cust_name'";
            $result = mysqli_query($con, $sql);
            echo "<div class=\"alert alert-success alert-dismissible fade show py-2\" role=\"alert\">
                            <strong>Statement added!</strong> 
                            <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
        } else {
            echo "<div class=\"alert alert-danger alert-dismissible fade show py-2\" role=\"alert\">
                            <strong>Some error occurred, statement not added!</strong> 
                            <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
        }
    } else if (isset($_GET['delete_trans_id'])) {
        $trans_id = $_GET['delete_trans_id'];
        $cust_name = $_GET['cust_name'];
        $amount = $_GET['amount'];
        //fetch balance
        $sql = "SELECT * FROM `khatabook_all_cust` WHERE `cust_name`='$cust_name'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $balance = $row['balance'];
        $format_balance = number_format($balance);

        $sql = "SELECT * FROM `khatabook_statements` WHERE `trans_id`='$trans_id'";
        $result = mysqli_query($con, $sql);
        $count  = mysqli_num_rows($result);
        if ($count > 0) {
            $sql = "DELETE FROM `khatabook_statements` WHERE `trans_id`='$trans_id'";
            $result = mysqli_query($con, $sql);
            $balance = $balance - $amount;
            $format_balance = number_format($balance);
            $sql = "UPDATE `khatabook_all_cust` SET `balance`='$balance' WHERE `cust_name`='$cust_name'";
            $result1 = mysqli_query($con, $sql);
            if ($result && $result1) {
                echo "<div class=\"alert alert-success alert-dismissible fade show py-2\" role=\"alert\">
                                <strong>Transaction ID $trans_id deleted!</strong> 
                                <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                            </div>";
            } else {
                echo "<div class=\"alert alert-danger alert-dismissible fade show py-2\" role=\"alert\">
                                <strong>Some error occurred, Transaction ID $trans_id not deleted!</strong> 
                                <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                            </div>";
            }
        } else {
            echo "<div class=\"alert alert-danger alert-dismissible fade show py-2\" role=\"alert\">
                                <strong>Some error occurred, Transaction ID $trans_id not available!</strong> 
                                <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                            </div>";
        }
    } else if (isset($_GET['cust_name'])) {
        $cust_name = $_GET['cust_name'];
        $sql = "SELECT * FROM `khatabook_all_cust` WHERE `cust_name`='$cust_name'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $balance = $row['balance'];
        $format_balance = number_format($balance);
    }
    echo "<center><a href='home.php' class='btn btn-success mt-3'>&larr; All Customers</a></center>";
    echo "<h4 class='text-center my-3'><b>Customer Name:</b> $cust_name </h4>";
    echo "<h4 class='text-center my-3 text-danger'>Balance: $format_balance</h4>";
    ?>
    <center>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#add_trans">
            Add Transaction
        </button>
        <!-- Modal -->
        <div class="modal fade" id="add_trans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Transaction for <?php echo "$cust_name" ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="khatabook_view_cust.php" method="POST">
                            <div class=" ">
                                <!-- <label for="cust_name" class="form-label float-start">Customer Name: </label> -->
                                <input type="text" class="form-control d-none" name="cust_name" id="cust_name" value='<?php echo "$cust_name" ?>'>
                            </div>
                            <div class=" mb-1">
                                <label for="amount" class="form-label float-start">Amount (Enter -ve value if you get money)</label>
                                <input class="form-control" type="number" name="amount" id="amount">
                            </div>
                            <div class=" mb-1">
                                <label for="date" class="form-label float-start">Date</label>
                                <input class="form-control" value="<?php echo date('Y-m-d'); ?>" type="date" name="date" id="date">
                            </div>
                            <div class=" mb-1">
                                <label for="remark" class="form-label float-start">Remark</label>
                                <input class="form-control " type="text-box" name="remark" id="remark" placeholder="enter remark if any">
                            </div>
                            <input type="submit" class="btn btn-primary mt-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <div class="mt-3 mx-3 mb-0 text-center">
        <u>
            <h4>All Transactions</h4>
        </u>
    </div>
    <div style="margin-top: 0px; margin-inline: 1%;">
        <table id="view_cust" class="table-light table table-striped table-bordered " style="width:100%">
            <thead>
                <tr>
                    <th> Trans ID</th>
                    <th> Amount</th>
                    <th style="min-width:80px">Date</th>
                    <th style="min-width:200px">Remark</th>
                    <th style="min-width:150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `khatabook_statements` WHERE `cust_name`='$cust_name'";
                $result = mysqli_query($con, $sql);
                $rowNos = mysqli_num_rows($result);
                for ($x = 0; $x < $rowNos; $x++) {
                    $row = mysqli_fetch_assoc($result);
                    $trans_id = $row['trans_id'];
                    $amount = $row['amount'];
                    $amountFormat = number_format($amount);
                    $date = $row['date'];
                    $remark = $row['remark'];
                    echo "<tr>
                            <td>$trans_id </td>
                            <td>$amountFormat </td>
                            <td>$date</td>
                            <td>$remark</td>
                            <td>
                                <a href='khatabook_edit_trans.php?edit_trans_id=$trans_id&cust_name=$cust_name&amount=$amount&date=$date&remark=$remark' class='btn btn-primary'>Edit Trans</a>
                                <a href='khatabook_view_cust.php?delete_trans_id=$trans_id&cust_name=$cust_name&amount=$amount' class='btn btn-danger' onclick=\"return confirm('Sure to delete?')\">Delete</a>
                            </td>
                        </tr>";
                }
                mysqli_close($con);
                ?>
            </tbody>
        </table>
        <!-- for data table -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"> </script>
        <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script>
            $(document).ready(function() {
                $('#view_cust').DataTable({
                    "scrollX": true,
                    "pageLength": 25,
                    "order": [
                        [2, "desc"]
                    ]
                });
            });
        </script>
    </div>
    <center>
        <a href="home.php?delete_cust=<?php echo $cust_name ?>" class="btn btn-danger mt-3" onclick="return confirm('Sure to delete <?php echo $cust_name ?>?')">Delete Customer</a>
    </center>
    <br>
    <br>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>