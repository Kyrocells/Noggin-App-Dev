<?php

require_once 'functions.php';

function sendNotification($notifications) {
    
    echo "<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        td, h2 {
            color:#13333d;
        }
        th {
            background-color: #13333d;
            color:#fff;
        }

        .notifs{
        margin: 0;
        padding: 0;
        height: 100%;
        margin: 15px;
        border-radius: 16px;
        border: none;
        padding: 25px;
        background: linear-gradient(
            45deg,
            #59bcdd,
            #4ca6c4,
            #3f8faa,
            #2d7188
            );
        }

        .card-title{
            color: #ffffff;
        }

        .table, .card-header, .card-footer{
            background: var(--bs-table-bg);
            border-color: #1E5162;
        }

        .table th{
            background-color: #1E5162;
            color: #fff;
            text-align: center;
        }

        .table td{
            color: #1E5162;
            font-weight: 500;
            text-align: center;
        }
        </style>";
    
    echo "<div class=\"container notifs mt-4\">";
    echo "<h2 class=\"my-4\">Upcoming Return Dates:</h2>\n";
    echo "<table>\n";
    echo "<tr><th>Video ID</th><th>Video Title</th><th>Return Date</th><th>Total Price</th><th>Payment Method</th></tr>\n";
    
    foreach ($notifications as $notification) {
        echo "<tr>";
        echo "<td>{$notification['video_id']}</td>";
        echo "<td>{$notification['video_title']}</td>";
        echo "<td>{$notification['return_date']}</td>";
        echo "<td>{$notification['total_price']}</td>";
        echo "<td>{$notification['method_of_payment']}</td>";
        echo "</tr>\n";
    }

    echo "</table></div>\n";
}


function checkAndSendNotifications() {
    $conn = dbConnect();
    
   
    $current_date = date('Y-m-d');
    $one_day_before_date = date('Y-m-d', strtotime('+1 day'));

    $sql = "
        SELECT rv.video_id, v.video_title, rv.return_date, th.total_price, th.method_of_payment
        FROM rented_videos rv
        JOIN transaction_history th ON rv.video_id = th.video_id
        JOIN videos v ON rv.video_id = v.video_id
        WHERE rv.return_date = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $one_day_before_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = array();

    while ($row = $result->fetch_assoc()) {
        $notifications[] = array(
            'video_id' => $row['video_id'],
            'video_title' => $row['video_title'],
            'return_date' => $row['return_date'],
            'total_price' => $row['total_price'],
            'method_of_payment' => $row['method_of_payment']
        );
    }

    $stmt->close();
    $conn->close();

    
    sendNotification($notifications);
}

checkAndSendNotifications();

?>
