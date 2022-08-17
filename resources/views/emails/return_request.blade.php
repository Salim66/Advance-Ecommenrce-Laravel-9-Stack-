<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome To E-Commerce Website</title>
</head>
<body>
    <table>
        <tr>
            <td>Dear {{ $userDetials['name'] }}</td>
        </tr>
        <tr>
            <td>Your order request for Order no. {{ $returnDetails['order_id'] }} with e-commerce website is {{ $return_status }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Thanks & Regards</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>E-Commerce Website</td>
        </tr>
    </table>
</body>
</html>
