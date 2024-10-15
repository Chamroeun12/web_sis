<?php
include 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sql = "SELECT * FROM tb_sch_student";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sch = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php include_once "header.php"; ?>

<section class="content-wrapper">
    <div class="container-fluid">

        <div class="card m-2">
            <div class="card-header">
                <div>|Subject</div>
            </div>
            <!-- create table with school schedule from monday to friday -->
            <table class="table table-bordered table-hover my-2" id="table1">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sch as $key => $value) { ?>
                    <tr>
                        <td>
                            <p><?php echo $value['Time_in']; ?></p>
                            <p><?php echo $value['Time_out']; ?></p>
                        </td>
                        <td><?php echo $value['Monday']; ?></td>
                        <td><?php echo $value['Tuesday']; ?></td>
                        <td><?php echo $value['Wednesday']; ?></td>
                        <td><?php echo $value['Thursday']; ?></td>
                        <td><?php echo $value['Friday']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

<?php include_once "footer.php"; ?>