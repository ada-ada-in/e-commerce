<!DOCTYPE html>
<html>
<head>
    <title>Data Pembelian Stok Barang</title>
    
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

    

    <h2 class="text-center">Data Tambah Stok Barang</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Quantity</th>
                <th>Tanggal</th>
                </tr>
        </thead>
        <tbody>
            <?php foreach($inventorys as $i => $inventory): ?>
            <tr> 
                <td><?= $i + 1 ?></td>
                <td><?= $inventory['product_name'] ?></td>
                <td><?= $inventory['quantity'] ?></td>
                <td><?= $inventory['created_at'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
