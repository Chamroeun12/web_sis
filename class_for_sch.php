<?php
include_once 'connection.php';
//start seesion
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$course = "SELECT * FROM tb_course";
$stmt = $conn->prepare($course);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$teacher = "SELECT * FROM tb_teacher";
$stmt = $conn->prepare($teacher);
$stmt->execute();
$th = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT 
    tb_class.Course_id,tb_class.Teacher_id,tb_teacher.id,tb_course.id,tb_class.ClassID,tb_class.Class_name,tb_class.Class_Type,tb_class.Time_in,tb_class.Time_out,tb_class.Start_class,tb_class.End_class,tb_class.Shift,tb_course.Course_name,tb_teacher.En_name
FROM 
    ((tb_class 
INNER JOIN 
    tb_course ON tb_class.Course_id = tb_course.id)
INNER JOIN 
    tb_teacher ON tb_class.Teacher_id = tb_teacher.id)";
$stmt = $conn->prepare($sql);
$stmt->execute();
$course = $stmt->fetchAll(PDO::FETCH_ASSOC);


//insert Class
if (isset($_POST['btnsave'])) {
    $sql = "INSERT INTO tb_class(Class_name,Class_Type,Time_in,Time_out,Shift,Start_class,End_class) 
    VALUES(:name, :type,co_id,t_id, :time_in, :time_out, :start, :end, :shift)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $_POST['class_name'], PDO::PARAM_STR);
    $stmt->bindParam(":type", $_POST['class_type'], PDO::PARAM_STR);
    $stmt->bindParam(":co_id", $_POST['course_name'], PDO::PARAM_STR);
    $stmt->bindParam(":t_id", $_POST['teacher_name'], PDO::PARAM_STR);
    $stmt->bindParam(":time_in", $_POST['time_in'], PDO::PARAM_STR);
    $stmt->bindParam(":time_out", $_POST['time_out'], PDO::PARAM_STR);
    $stmt->bindParam(":shift", $_POST['shift'], PDO::PARAM_STR);
    $stmt->bindParam(":start", $_POST['start_class'], PDO::PARAM_STR);
    $stmt->bindParam(":end", $_POST['end_class'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount()) {
        header('Location: classroom.php');
        exit;
    }
}
//pages
$sql  = "SELECT COUNT(*) AS CountRecords FROM tb_class";
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
                <h2 class="m-0">|Classroom</h2>
            </div>
            <!-- <div class="col-sm-6">
                <h3 class="card-title float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                        Create
                    </button>
                </h3>
            </div> -->
        </div>
    </div>

    <!-- Pop up -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <?php if (isset($_GET['ID'])) { ?>
                        <h3 class="card-title" style="color:chocolate;">Edit Student</h3>
                    <?php } else { ?>

                        <h3 class="card-title" style="color:chocolate;">Add Student</h3>
                    <?php  } ?> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Condition to Add or Edit student -->

                <!-- form add and edit student -->
                <form name="classform" method="post" action="">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="inputName">Class Name</label>
                                    <input type="text" id="" name="class_name" class="form-control" value="">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputName">Class Type</label>
                                        <input type="text" id="" name="class_type" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputName">Course Name</label>
                                        <select name="course_name" id="" class="form-control">
                                            <?php foreach ($data as $row) { ?>
                                                <option class="form-control" value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['Course_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputDateOfBirth">Teacher Name</label>
                                        <select name="teacher_name" id="" class="form-control">
                                            <?php foreach ($th as $row) { ?>
                                                <option class="form-control" value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['En_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="inputName">Time In</label>
                                    <input type="time" id="" name="time_in" class="form-control" value="">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputName">Time Out</label>
                                        <input type="time" id="" name="time_out" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputStatus">Start Class</label>
                                        <input type="date" id="" name="Start_class" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pob">End Class</label>
                                        <input type="date" id="" name="end_class" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="">Shift</label>
                                    <select name="shift" id="" class="form-control">
                                        <option class="form-control" value="">AM</option>
                                        <option class="form-control" value="">PM</option>
                                    </select>
                                </div>
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
                        <input type="submit" value="Save" name="btnsave" class="btn btn-success">
                        <!-- <button type="button" class="btn btn-primary">Save</button> -->
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
                    <div class="card-tools">
                        <div class="form-group" style="width: 300px;">
                            <input type="text" id="" name="namesearch" class="search form-control float-right"
                                placeholder="Search" style="font-family:Khmer OS Siemreap;">
                            <div class=" input-group-append">
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
                                <th>Class Name</th>
                                <th>Class Type</th>
                                <th>Course Name</th>
                                <th>Teacher Name</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Start Class</th>
                                <th>End Class</th>
                                <th>Shift</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">
                            <?php if (isset($course)) { ?>
                                <?php foreach ($course as $key => $value) { ?>
                                    <tr>
                                        <td><?php
                                            if (isset($_GET['page']) && $_GET['page'] > 1)
                                                echo ($_GET['page'] - 1) * 10 + ($key + 1);
                                            else
                                                echo ($key + 1);
                                            ?></td>

                                        <td><?php echo $value['Class_name']; ?></td>
                                        <td><?php echo $value['Class_Type']; ?></td>
                                        <td><?php echo $value['Course_name']; ?></td>
                                        <td><?php echo $value['En_name']; ?></td>
                                        <td><?php echo $value['Time_in']; ?></td>
                                        <td><?php echo $value['Time_out']; ?></td>
                                        <td><?php echo $value['Start_class']; ?></td>
                                        <td><?php echo $value['End_class']; ?></td>
                                        <!-- <td><?php echo date('d-M-Y', strtotime($value['Start_class '])); ?></td>
                                <td><?php echo date('d-M-Y', strtotime($value['End_class '])); ?></td> -->
                                        <td><?php echo $value['Shift']; ?></td>
                                        <td>
                                            <a href="student_sch.php?class_id=<?php echo $value['ClassID'] ?>">View</a>
                                        </td>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            <li class="page-item"><a class="page-link" href="class.php?page=
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
                        ?>"><a class="page-link" href="class.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                            <li class="page-item"><a class="page-link" href="class.php?page=
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