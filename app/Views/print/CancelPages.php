<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi Dibatalkan</title>
    
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

    

    <h2 class="text-center">Data Transaksi Dibatalkan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. Order</th>
                <th>Email</th>
                <th>Handphone</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cancels as $i => $cancel): ?>
            <tr> 
                <td><?= $i + 1 ?></td>
                <td><?= $cancel['transactions_name'] ?></td>
                <td><?= $cancel['order_id'] ?></td>
                <td><?= $cancel['transactions_email'] ?></td>
                <td><?= $cancel['transactions_phone'] ?></td>
                <td><?= $cancel['created_at'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
