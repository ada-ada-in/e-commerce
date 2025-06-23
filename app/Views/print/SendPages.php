<!DOCTYPE html>
<html>
<head>
    <title>Data Barang Dikirm</title>
    
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

    

    <h2 class="text-center">Data Pengiriman Barang</h2>

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
            <?php foreach($sends as $i => $send): ?>
            <tr> 
                <td><?= $i + 1 ?></td>
                <td><?= $send['tracking_number'] ?></td>
                <td><?= $send['address'] ?></td>
                <td><?= $send['status'] ?></td>
                <td><?= $send['created_at'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
