<?php
include_once'connection.php';

// Fetch all classes for the dropdown
$sql = "SELECT * FROM tb_student";
$stmt = $conn->prepare($sql);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include_once "header.php"; ?>

<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-2 card-header">
            <div class="col-sm-6">
                <h1 class="m-0">|Report</h1>
            </div>
            <!-- /.col -->

        </div>
    </div>
    <div class="row m-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
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
                                    <div class="">
                                        <input type="submit" value="Show" name="btnshow" class="btn btn-success">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                <div class="">
                                        <input type="submit" value="Print" name="btnprint" class="btn btn-success">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                <div class="">
                                        <input type="submit" value="pdf" name="btnpdft" class="btn btn-success">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                <div class="">
                                        <input type="submit" value="excel" name="btnexcel" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div>

</section>

<?php include_once "footer.php"; ?>

