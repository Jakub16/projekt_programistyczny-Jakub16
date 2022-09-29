<?php

    require_once "db_conn.php";
    if(isset($_POST['submit'])) {

        $sql = "UPDATE blog SET content = :new_content where id = :blog_id";
        if($stmt = $conn->prepare($sql)) {

            $p_content = $_POST['text_input'];
            $p_blog_id = $_POST['blog_id_input'];

            $stmt->bindParam(":new_content", $p_content, PDO::PARAM_STR);
            $stmt->bindParam(":blog_id", $p_blog_id, PDO::PARAM_STR);

            if($stmt->execute()) {
                echo "<script type = 'text/javascript'>alert('Pomyślnie zaktualizowano wpis.')</script>";
            }
            else {
                error_get_last();
            }
        }
        else {
            unset($stmt);
        }

        unset($conn);
    }


if (isset($_POST['delete'])) {

    $sql = "DELETE FROM blog where id = :blog_id";
    if ($stmt = $conn->prepare($sql)) {

        $p_blog_id = $_POST['blog_id_input'];

        $stmt->bindParam(":blog_id", $p_blog_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script type = 'text/javascript'>alert('Pomyślnie usunięto wpis.')</script>";
        } else {
            error_get_last();
        }
    } else {
        unset($stmt);
    }

    unset($conn);
}

?>