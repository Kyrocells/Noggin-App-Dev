<?php
require_once 'functions.php';

$transactions = getTransactionHistory();

?>
<div class="container view_container">
    <div class="card view_card">
        <div class="card-header">
            <h3 class="card-title">Transaction History</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Price</th>
                        <th>User ID</th>
                        <th>Video Format</th>
                        <th>Video ID</th>
                        <th>Method of Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($transactions) > 0) {
                        foreach ($transactions as $transaction) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($transaction['date']) . "</td>";
                            echo "<td>" . htmlspecialchars($transaction['total_price']) . "</td>";
                            echo "<td>" . htmlspecialchars($transaction['user_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($transaction['video_format']) . "</td>";
                            echo "<td>" . htmlspecialchars($transaction['video_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($transaction['method_of_payment']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No transactions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
