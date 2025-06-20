<!DOCTYPE html>
<html>
<head>
    <title>Data Users</title>
    
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

    

    <h2 class="text-center">Data Users</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transactions as $i => $transaction): ?>
            <tr> 
                <td><?= $i + 1 ?></td>
                <td><?= $user['total_price'] ?></td>
                <td><?= $user['order_id'] ?></td>
                <td><?= $user['status'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
