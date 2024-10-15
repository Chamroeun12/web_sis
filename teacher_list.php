<?php
include_once 'connection.php';
//start seesion
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['btnsearch'])) {
} else {
    $sql = "SELECT * FROM tb_teacher LIMIT 10";
    if (isset($_GET['page'])) {
        if ($_GET['page'] > 1) {
            $sql .= " OFFSET " . ($_GET['page'] - 1) * 10;
        }
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Insert Teacher
if (isset($_POST['btnsave'])) {
    $sql = "INSERT INTO tb_teacher(En_name,Kh_name,Staff_code,Gender,DOB,Position,Address,Phone,Nation,Ethnicity,Status) 
    VALUES(:En_name,:Kh_name,:Staff_code,:Gender,:DOB,:Position,:Address,:Phone,:Nation,:Ethnicity,:Status)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":En_name", $_POST['En_name'], PDO::PARAM_STR);
    $stmt->bindParam(":Kh_name", $_POST['Kh_name'], PDO::PARAM_STR);
    $stmt->bindParam(":Staff_code", $_POST['code'], PDO::PARAM_STR);
    $stmt->bindParam(":Gender", $_POST['gender'], PDO::PARAM_STR);
    $stmt->bindParam(":DOB", $_POST['dob'], PDO::PARAM_STR);
    $stmt->bindParam(":Position", $_POST['position'], PDO::PARAM_STR);
    $stmt->bindParam(":Address", $_POST['address'], PDO::PARAM_STR);
    $stmt->bindParam(":Phone", $_POST['phone'], PDO::PARAM_STR);
    $stmt->bindParam(":Nation", $_POST['nation'], PDO::PARAM_STR);
    $stmt->bindParam(":Ethnicity", $_POST['ethnicity'], PDO::PARAM_STR);
    $stmt->bindParam(":Status", $_POST['status'], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: teacher_list.php');
    }
}

$sql  = "SELECT COUNT(*) AS CountRecords FROM tb_teacher";
$stmt = $conn->prepare($sql);
$stmt->execute();
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

$maxpage = 1;
if ($temp) {
    $maxpage = ceil($temp['CountRecords'] / 10);
}
?>
<?php include_once "header.php"; ?>
<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h3 class="m-0">|Teacher Lists</h3>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <h3 class="card-title float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                        Add
                    </button>
                </h3>
            </div>
            <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v2</li>
                    </ol>
                </div> -->
            <!-- /.col -->
        </div>
    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- form card-header -->
                <div class="card-header">
                    <h3 class="card-title">|Add Teacher</h3>
                </div>
                <!-- Condition to Add or Edit student -->

                <!-- form add student -->
                <form name="teacherform" method="post" action="">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="inputName">English Name</label>
                                    <input type="text" id="enName" name="En_name" class="form-control" value="">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputName">Khmer Name</label>
                                        <input type="text" id="khName" name="Kh_name" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" class="form-control" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputStatus">Gender</label>
                                        <select id="inputStatus" name="gender" class="form-control custom-select">
                                            <option selected disabled>Select one</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputStatus">Position</label>
                                        <input type="text" name="position" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputStatus">Code Number</label>
                                        <input type="text" name="code" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputStatus">Nationality</label>
                                        <input type="text" name="nation" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputStatus">Ethnicity</label>
                                        <input type="text" name="ethnicity" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputStatus">Status</label>
                                        <input type="text" name="status" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Address</label>
                                <textarea id="inputDescription" name="address" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputPhone">Phone</label>
                                <input type="text" id="inputPhone" name="phone" class="form-control" value="">
                            </div>
                        </div>
                        <!-- <?php if ($_SESSION['role'] == "admin") { ?>
                            <?php if (isset($_GET['student_id'])) { ?>
                                <input type="submit" value="Delete" name="btndelete"
                                    onclick="return confirm('Do you want to delete this record?')" class="btn btn-danger">
                            <?php } ?>
                        <?php } ?> -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.row -->
    <div class="row m-2">
        <div class="col-12">
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
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0 text-sm">
                    <table class="table table-hover text-nowrap" style="font-family:Khmer OS Siemreap;" id="userTbl">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>English Name</th>
                                <th>Khmer Name</th>
                                <th>Code</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Position</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <!-- <th>NATION</th> -->
                                <th>STATUS</th>
                                <th rowspan="3">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $value) { ?>
                                <tr>
                                    <td><?php
                                        if (isset($_GET['page']) && $_GET['page'] > 1)
                                            echo ($_GET['page'] - 1) * 10 + ($key + 1);
                                        else
                                            echo ($key + 1);
                                        ?></td>
                                    <td><?php echo $value['En_name']; ?></td>
                                    <td><?php echo $value['Kh_name']; ?></td>
                                    <td><?php echo $value['Staff_code']; ?></td>
                                    <td><?php echo $value['Gender']; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($value['DOB'])); ?></td>
                                    <td><?php echo $value['Position']; ?></td>
                                    <td><?php echo $value['Address']; ?></td>
                                    <td><?php echo $value['Phone']; ?></td>
                                    <td><?php echo $value['Status']; ?></td>
                                    <td>
                                        <a href="update_teacher.php?t_id=<?php echo $value['id'] ?>">
                                            <i class="fa fa-edit text-success"></i>
                                        </a>
                                        <a class="m-2" href="all_condition.php?t_id=<?php echo $value['id'] ?>"
                                            onclick="return confirm('Do you want to delete this record?')">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                        <a href="">
                                            <i class="nav-icon fas fa-ellipsis-h"></i>
                                        </a>
                                    </td>
                                    <!-- <td>
                                    <a href="addstudent.php?student_id=<?php echo $value['Stuid'] ?>">
                                        <i class="fa fa-edit" style="color: chocolate;"></i>
                                        <span style="color: chocolate;">Edit</span></a>
                                </td> -->
                                    <!-- <td><a href="addstudent.php?student_id=<?php echo $value['Stuid'] ?>"><i class="fa fa-edit"></i> Edit</a></td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
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
                        ?>"><a class="page-link" href="teacher_list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                            <li class="page-item"><a class="page-link" href="teacher_list.php?page=
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
        </div>
    </div>
    <!-- /.row -->
</section>
</div>
<?php include_once "footer.php"; ?>