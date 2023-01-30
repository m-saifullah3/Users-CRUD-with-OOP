<?php require_once './Database/database.php' ?>

<?php

if (isset ($_GET['id']) && !empty ($_GET['id'])) {
    $student_id = htmlspecialchars($_GET['id']);
} else {
    header('Location: ./index.php');
}

$deleted = $db->delete('details', $student_id);

if ($deleted) {
    header('Location: ./index.php');
} else {
    echo 'Student has failed to delete';
}

?>