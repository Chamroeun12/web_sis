<?php
include 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle student removal from class
if (isset($_GET['remove_id']) && isset($_GET['class_id'])) {
    $student_id = $_GET['remove_id'];
    $class_id = $_GET['class_id'];

    $remove_sql = "DELETE FROM tb_add_to_class WHERE Stu_id = :student_id AND Class_id = :class_id";
    $stmt = $conn->prepare($remove_sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Fetch students assigned to the selected class
if (isset($_POST['addclass'])) {
    $class_id = $_POST['addclass'];

    $sql = "SELECT stu.ID, stu.En_name, c.Class_name
            FROM tb_student stu
            JOIN tb_add_to_class atc ON stu.ID = atc.Stu_id
            JOIN tb_class c ON c.ClassID = atc.Class_id
            WHERE atc.Class_id = :class_id LIMIT 10";
    if (isset($_GET['page'])) {
        if ($_GET['page'] > 1) {
            $sql .= " OFFSET " . ($_GET['page'] - 1) * 10;
        }
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->execute();
    $students_in_class = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch all classes for the dropdown
$sql = "SELECT * FROM tb_class";
$stmt = $conn->prepare($sql);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//pages
$sql  = "SELECT COUNT(*) AS CountRecords FROM tb_add_to_class";
$stmt = $conn->prepare($sql);
$stmt->execute();
$temp = $stmt->fetch(PDO::FETCH_ASSOC);

$maxpage = 1;
if ($temp) {
    $maxpage = ceil($temp['CountRecords'] / 10);
}
?>
<!-- this onclude hthggjjsdjjjjjjjjjjjjjjjjjjjj -->
<?php include_once 'header.php'; ?>

<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h3 class="m-0" style="font-family:Khmer OS Siemreap; color:#152550;">
                    |Student List
                </h3>
            </div>
        </div>
    </div>

    <!-- /.row -->
    <div class="row m-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tool">
                        <form name="classform" method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="addclass" id="" class="form-control">
                                            <option value="">--Select Class--</option>
                                            <?php foreach ($classes as $row) : ?>
                                            <option value="<?= $row['ClassID']; ?>"
                                                <?= isset($_POST['addclass']) && $_POST['addclass'] == $row['ClassID'] ? 'selected' : '' ?>>
                                                <?= $row['Class_name']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="ml-3">
                                        <input type="submit" value="Show" name="btnsave" class="btn btn-success">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="width: 300px;">
                                        <input type="text" id="" name="namesearch"
                                            class="search form-control float-right" placeholder="Search"
                                            style="font-family:Khmer OS Siemreap;">
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive p-0 text-sm">
                <table class="table table-hover text-nowrap" style="font-family:Khmer OS Siemreap;" id="userTbl">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Class Name</th>
                            <th>English Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">
                        <!-- Show students already in the class -->
                        <?php if (isset($students_in_class) && !empty($students_in_class)) { ?>
                        <?php foreach ($students_in_class as $key => $student) { ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= $student['Class_name']; ?></td>
                            <td><?= $student['En_name']; ?></td>
                            <td>
                                <!-- Remove button to delete the student from the class -->
                                <a href="?remove_id=<?= $student['ID']; ?>&class_id=<?= $class_id; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to remove this student?');">
                                    Remove
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td colspan="4">No students found for the selected class.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Page -->
            <div class="card-footer">
                <div class="card-tools">
                    <ul class="pagination pagination-sm float-right">
                        <li class="page-item"><a class="page-link" href="student_in_class.php?page=
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
                        ?>"><a class="page-link"
                                href="student_in_class.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php } ?>
                        <li class="page-item"><a class="page-link" href="student_in_class.php?page=
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
    </div>
    <!-- /.row -->
</section>

<?php include_once 'footer.php'; ?>