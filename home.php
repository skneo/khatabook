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
    <title>Khatabook | Home</title>
</head>

<body>
    <?php include 'header.php';
    if (isset($_POST['cust_name'])) {
        include_once 'dbCon.php';
        $cust_name = $_POST['cust_name'];
        $con = OpenCon();
        $sql = "INSERT INTO `khatabook_all_cust` VALUES ('$cust_name',0)";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "<div class=\"alert alert-success alert-dismissible fade show py-2\" role=\"alert\">
                <strong>$cust_name added successfully!</strong> 
                <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
        } else {
            echo "<div class=\"alert alert-danger alert-dismissible fade show py-2\" role=\"alert\">
                <strong>Some error occurred! $cust_name not added.</strong> 
                <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
        }
        mysqli_close($con);
    }
    if (isset($_GET['delete_cust'])) {
        include_once 'dbCon.php';
        $con = OpenCon();
        $cust_name = $_GET['delete_cust'];
        $sql = "DELETE FROM `khatabook_statements` WHERE `cust_name`='$cust_name'";
        $result = mysqli_query($con, $sql);
        $sql1 = "DELETE FROM `khatabook_all_cust` WHERE `cust_name`='$cust_name'";
        $result1 = mysqli_query($con, $sql1);
        if ($result && $result1) {
            echo "<div class=\"alert alert-success alert-dismissible fade show py-2\" role=\"alert\">
                            <strong>$cust_name deleted!</strong> 
                            <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
        } else {
            echo "<div class=\"alert alert-danger alert-dismissible fade show py-2\" role=\"alert\">
                            <strong>Some error occurred, customer not deleted!</strong> 
                            <button type=\"button\" class=\"btn-close pb-2\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
        }
    }
    ?>
    <center>
        <div class="mt-3">
            <span id="get_money" class="text-success me-2" style="font-size: 20px;">Get &#8377; 0</span> &
            <span id="give_money" class="text-danger  ms-2" style="font-size: 20px;">Give &#8377; 0</span>
        </div>
        <hr>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Customer
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="home.php" method="POST">
                            <div class="">
                                <label for="cust_name" class="form-label float-start">Customer Name</label>
                                <input type="text" class="form-control" name="cust_name" id="cust_name">
                            </div>
                            <!-- <input type="text" name="cust_name" id="cust_name" placeholder="Enter customer name"><br> -->
                            <input type="submit" class="btn btn-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 mx-3 mb-0">
            <u>
                <h4>All Customers</h4>
            </u>
        </div>
        <div style="margin-top: 0px; margin-inline: 1%;">
            <table id="all_cust" class="table-light table table-striped table-bordered caption-top " style="width:100%">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th> Balance</th>
                        <th>Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once 'dbCon.php';
                    $con = OpenCon();
                    $sql = "SELECT * FROM `khatabook_all_cust` ";
                    $result = mysqli_query($con, $sql);
                    $rowNos = mysqli_num_rows($result);
                    $get = 0;
                    $give = 0;
                    for ($x = 0; $x < $rowNos; $x++) {
                        $row = mysqli_fetch_assoc($result);
                        $cust_name = $row['cust_name'];
                        $balance = $row['balance'];
                        $format_balance = number_format($balance);
                        if ($balance > 0)
                            $get = $get + $balance;
                        else
                            $give = $give + $balance;
                        echo "<tr>
                                <td>$cust_name</td>
                                <td>$format_balance </td>
                                <td>
                                    <a href='khatabook_view_cust.php?cust_name=$cust_name' class='btn btn-primary'>View/Add</a>
                                </td>
                        </tr>";
                    }
                    $give = -$give;
                    $giveFormat = number_format($give);
                    $getFormat = number_format($get);
                    mysqli_close($con);
                    echo "<script> 
                            document.getElementById('get_money').innerHTML='Get &#8377; $getFormat';
                            document.getElementById('give_money').innerHTML='Give &#8377; $giveFormat';
                        </script>"
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
                    $('#all_cust').DataTable({
                        "scrollX": true,
                        "pageLength": 25
                    });
                });
            </script>
        </div>
    </center>
    <br>
    <br>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>