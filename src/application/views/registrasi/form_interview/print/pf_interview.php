<html>

<head>
    <style>
        body {
            font-size: 12px;
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px;
        }

        .header {
            background: #CECECE;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <?php
    // foreach ($_getDetail as $row) :
    //     $hdrid = $row->HeaderID;
    // endforeach;
    $hdrid = $_getDetail[0]->HeaderID ?? null; // Ambil HeaderID dari elemen pertama jika ada

    $namafoto = base_url('dataupload/foto/' . $hdrid . '.jpg');
    ?>

    <table border="1">
        <tr>
            <td style="width: 25%;">
                <table>
                    <tr class="header">
                        <td></td>
                        <td><?php echo $row->CVNama; ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    <td></td>
                                    <td>Reg. ID / NIK</td>
                                    <td>
                                        : #<?php echo $row->HeaderID; ?> /
                                        <?php echo $row->NIK ? $row->NIK : ' ____________'; ?>
                                    </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Nama</td>
                                    <td>: <?php echo substr($row->Nama, 0, 30); ?></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Dept/Bag</td>
                                    <td>: </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Shift</td>
                                    <td>: </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td rowspan="6" class="center">
                                        <img src="<?php echo $namafoto; ?>" width="70">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                </tr>

                                <tr class="center">
                                    <td></td>
                                    <td><?php echo date('l, d-m-Y'); ?></td>
                                    <td></td>
                                </tr>

                                <tr class="center">
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                </tr>

                                <tr class="center">
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                </tr>

                                <tr class="center">
                                    <td></td>
                                    <td>____________</td>
                                    <td></td>
                                </tr>

                                <tr class="center">
                                    <td></td>
                                    <td><?php echo substr($row->Pemborong, 0, 30); ?></td>
                                    <td></td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>