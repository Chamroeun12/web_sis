<?php include "connection.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['user'])) {
        // Redirect to login page or display an error message
        header('Location: login-v2.php');
        exit;
    }
}



?>

<?php include_once 'header.php'; ?>


<div class="content-wrapper">
    <!-- <?php
            if (isset($_GET['backup']) && $_GET['backup'] === 'success') {
                echo "<p>Backup completed successfully!</p>";
            } else {
                echo "<p>Backup failed!</p>";
            }
            ?> -->
    <!-- Content Header (Page header) -->
    <!-- <?php print_r($_COOKIE['Chamroeun']); ?> -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">|ទំព័រដើម</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <?php print_r($_SESSION['role']) ?>
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">ចំនួនសិស្សសរុប</span>
                            <span class="info-box-number">
                                <?php
                                $sql  = "SELECT ID FROM tb_student";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                echo Count($all);
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-tie"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">ចំនួនគ្រូបង្រៀនសរុប</span>
                            <span class="info-box-number">
                                <?php
                                $sql  = "SELECT id FROM tb_teacher";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                echo Count($all);
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-warehouse"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">ចំនួនថ្នាក់រៀនសរុប</span>
                            <span class="info-box-number">
                                <?php
                                $sql  = "SELECT ClassID FROM tb_class";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                echo Count($all);
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-purple elevation-1 "><i class="fas fa-book"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">ចំនួនវគ្គសិក្សាសរុប</span>
                            <span class="info-box-number">
                                <?php
                                $sql  = "SELECT id FROM tb_course";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                echo Count($all);
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
</div>
<!-- /.row -->


<?php include_once 'footer.php'; ?>