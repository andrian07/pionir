<!DOCTYPE html>
<html>
<head>
    <title>Memo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        @page{
            size: 21.59cm 13.97cm;
            margin:0.5cm;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 10px 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #000;
            background-color: #808080;
        }
        .nota-container {
            width:21.59cm;
            height:13.97cm;
            margin: auto;
            padding: 5mm;
            box-sizing: border-box;
            background-color: #fff;
        }

        .nota-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .nota-header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .nota-info {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
            border: 1px solid #777; /* border luar */
        }

        .nota-info td {
            border: 1px solid #999; /* border dalam */
            padding: 3px 6px;      /* kecilkan padding atas bawah */
            line-height: 14px;     /* kecilkan jarak teks */
        }

        .table-item {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-item th,
        .table-item td {
            border: 1px solid #000;
            padding: 6px;
        }

        .table-item th {
            background: #f2f2f2;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .nota-total {
            width: 100%;
            margin-top: 15px;
        }

        .nota-total td {
            padding: 5px;
        }

        .label {
            text-align: right;
            font-weight: bold;
        }

        .value {
            text-align: right;
            width: 150px;
        }

        .nota-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
        }

        .no-print {
            margin: 20px;
        }

    </style>
</head>
<body>

<div class="nota-container">

    <div class="nota-header">
        <div class="row">
            <div class="col-md-3" style="text-align:center;">
                <img src="<?php echo base_url(); ?>assets/logo.png" style="width:50%;" />
            </div>
            <div class="col-md-9">
                <h2 style="color:#FE0000; font-size:2em;">TOKO PIONIR</h2>
                <p style="font-size:1em;">Jl. Sungai Raya Dalam 1. No A2 <br />
                Kabupaten Kubu Raya. Kalimantan Barat, Indonesia <br />
                Telp: 0812-3456-7890 Email:pionir.toko@gmail.com</p>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-5">
            <table class="nota-info" style="text-align:center;">
                <tr>
                    <td colspan="2">Pionir <?php echo $data['header_po'][0]->hd_po_invoice; ?></td>
                </tr>
                <tr>
                    <td width="20%">Tgl</td>
                    <td width="80%"><?php $date = $data['header_po'][0]->hd_po_date; echo date('d F Y', strtotime($date)); ?></td>
                </tr>
                 <tr>
                    <td colspan="2" style="font-weight:800;">PIONIR</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="text-align:center; ">
            <h4 style="font-size:15px; font-weight:800;">MEMO PENGAMBILAN BARANG</h4>
        </div>
    </div>
    <div class="row" style="margin-top:20px;">
        <div class="col-md-6">
            <h3 style="font-size:13px; font-weight:800;">Kepada <br /> <?php echo $data['header_po'][0]->supplier_name; ?></h3>
        </div>
        <div class="col-md-6">
            <h3 style="font-size:13px; font-weight:800;">Dari <br /> Toko Pionir</h3>
            <p style="margin-top:-10px;">Jl. Sungai Raya Dalam 1. No A2 <br />
                Kabupaten Kubu Raya. Kalimantan Barat, Indonesia <br />
            </p>
        </div>
    </div>
    

    <table class="table-item">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="60%">Nama Barang</th>
                <th width="10%">Qty</th>
                <th width="20%">Satuan</th>
                <th width="20%">Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php  $number = 1; ?>
            <?php foreach($data['detail_po'] as $row){ ?>
            <tr>
                <td class="text-center"><?php echo $number ?></td>
                <td class="text-left"><?php echo $row->product_name; ?></td>
                <td class="text-center"><?php echo $row->dt_po_qty; ?></td>
                <td class="text-center"><?php echo $row->unit_name; ?></td>
                <td class="text-center"><?php echo $row->dt_po_note; ?></td>
            </tr>
            <?php  $number++; ?>
            <?php } ?>
        </tbody>
    </table>

    <div class="nota-footer">
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7">
                 <table class="nota-info" style="text-align:center;">
                    <tr>
                        <td width="50%">Dibuat Oleh,</td>
                        <td width="50%">Memo Diterima Oleh,</td>
                    </tr>
                    <tr>
                        <td style="height:70px;"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Bag.Pembelian</td>
                        <td>Jaya Ar</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>