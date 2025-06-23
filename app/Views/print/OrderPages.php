<!DOCTYPE html>
<html>
<head>
    <title>Data Order</title>
    
</head>

<style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .text-center {
            text-align: center;
        }
    </style>
<body>

    

    <h2 class="text-center">Data Order Barang</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tracking Number</th>
                <th>Lokasi Pengiriman</th>
                <th>Status</th>
                <th>Tanggal</th>
                </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $i => $order): ?>
            <tr> 
                <td><?= $i + 1 ?></td>
                <td><?= $order['tracking_number'] ?></td>
                <td><?= $order['address'] ?></td>
                <td><?= $order['status'] ?></td>
                <td><?= $order['created_at'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
