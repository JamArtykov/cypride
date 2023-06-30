<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
include('connection.php');
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM transactions WHERE user_id = $user_id ORDER BY timestamp DESC";
$results = mysqli_query($link, $sql);
$trainsactions = array();
while ($row = mysqli_fetch_assoc($results)) {
    $transactions[] = $row; // Add each row to the $transactions array
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wallet</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" type="image/png" href="/images/favicon2.ico">
    <meta property="og:image" content="/images/favicon.png" />

    <style>
        .container {
            margin-top: 30px;
            margin-left: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .border-right {
            border-right: 1px solid black;
        }

        hr {
            background-color: black;
            height: 1px;
            border: 0;
        }

        .credit-card {
            width: 360px;
            height: 400px;
            margin: 60px auto 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: linear-gradient(to top, rgb(217,237,247),#ecf3fa,rgb(217,237,247));
            box-shadow: 1px 2px 3px 0 rgba(0, 0, 0, .10);
        }

        .form-header {
            height: 60px;
            padding: 20px 30px 0;
            border-bottom: 1px solid #e1e8ee;
        }

        .form-body {
            height: 340px;
            padding: 30px 30px 20px;
        }

        .title {
            font-size: 18px;
            margin: 0;
            color: #5e6977;
        }

        .withdraw-amount,
        .deposit-amount,
        .card-number,
        .cvv-input input,
        .month select,
        .year select {
            font-size: 14px;
            font-weight: 100;
            line-height: 40px;
            height: 40px;
        }

        .withdraw-amount,
        .deposit-amount,
        .card-number,
        .month select,
        .year select {
            font-size: 14px;
            font-weight: 100;
            line-height: 14px;
        }

        .withdraw-amount,
        .deposit-amount,
        .card-number,
        .cvv-details,
        .cvv-input input,
        .month select,
        .year select {
            opacity: .7;
            color: #86939e;
        }

        .withdraw-amount,
        .deposit-amount,
        .card-number {
            width: 100%;
            margin-bottom: 20px;
            padding-left: 20px;
            border: 2px solid #e1e8ee;
            border-radius: 6px;
        }

        .month select,
        .year select {
            width: 145px;
            margin-bottom: 20px;
            padding-left: 20px;
            border: 2px solid #e1e8ee;
            border-radius: 6px;
            background: url('caret.png') no-repeat;
            background-position: 85% 50%;
            -moz-appearance: none;
            -webkit-appearance: none;
        }

        .month select {
            float: left;
        }

        .year select {
            float: right;
        }

        .cvv-input input {
            float: left;
            width: 145px;
            padding-left: 20px;
            border: 2px solid #e1e8ee;
            border-radius: 6px;
            background: #fff;
        }

        .cvv-details {
            font-size: 12px;
            font-weight: 300;
            line-height: 16px;
            float: right;
            margin-bottom: 20px;
        }

        .cvv-details p {
            margin-top: 6px;
        }

        .paypal-btn,
        .proceed-btn2 ,
        .proceed-btn {
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            border-color: transparent;
            border-radius: 6px;
        }
        .proceed-btn2 ,
        .proceed-btn {
            margin-bottom: 10px;
            background: #7dc855;
        }

        .paypal-btn a,
        .proceed-btn2 a,
        .proceed-btn a {
            text-decoration: none;
        }
        .proceed-btn2 a,
        .proceed-btn a {
            color: #fff;
        }

        .paypal-btn a {
            color: rgba(242, 242, 242, .7);
        }

        .paypal-btn {
            padding-right: 95px;
            background: url('paypal-logo.svg') no-repeat 65% 56% #009cde;
        }

        table {
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .transaction-row:nth-child(even) {
            background-color: #f2f2f2;
        }
        .transaction-row:nth-child(odd) {
            background-color: #d5d8de;
        }

        .transaction-row:hover {
            background-color: #eaf6ff;
        }

        .no-transaction {
            margin-top: 20px;
            font-style: italic;
            color: #888;
        }

        .buttons {
            justify-content: center;
            position: center;
        }

    </style>

</head>

<body>
    <?php
    if (isset($_SESSION["user_id"])) {
        include("navigationbarconnected.php");
    } else {
        include("navigationbarnotconnected.php");
    }
    ?>

    
    <!-- Main content of the page -->
    <div class="col-lg-9">
        <div class="container">
            <div class="row mt-4">
                <div class="row mt-4">
                    <div class="buttons">
                    <div class="col-lg-12">
                        <button id="btn-add-funds" class="btn btn-primary">Add Funds</button>
                        <button id="btn-withdraw" class="btn btn-primary">Withdraw</button>
                        <button id="btn-history" class="btn btn-primary">History</button>
                    </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="content-add-funds">
                        <!-- Content for the "Add Funds" button -->
                        <h3 style="background: linear-gradient(to right, #002949, transparent); color: white; border-radius: 10px; padding: 10px;">Add Funds</h3>
                        <form id="credit-card-form" class="credit-card">
                            <div class="form-header">
                                <h4 class="title"style="color: black">Credit card detail</h4>
                            </div>

                            <div class="form-body">
                                <input type="text" class="deposit-amount" placeholder="Amount (Max 1000)">
                                <!-- Card Number -->
                                <input type="text" class="card-number" placeholder="Card Number">

                                <!-- Date Field -->
                                <div class="date-field">
                                    <div class="month" >
                                        <select name="Month" style="background: white">
                                            <option value="january">January</option>
                                            <option value="february">February</option>
                                            <option value="march">March</option>
                                            <option value="april">April</option>
                                            <option value="may">May</option>
                                            <option value="june">June</option>
                                            <option value="july">July</option>
                                            <option value="august">August</option>
                                            <option value="september">September</option>
                                            <option value="october">October</option>
                                            <option value="november">November</option>
                                            <option value="december">December</option>
                                        </select>
                                    </div>
                                    <div class="year">
                                        <select name="Year" style="background: white">
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>

                                        </select>
                                    </div>
                                </div>

                                <!-- Card Verification Field -->
                                <div class="card-verification">
                                    <div class="cvv-input">
                                        <input type="text" placeholder="CVV">
                                    </div>
                                    <div class="cvv-details" style="color: black">
                                        <p>3 or 4 digits usually found <br> on the signature strip</p>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <button type="submit" class="proceed-btn" style="background: green "><a href="#">Proceed</a></button>

                            </div>
                        </form>
                    </div>
                    <div id="content-withdraw" style="display: none;">
                        <!-- Content for the "Withdraw" button -->
                        <h3 style="background: linear-gradient(to right, #002949, transparent); color: white; border-radius: 10px; padding: 10px;">Withdraw</h3>
                        <form id="withdraw-form" class="credit-card">
                            <div class="form-header">
                                <h4 class="title">Credit card detail</h4>
                            </div>

                            <div class="form-body">
                                <input type="text" class="withdraw-amount" placeholder="Withdraw Amount">
                                <!-- Card Number -->
                                <input type="text" class="card-number" placeholder="Card Number">

                                <!-- Total Receivable and Commission -->
                                <p>Total Receivable: <span id="withdraw-total-receivable">0.00₺</span></p>
                                <p>Commission (5%): <span id="withdraw-commission">0.00₺</span></p>

                                <!-- Buttons -->
                                <button type="submit" class="proceed-btn2"><a href="#">Proceed</a></button>

                            </div>
                        </form>
                    </div>
                    <div id="content-history" style="display: none; border-radius: 5px;">
                        <!-- Content for the "History" button -->
                        <h3 style="background: linear-gradient(to right, #002949, transparent); color: white; border-radius: 10px; padding: 10px; ">Transaction History</h3>
                        <div class="transactions-wrapper">
                            <?php if (!empty($transactions)): ?>
                                <table class="transaction-table" style="margin: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>User ID</th>
                                            <th>Trip ID</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $transaction): ?>
                                            <tr class="transaction-row">
                                                <td><?php echo $transaction['transaction_id']; ?></td>
                                                <td><?php echo $transaction['user_id']; ?></td>
                                                <td><?php echo $transaction['trip_id']; ?></td>
                                                <td><?php echo $transaction['type']; ?></td>
                                                <td><?php echo $transaction['amount']; ?></td>
                                                <td><?php echo $transaction['timestamp']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php else: ?>
                                    <table class="transaction-table" style="margin: 10px;">
                                        <tr class="transaction-row">
                                            <td colspan="6">
                                                <p class="no-transaction">No transaction history available</p>
                                            </td>
                                        </tr>
                                    </table>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Button click event handlers
            $("#btn-add-funds").click(function() {
                showContent("add-funds");
            });

            $("#btn-withdraw").click(function() {
                showContent("withdraw");
            });

            $("#btn-history").click(function() {
                showContent("history");
            });

            // Function to show the corresponding content based on the selected button
            function showContent(contentType) {
                // Hide all content sections
                $("#content-add-funds").hide();
                $("#content-withdraw").hide();
                $("#content-history").hide();

                // Show the selected content section
                switch (contentType) {
                    case "add-funds":
                        $("#content-add-funds").show();
                        break;
                    case "withdraw":
                        $("#content-withdraw").show();
                        break;
                    case "history":
                        $("#content-history").show();
                        break;
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Handle form submission for deposit
            $("#credit-card-form").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get form data
                var depositAmount = parseFloat($(".deposit-amount").val());
                if (depositAmount > 1000) {
                    alert("Maximum deposit amount is 1000₺.");
                    return;
                }
                var cardNumber = $(".card-number").val();
                var month = $("select[name='Month']").val();
                var year = $("select[name='Year']").val();
                var cvv = $(".cvv-input input").val();

                // Perform any necessary validation or sanitization of the form data

                // Create data object for AJAX request
                var formData = {
                    'deposit-amount': depositAmount,
                    'card-number': cardNumber,
                    'month': month,
                    'year': year,
                    'cvv': cvv
                };

                // Send AJAX request to process deposit
                $.ajax({
                    type: 'POST',
                    url: 'addfunds.php',
                    data: formData,
                    success: function(response) {
                        location.reload();
                        // Handle success response
                        // You can redirect the user or display a success message here
                        console.log(response); // Log the response for debugging
                    },
                    error: function(error) {
                        // Handle error response
                        // You can display an error message to the user here
                        console.log(error); // Log the error for debugging
                    }
                });
            });

            // Handle form submission for withdrawal
            $("#withdraw-form").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get form data
                var withdrawalAmount = parseFloat($(".withdraw-amount").val());
                if (isNaN(withdrawalAmount) || withdrawalAmount <= 0 || withdrawalAmount > <?php echo $balance; ?>) {
                  alert("Invalid withdrawal amount");
                  $(".withdraw-amount").val(''); // Clear the input field
                  return;
                }
                var cardNumber = $(".card-number").val();

                // Perform any necessary validation or sanitization of the form data

                // Calculate total receivable and commission
                var commissionRate = 0.05;
                var commission = withdrawalAmount * commissionRate;
                var totalReceivable = withdrawalAmount - commission;

                // Update the HTML with the calculated values
                $("#withdraw-total-receivable").text(totalReceivable.toFixed(2) + "₺");
                $("#withdraw-commission").text(commission.toFixed(2) + "₺");

                // Create data object for AJAX request
                var formData = {
                    'withdraw-amount': withdrawalAmount,
                    'card-number': cardNumber
                };

                // Send AJAX request to process withdrawal
                $.ajax({
                    type: 'POST',
                    url: 'withdraw.php',
                    data: formData,
                    success: function(response) {
                        location.reload();
                        // Handle success response
                        // You can redirect the user or display a success message here
                        console.log(response); // Log the response for debugging
                    },
                    error: function(error) {
                        // Handle error response
                        // You can display an error message to the user here
                        console.log(error); // Log the error for debugging
                    }
                });
            });

            // Update total receivable and commission on withdrawal amount change
            $(".withdraw-amount").on("input", function() {
                var withdrawalAmount = parseFloat($(this).val());
                var commissionRate = 0.05;
                var commission = withdrawalAmount * commissionRate;
                var totalReceivable = withdrawalAmount - commission;

                // Update the HTML with the calculated values
                $("#withdraw-total-receivable").text(totalReceivable.toFixed(2) + "₺");
                $("#withdraw-commission").text(commission.toFixed(2) + "₺");
            });

            // Handle Proceed button click for withdrawal
            $(".proceed-btn2").click(function(event) {
                event.preventDefault(); // Prevent the default button click behavior
                $("#withdraw-form").trigger("submit"); // Trigger the form submission
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
