<?php
include_once 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_POST['btnsave'])) {
    $sql = "INSERT INTO tb_course(Course_name,Color,Sub_id,Date) VALUES(:cu_name,:Color,:subid,:date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":cu_name", $_POST['cu_name'], PDO::PARAM_STR);
    $stmt->bindParam(":Color", $_POST['color'], PDO::PARAM_STR);
    $stmt->bindParam(":subid", $_POST['subject'], PDO::PARAM_INT);
    $stmt->bindParam(":date", $_POST['date'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>window.history.back();</script>";
    }
}

//pages
$sql  = "SELECT COUNT(*) AS CountRecords FROM tb_course";
$stmt = $conn->prepare($sql);
$stmt->execute();
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

$maxpage = 1;
if ($temp) {
    $maxpage = ceil($temp['CountRecords'] / 10);
}



// $sql = "SELECT * FROM tb_subject";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $Student = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * from tb_course co,  tb_subject su WHERE co.Sub_id = su.SubID";
$stmt = $conn->prepare($sql);
$stmt->execute();
$Course = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * from tb_subject";
$stmt = $conn->prepare($sql);
$stmt->execute();
$Subject = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include_once 'header.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">|Course</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <a href="add_subject.php" class="btn btn-success float-sm-right" data-toggle="modal"
                        data-target="#modal-lg">Create</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4>|Create Subject</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Condition to Add or Edit student -->

                    <!-- form add and edit student -->
                    <form name="subjectForm" method="post" action="">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" id="subID" name="subid" value="<?= $subject_id; ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputName">Course Name</label>
                                        <input type="text" id="coursename" name="cu_name" class="form-control" value="">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputStatus">Subject Name</label>
                                            <select id="" name="subject" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                <?php foreach ($Subject as  $row): ?>
                                                    <option value="<?= $row['SubID']; ?>">
                                                        <?= $row['Subject_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputStatus">Color</label>
                                            <select id="" name="color" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                <option value="bg-primary">Primary</option>
                                                <option value="bg-secondary">Secondary</option>
                                                <option value="bg-success">Success</option>
                                                <option value="bg-danger">Danger</option>
                                                <option value="bg-warning">Warning</option>
                                                <option value="bg-info">Info</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputName">Date</label>
                                        <input type="date" id="date" name="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" value="Save" name="btnsave" class="btn btn-success">
                            <!-- <button type="button" class="btn btn-primary">Save</button> -->
                        </div>
                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h3 class="card-title">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                            Add
                        </button>
                    </h3> -->

                            <div class="card-tools">
                                <div class="form-group" style="width: 300px;">
                                    <input type="text" id="" name="namesearch" class="search form-control float-right"
                                        placeholder="Search" style="font-family:Khmer OS Siemreap;">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover text-nowrap" style="font-family:Khmer OS Siemreap;"
                                id="userTbl">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Course Name</th>
                                        <th>Subject Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Course as $key => $value): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?>.</td>
                                            <td><?php echo $value['Course_name']; ?></td>
                                            <td><?php echo $value['Subject_name']; ?></td>
                                            <td><?php echo $value['Date']; ?></td>
                                            <td>
                                                <a href="update_course.php?co_id=<?php echo $value['id'] ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="m-2" href="all_condition.php?co_id=<?php echo $value['id'] ?>"
                                                    onclick="return confirm('Do you want to delete this record?')">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                                <a href="">
                                                    <i class="nav-icon fas fa-ellipsis-h"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <li class="page-item"><a class="page-link" href="student_list.php?page=
                     <?php
                        if (isset($_GET['page']) && $_GET['page'] > 1)

                            echo $_GET['page'] - 1;
                        else
                            echo 1;
                        ?>
                    ">&laquo;</a></li>
                                    <?php for ($i = 1; $i <= $maxpage; $i++) { ?>
                                        <li class="page-item
                      <?php
                                        if (isset($_GET['page'])) {
                                            if ($i == $_GET['page'])
                                                echo ' active ';
                                        } else {
                                            if ($i == 1)
                                                echo ' active ';
                                        }
                        ?>"><a class="page-link" href="student_list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item"><a class="page-link" href="student_list.php?page=
                     <?php
                        if (isset($_GET['page'])) {
                            if ($_GET['page'] == $maxpage) {
                                echo $maxpage;
                            } else {
                                echo $maxpage + 1;
                            }
                        } else {
                            echo 2;
                        }
                        ?>">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include_once 'footer.php'; ?>