<h3>Lịch sử mua hàng</h3>
<table class="table table-bordered table-hover">
    <tr>
        <th>Mã số</th>
        <th>Ngày đặt</th>
        <th>Tình trạng</th>
        <th>Người nhận</th>
        <th>Số đt</th>
        <th>Địa chỉ</th>
        <th></th>
    </tr>
    <?php
        $giohangClass = new Giohang();
        $tendangnhap = $_SESSION['User'];
        $resultdh = $giohangClass->hienthiDSDhByUser("'".$tendangnhap."'");
        while ($rowdh = mysqli_fetch_array($resultdh, MYSQLI_ASSOC)) {
    ?>
    <tr>
        <td><?php echo $rowdh['dh_ma']; ?></td>
        <td><?php echo $rowdh['dh_ngaylap']; ?></td>
        <td><?php echo $rowdh['dh_trangthai']; ?></td>
        <td><?php echo $rowdh['dh_tennguoinhan']; ?></td>
        <td><?php echo $rowdh['dh_dt']; ?></td>
        <td><?php echo $rowdh['dh_noigiao']; ?></td>
        <td></td>
    </tr>
    <?php } ?>
</table>

