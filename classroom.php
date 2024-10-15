<?php
include_once 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch courses and teachers
$course = "SELECT * FROM tb_course";
$stmt = $conn->prepare($course);
$stmt->execute();
$Course = $stmt->fetchAll(PDO::FETCH_ASSOC);

$teacher = "SELECT * FROM tb_teacher";
$stmt = $conn->prepare($teacher);
$stmt->execute();
$Teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables
$status = '';
$search = '';

// Check if form is submitted via GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
    }
    if (isset($_GET['search'])) {
        $search = htmlspecialchars($_GET['search']);
    }
}

// Fetch classes based on status
$sql = "SELECT * FROM tb_class c
        INNER JOIN tb_course co ON c.Course_id = co.id
        INNER JOIN tb_teacher t ON c.Teacher_id = t.id";

if ($status) {
    $sql .= " WHERE c.status = :status"; // Assuming 'status' is a column in tb_class
}

$sql .= " ORDER BY Class_name ASC";

$stmt = $conn->prepare($sql);
if ($status) {
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
}
$stmt->execute();
$Class = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Insert Class
if (isset($_POST['btnsave'])) {
    $sql = "INSERT INTO tb_class(Class_name, Teacher_id, Course_id, Time_in, Time_out, Shift, Start_class, End_class)
            VALUES(:Class_name, :Teacher_id, :co, :Time_in, :Time_out, :Shift, :Start_class, :End_class)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":Class_name", $_POST['class_name'], PDO::PARAM_STR);
    $stmt->bindParam(":Teacher_id", $_POST['teacher_name'], PDO::PARAM_INT);
    $stmt->bindParam(":co", $_POST['co'], PDO::PARAM_INT);
    $stmt->bindParam(":Time_in", $_POST['time_in'], PDO::PARAM_STR);
    $stmt->bindParam(":Time_out", $_POST['time_out'], PDO::PARAM_STR);
    $stmt->bindParam(":Shift", $_POST['shift'], PDO::PARAM_STR);
    $stmt->bindParam(":Start_class", $_POST['start_class'], PDO::PARAM_STR);
    $stmt->bindParam(":End_class", $_POST['end_class'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount()) {
        header('Location: classroom.php');
        exit;
    }
}

// Pagination setup
$sql  = "SELECT COUNT(*) AS CountRecords FROM tb_class";
$stmt = $conn->prepare($sql);
$stmt->execute();
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

$maxpage = $temp ? ceil($temp['CountRecords'] / 10) : 1;

// Fetch class details if class_id is set
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM tb_add_to_class atc
            JOIN tb_class c ON c.ClassID = atc.Class_id
            JOIN tb_student stu ON stu.ID = atc.Stu_id
            WHERE atc.id=:class_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include_once "header.php";
?>

<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h2 class="m-0">| Classroom</h2>
            </div>
            <div class="col-sm-6">
                <h3 class="card-title float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modal-lg">Create</button>
                </h3>
            </div>
        </div>
    </div>

    <!-- Pop up -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="classform" method="post" action="">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="inputName">Class Name</label>
                                    <input type="text" name="class_name" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputName">Teacher Name</label>
                                    <select name="teacher_name" class="form-control">
                                        <option selected disabled value="">Select Teacher</option>
                                        <?php foreach ($Teacher as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['En_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputName">Course Name</label>
                                    <select name="co" class="form-control">
                                        <option selected disabled value="">Select Course</option>
                                        <?php foreach ($Course as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['Course_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="inputName">Time In</label>
                                    <input type="text" name="time_in" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputName">Time Out</label>
                                    <input type="text" name="time_out" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputStatus">Start Class</label>
                                    <input type="date" name="start_class" class="form-control"> <!-- Fixed name here -->
                                </div>
                                <div class="col-md-3">
                                    <label for="pob">End Class</label>
                                    <input type="date" name="end_class" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="">Shift</label>
                                    <select name="shift" class="form-control">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" value="Save" name="btnsave" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="form-group" style="width: 300px;">
                            <input type="text" name="namesearch" class="search form-control float-right"
                                placeholder="Search" style="font-family:Khmer OS Siemreap;">
                        </div>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"
                        style="float: right; margin-right: 10px;">
                        <input type="hidden" name="search"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <select name="status" onchange="this.form.submit()" class="form-select custom-select"
                            style="width: 250px;">
                            <option value="" <?php echo ($status == '') ? 'selected' : ''; ?>>All</option>
                            <option value="active" <?php echo ($status === 'active') ? 'selected' : ''; ?>>Active
                            </option>
                            <option value="disable" <?php echo ($status === 'disable') ? 'selected' : ''; ?>>Disable
                            </option>
                        </select>
                    </form>
                </div>

                <div class="card-body table-responsive p-0 text-sm">
                    <table class="table table-hover text-nowrap" style="font-family:Khmer OS Siemreap;" id="userTbl">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Class Name</th>
                                <th>Teacher Name</th>
                                <th>Course Name</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Start Class</th>
                                <th>End Class</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($Class as $row) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['Class_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['En_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Course_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Time_in']); ?></td>
                                <td><?php echo htmlspecialchars($row['Time_out']); ?></td>
                                <td><?php echo htmlspecialchars($row['Start_class']); ?></td>
                                <td><?php echo htmlspecialchars($row['End_class']); ?></td>
                                <td><?php echo htmlspecialchars($row['Shift']); ?></td>
                                <td>
                                    <?php if ($row['status'] == 'active') { ?>
                                    <span class="badge badge-success">Active</span>
                                    <?php } else { ?>
                                    <span class="badge badge-danger">Disabled</span>
                                    <?php } ?>
                                </td>
                                <td>
                                  <form action="report_data.php" method="POST">
                                      <button type="submit" name="print" title="Print"><i class="fa fa-print text-dark" style=" font-size: 18px;"></i></button>
                                      <button type="submit" name="export_pdf" title="PDF" ><i class="fa fa-file-pdf text-danger ml-2" style=" font-size: 18px;"></i></button>
                                      <button type="submit" name="export_excel" title="Excel"><i class="fa fa-file-excel text-success ml-2" style=" font-size: 18px;"></i></button>
                                  </form>
                                    <i class="nav-icon fas fa-ellipsis-v text-info ml-2 dropup" style=" font-size:
                                        18px; cursor:pointer;" data-toggle="dropdown" ></i>
                                    <div class="dropdown-menu">
                                        <a href="" class="dropdown-item"><i class="fa fa-edit text-success"></i>
                                            Edit</a>
                                        <a href="" onclick="return confirm('Do you want to delete this record?')"
                                            class="dropdown-item"><i class="fa fa-trash text-danger"></i> Delete</a>

                                    </div>

                                    <!-- <a href="">
                                        <i class="nav-icon fas fa-ellipsis-v ml-2"></i>
                                        <a href="classroom.php?class_id=<?php echo $row['ClassID']; ?>"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="classroom.php?delete_class_id=<?php echo $row['ClassID']; ?>"><i
                                                class="fa fa-trash text-danger"></i></a>
                                    </a> -->
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once "footer.php"; ?>
