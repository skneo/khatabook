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
    <title>Khatabook | Edit Transaction</title>
</head>

<body>
    <?php include 'header.php';
    if (isset($_GET['edit_trans_id'])) {
        $trans_id = $_GET['edit_trans_id'];
        $cust_name = $_GET['cust_name'];
        $amount = $_GET['amount'];
        $date = $_GET['date'];
        $remark = $_GET['remark'];
    }
    ?>
    <center>
        <h4 class="my-5">Edit Transaction ID <?php echo "$trans_id" ?> for <?php echo "$cust_name" ?></h4>
        <form action="khatabook_view_cust.php" method="POST" style="width: 300px;">
            <div class=" ">
                <!-- <label for="edit_trans_id" class="form-label float-start">Transaction ID</label> -->
                <input type="number" class="form-control d-none" name="edit_trans_id" id="edit_trans_id" placeholder="Don't change Trans ID" value='<?php echo "$trans_id" ?>'>
            </div>
            <div class=" ">
                <!-- <label for="cust_name" class="form-label float-start">Customer Name</label> -->
                <input type="text" class="form-control d-none" name="cust_name" id="cust_name" value='<?php echo "$cust_name" ?>'>
            </div>
            <div class=" mb-1">
                <label for="amount" class="form-label float-start">Amount</label>
                <input class="form-control" type="number" name="amount" id="amount" value='<?php echo "$amount" ?>'>
            </div>
            <div class="mb-1">
                <label for="date" class="form-label float-start">Date</label>
                <input class="form-control " type="date" name="date" id="date" value='<?php echo "$date" ?>'>
            </div>
            <div class=" mb-3">
                <label for="remark" class="form-label float-start">Remark</label>
                <input class="form-control " type="text-box" name="remark" id="remark" value='<?php echo "$remark" ?>'>
            </div>
            <input type="submit" class="btn btn-primary mt-2">

        </form>
    </center>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>