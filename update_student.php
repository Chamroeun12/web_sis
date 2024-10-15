<?php
include "connection.php";

if (isset($_POST['btnsave'])) {
    if (isset($_GET['stu_id'])) {
        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = 'images/' . $file_name;
        if (move_uploaded_file($tempname, $folder)) {
            echo "Image uploaded successfully";
        } else {
            echo "Failed to upload image";
        }
        $sql = "UPDATE tb_student SET Stu_code=:Stu_code,En_name=:En_name, Kh_name=:Kh_name, Gender=:Gender, DOB=:DOB, Address=:Address, Status=:Status, Dad_name=:Dad_name, Mom_name=:Mom_name, Dad_job=:Dad_job, Mom_job=:Mom_job, Phone=:Phone, Profile_img=:Profile WHERE ID=:ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":Stu_code", $_POST['code'], PDO::PARAM_STR);
        $stmt->bindParam(":En_name", $_POST['en_name'], PDO::PARAM_STR);
        $stmt->bindParam(":Kh_name", $_POST['kh_name'], PDO::PARAM_STR);
        $stmt->bindParam(":Gender", $_POST['gender'], PDO::PARAM_STR);
        $stmt->bindParam(":DOB", $_POST['dob'], PDO::PARAM_STR);
        $stmt->bindParam(":Address", $_POST['address'], PDO::PARAM_STR);
        $stmt->bindParam(":Status", $_POST['status'], PDO::PARAM_STR);
        $stmt->bindParam(":Dad_name", $_POST['dad_name'], PDO::PARAM_STR);
        $stmt->bindParam(":Mom_name", $_POST['mom_name'], PDO::PARAM_STR);
        $stmt->bindParam(":Dad_job", $_POST['dad_job'], PDO::PARAM_STR);
        $stmt->bindParam(":Mom_job", $_POST['mom_job'], PDO::PARAM_STR);
        $stmt->bindParam(":Phone", $_POST['phone'], PDO::PARAM_STR);
        $stmt->bindParam(":Profile", $file_name, PDO::PARAM_STR);
        $stmt->bindParam(":ID", $_GET['stu_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
    if ($stmt->rowCount()) {
        header('Location: student_list.php');
        exit;
    }
}

if (isset($_GET['stu_id'])) {
    $sql = "SELECT * FROM tb_student WHERE ID=:id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['stu_id'], PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        die("Can not find student with this ID.");
    }
}
?>

<?php include_once "header.php"; ?>
<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h3 class="m-0">|Edit Student</h3>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <div class="m-4 card">
        <form name="studentform" method="post" action="" enctype="multipart/form-data"
            style="font-family:Khmer OS Siemreap;">
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="en_name">Student Code</label>
                            <input type="text" class="form-control" id="code" name="code"
                                value="<?php echo !isset($data) ? '' : $data['Stu_code']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="inputName">English Name</label>
                            <input type="text" id="enName" name="en_name" class="form-control"
                                value="<?php echo !isset($data) ? '' : $data['En_name']; ?>">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputName">Khmer Name</label>
                                <input type="text" id="khName" name="kh_name" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Kh_name']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputStatus">Gender</label>
                                <select id="inputStatus" name="gender" class="form-control custom-select">
                                    <option selected disabled>Select one</option>
                                    <option value="Male"
                                        <?php echo !isset($data) ? '' : ($data['Gender'] == 'Male' ? 'selected' : ''); ?>>
                                        Male
                                    </option>
                                    <option value="Female"
                                        <?php echo !isset($data) ? '' : ($data['Gender'] == 'Female' ? 'selected' : ''); ?>>
                                        Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputDateOfBirth">Date Of Birth</label>
                                <input type="date" id="inputDateOfBirth" name="dob" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['DOB']; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputPhone">Phone</label>
                                <input type="text" id="inputPhone" name="phone" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Phone']; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" name="status" class="form-control custom-select">
                                    <option selected disabled>Select one</option>
                                    <option value="Active"
                                        <?php echo !isset($data) ? '' : ($data['Status'] == 'Active' ? 'selected' : ''); ?>>
                                        Active</option>
                                    <option value="Deactive"
                                        <?php echo !isset($data) ? '' : ($data['Status'] == 'Deactive' ? 'selected' : ''); ?>>
                                        Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">Dad Name</label>
                                <input type="text" name="dad_name" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Dad_name']; ?>">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Dad Job</label>
                                <input type="text" name="dad_job" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Dad_job']; ?>">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Mom Name</label>
                                <input type="text" name="mom_name" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Mom_name']; ?>">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Mom Job</label>
                                <input type="text" name="mom_job" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Mom_job']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Address</label>
                        <textarea id="inputDescription" name="address" class="form-control"
                            rows="2"><?php echo !isset($data) ? '' : $data['Address']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail">Igmage</label>
                        <input type="file" name="image" class="form-control" value="<?= $file_name; ?>"
                            accept="images/**" onchange="preview (event)">
                        <div style="margin-top: 9px">
                            <img src="images/<?= $file_name; ?>" alt="" id="img" width="200">
                        </div>

                    </div>
                </div>
            </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn bg-danger">
            <a href="student_list.php">Close</a>
        </button>
        <input type="submit" value="Save" name="btnsave" class="btn btn-success">
        <!-- <button type="button" class="btn btn-primary">Save</button> -->
    </div>
    </form>
    </div>
    </div>
    <!-- /.modal-dialog -->
    </div>

</section>


<?php include_once "footer.php"; ?>