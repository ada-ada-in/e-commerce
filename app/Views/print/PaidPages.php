<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi Dibayarkan</title>
    
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

    

    <h2 class="text-center">Data Transaksi Dibayarkan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. Order</th>
                <th>Email</th>
                <th>Handphone</th>
                <th>Status Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($paids as $i => $paid): ?>
            <tr> 
                <td><?= $i + 1 ?></td>
                <td><?= $paid['transactions_name'] ?></td>
                <td><?= $paid['order_id'] ?></td>
                <td><?= $paid['transactions_email'] ?></td>
                <td><?= $paid['transactions_phone'] ?></td>
                <td><?= $paid['status'] ?></td>
                <td><?= $paid['created_at'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
