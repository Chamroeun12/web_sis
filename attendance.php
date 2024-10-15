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
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success rounded-pill mr-2" type="submit">Submit</button>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="table-responsive">
                                <table id="attendance-tbl" class="table table-bordered">
                                    <!-- <colgroup>
                                    </colgroup> -->
                                    <thead class="">
                                        <tr>
                                            <th class="text-center text-dark">#</th>
                                            <th class="text-center text-dark">Student Namse</th>
                                            <th class="text-center text-dark">StuCode
                                            <td class="text-center text-success">Present</td>
                                            <td class="text-center text-warning">Permission</td>
                                            <td class="text-center text-danger">Absent</td>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="student-row">
                                            <td class="px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                1
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                Saran Chamrouen
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                SIS001
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
                                        </tr>

                                        <tr class="student-row">
                                            <td class="px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                2
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                Chheng vichet
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="">
                                                SIS002
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
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="5" class="px-2 py-1 text-center">No Student Listed Yet</td>
                                        </tr> -->
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
                    </div>
                </div>
                <!-- <div class="d-flex ">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <button class="btn btn-primary rounded-pill w-50" type="submit">Save Attendance</button>
                    </div> -->
            </div>
        </div>
        </div>
    </form>
</section>


<?php include_once "footer.php"; ?>