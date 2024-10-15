<?php
include 'connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch Classes
$sql = "SELECT * FROM tb_class";
$stmt = $conn->prepare($sql);
$stmt->execute();
$class = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Students
$sql = "SELECT * FROM tb_student";
$stmt = $conn->prepare($sql);
$stmt->execute();
$student = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch joined records
$sql = "SELECT * FROM tb_add_to_class atc
        JOIN tb_class c ON c.ClassID = atc.Class_id
        JOIN tb_student stu ON stu.ID = atc.Stu_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$joinclass = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if (isset($_POST['btnsave'])) {
    $class_id = $_POST['addclass'];
    $students = $_POST['addstu'];  // This is an array of selected students
    if (!empty($class_id) && !empty($students)) {
        foreach ($students as $student_id) {
            $sql = "INSERT INTO tb_add_to_class(Stu_id, Class_id) VALUES(:Stu_id, :Class_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":Stu_id", $student_id, PDO::PARAM_INT);
            $stmt->bindParam(":Class_id", $class_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        header('Location: class.php');
        exit();
    } else {
        echo '<script>alert("Please select a class and students!")</script>';
    }
}

// Pagination logic
$sql  = "SELECT COUNT(*) AS CountRecords FROM tb_add_to_class";
$stmt = $conn->prepare($sql);
$stmt->execute();
$temp = $stmt->fetch(PDO::FETCH_ASSOC);
$maxpage = ceil($temp['CountRecords'] / 10);
?>

<?php include_once 'header.php'; ?>
<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h3 class="m-0" style="font-family:Khmer OS Siemreap; color:#152550;">
                    |Class
                </h3>
            </div>
        </div>
    </div>
    <div class="row m-2">
        <div class="col-12">
            <div class="card">
                <form name="classform" method="post" action="">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <!-- Class selection dropdown -->
                                    <select name="addclass" class="form-control">
                                        <option value="">--Select Class--</option>
                                        <?php foreach ($class as $row) : ?>
                                            <option value="<?= $row['ClassID']; ?>"><?= $row['Class_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="ml-3">
                                        <!-- Submit button -->
                                        <input type="submit" value="Submit" name="btnsave" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="width: 300px;">
                                <input type="text" name="namesearch" class="search form-control float-right"
                                       placeholder="Search" style="font-family:Khmer OS Siemreap;">
                            </div>
                        </div>
                    </div>
            </div>

            <div class="card-body table-responsive p-0 text-sm">
                <table class="table table-hover text-nowrap" style="font-family:Khmer OS Siemreap;" id="userTbl">
                    <thead>
                        <tr>
                            <th>Check</th>
                            <th>No</th>
                            <th>Student Code</th>
                            <th>English Name</th>
                            <th>Khmer Name</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">
                        <?php if (isset($student)) { ?>
                            <?php foreach ($student as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" name="addstu[]" value="<?php echo $value['ID']; ?>" id="check<?php echo $key; ?>">
                                            <label for="check<?php echo $key; ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo ($key + 1); ?></td>
                                    <td><?php echo $value['Stu_code']; ?></td>
                                    <td><?php echo $value['En_name']; ?></td>
                                    <td><?php echo $value['Kh_name']; ?></td>
                                    <td><?php echo $value['Gender']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </form>
            <!-- this form table -->
        </div>
    </div>
</section>
<?php include_once 'footer.php'; ?>
