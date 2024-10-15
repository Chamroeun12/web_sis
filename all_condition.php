<?php
include "connection.php";

//  Delete student
if (isset($_GET['stu_id'])) {
    $sql = "DELETE FROM tb_student WHERE ID=:ID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":ID", $_GET['stu_id'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: student_list.php');
        exit;
    }
}
// Delete Teacher
if (isset($_GET['t_id'])) {
    $sql = "DELETE FROM tb_teacher WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['t_id'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: teacher_list.php');
        exit;
    }
}
// Delete add_to_class table
if (isset($_GET['remove_cid'])) {
    $sql = "DELETE FROM tb_add_to_class WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['remove_cid'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: class.php');
        exit;
    }
}
// Delete User
if (isset($_GET['user_id'])) {
    $sql = "DELETE FROM tb_login WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: user_info.php');
        exit;
    }
}
//Delete Monthly
if (isset($_GET['monthly_id'])) {
    $sql = "DELETE FROM tb_monthly WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['monthly_id'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: monthly.php?course_id');
        exit;
    }
}
//Delete Subject
if (isset($_GET['sub_id'])) {
    $sql = "DELETE FROM tb_subject WHERE SubID=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['sub_id'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: subject.php');
        exit;
    }
}
//Delete Course
if (isset($_GET['co_id'])) {
    $sql = "DELETE FROM tb_course WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['co_id'], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount()) {
        header('Location: tbl_course.php');
    }
}