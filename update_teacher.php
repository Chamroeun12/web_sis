<?php
include "connection.php";

if (isset($_POST['btnsave'])) {
    if (isset($_GET['t_id'])) {
        $sql = "UPDATE tb_teacher SET En_name=:En_name, Kh_name=:Kh_name, Staff_code=:Staff_code, Gender=:Gender, DOB=:DOB, Position=:Position, Address=:Address, Phone=:Phone, Nation=:Nation, Ethnicity=:Ethnicity, Status=:Status WHERE id=:id";
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
        $stmt->bindParam(":id", $_GET['t_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
    if ($stmt->rowCount()) {
        header('Location: teacher_list.php');
        exit;
    }
}

if (isset($_GET['t_id'])) {
    $sql = "SELECT * FROM tb_teacher WHERE id=:id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['t_id'], PDO::PARAM_INT);
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
                <h1 class="m-0">|Edit Teacher</h1>
            </div>
            <!-- /.col -->

        </div>
    </div>
    <div class="m-4 card">
        <form name="teacherform" method="post" action="">
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="inputName">English Name</label>
                            <input type="text" id="enName" name="En_name" class="form-control"
                                value="<?php echo !isset($data) ? '' : $data['En_name']; ?>">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputName">Khmer Name</label>
                                <input type="text" id="khName" name="Kh_name" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Kh_name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control"
                                value="<?php echo !isset($data) ? '' : $data['DOB']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputStatus">Position</label>
                                <input type="text" name="position" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Position']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputStatus">Code Number</label>
                                <input type="text" name="code" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Staff_code']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputStatus">Nationality</label>
                                <input type="text" name="nation" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Nation']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputStatus">Ethnicity</label>
                                <input type="text" name="ethnicity" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Ethnicity']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <input type="text" name="status" id="" class="form-control"
                                    value="<?php echo !isset($data) ? '' : $data['Status']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Address</label>
                        <textarea id="inputDescription" name="address" class="form-control"
                            rows="3"><?php echo !isset($data) ? '' : $data['Address']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputPhone">Phone</label>
                        <input type="text" id="inputPhone" name="phone" class="form-control"
                            value="<?php echo !isset($data) ? '' : $data['Phone']; ?>">
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
    </div>
    <!-- /.modal-dialog -->
    </div>

</section>


<?php include_once "footer.php"; ?>