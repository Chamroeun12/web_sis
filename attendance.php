<?php
include 'connection.php';

$sql = "SELECT * FROM tb_class";
$stmt = $conn->prepare($sql);
$stmt->execute();
$class = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $sql = "SELECT * FROM tb_class";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<?php include_once "header.php"; ?>

<section class="content-wrapper">

    <form action="" id="">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div id="msg"></div>
                <div class="card mb-3">
                    <div class="card-body rounded-0">
                        <div class="container-fluid">
                            <div class="row align-items-end">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <label for="" class="form-label">Class</label>
                                    <select name="" id="" class="form-control" required="required">
                                        <option selected disabled>--Select Class--</option>
                                        <?php if ($class): ?>
                                        <?php foreach ($class as $row): ?>
                                        <option value="<?= $row['ClassID']; ?>"><?= $row['Class_name'] ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <label for="class_date" class="form-label">Date</label>
                                    <input type="date" name="class_date" id="class_date" class="form-control" value=""
                                        required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card m-3">
                    <div class="card-header rounded-0">
                        <div class="card-title">Attendance Sheet</div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="table-responsive">
                                <table id="attendance-tbl" class="table table-bordered">
                                    <!-- <colgroup>
                                        <col width="5%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                    </colgroup> -->
                                    <thead class="">
                                        <tr>
                                            <th class="text-center text-dark">#</th>
                                            <th class="text-center text-dark">Code</th>
                                            <th class="text-center text-dark">Students
                                            <td>1</td>
                                            <td>2</td>
                                            </th>
                                            <!-- <th class=""> -->

                                            <!-- </th> -->
                                            <!-- <th class="text-center text-success">Present</th>
                                            <th class="text-center text-warning">Permission</th>
                                            <th class="text-center text-danger">Absent</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr> -->
                                        <!-- <th class="text-center px-2 py-1 text-dark-emphasis">Check/Uncheck All</th> -->
                                        <!-- <th class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input checkAll" type="checkbox"
                                                        id="PCheckAll">
                                                    <label class="form-check-label" for="PCheckAll">
                                                    </label>
                                                </div>
                                            </th> -->
                                        <!-- <th class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input checkAll" type="checkbox"
                                                        id="LCheckAll">
                                                    <label class="form-check-label" for="LCheckAll">
                                                    </label>
                                                </div>
                                            </th> -->
                                        <!-- </tr> -->
                                        <tr class="student-row">
                                            <td class="px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                1
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                2222
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                Chamroeun
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id=""
                                                        type="checkbox" name="status[]" value="1" id="">
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id=""
                                                        type="checkbox" name="status[]" value="2" id="">

                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id=""
                                                        type="checkbox" name="status[]" value="3" id="">
                                                    <label class="form-check-label" for="">
                                                    </label>
                                                </div>
                                            </td>
                                            <!-- <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id=""
                                                        type="checkbox" name="status[]" value="4" id="" <label
                                                        class="form-check-label" for="">
                                                    </label>
                                                </div>
                                            </td> -->
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="5" class="px-2 py-1 text-center">No Student Listed Yet</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <button class="btn btn-primary rounded-pill w-100" type="submit">Save Attendance</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>


<?php include_once "footer.php"; ?>