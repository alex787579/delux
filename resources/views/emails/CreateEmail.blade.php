<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delux Bearing - Order Creation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #e1e1e1;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        .header img {
            width: 150px;
        }
        .header h2 {
            margin: 10px 0 5px;
            color: #333;
        }
        .order-details {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .order-details ul {
            list-style: none;
            padding: 0;
        }
        .order-details ul li {
            margin: 8px 0;
            font-size: 16px;
            color: #555;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="header">
            <img src="/logo/1.png" alt="Delux Bearing">
            <h2>Order Created</h2>
            <p>Thank you for your Creation!</p>
        </div>

        <div class="order-details">
            <h3>Order Details:</h3>
            <ul>
                <li><strong>Order ID:</strong> {{ $order->id }}</li>
                <li><strong>Material No:</strong> {{ $order->material_no }}</li>
                <li><strong>Quantity:</strong> {{ $order->qty }}</li>
                <li><strong>Segment:</strong> {{ $order->segment }}</li>
                <li><strong>Order Type:</strong> {{ $order->order_type }}</li>
                <li><strong>Status:</strong> {{ $order->status }}</li>
            </ul>
            <a href="#" class="btn">View Order</a>
        </div>

        <div class="footer">
            <p>For any queries, contact us at <a href="mailto:support@deluxbearing.com">support@deluxbearing.com</a></p>
            <p>© 2025 Delux Bearing. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
