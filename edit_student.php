<?php require_once './Database/database.php'; ?>

<?php

if (isset ($_GET['id']) && !empty ($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
} else {
    header('Location: ./index.php');
}

$students =$db->show('details');
$student = $db->show_single_user('details', $id);

$error = $success = '';
$id = $student['id'];
$name = $student['student_name'];
$email = $student['student_email'];
$phone_number = $student['phone_number'];
$course = $student['course'];

if (isset ($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $course = htmlspecialchars($_POST['course']);

    if (empty($id)) {
        $error = 'Please provide your ID';
    } elseif(empty($name)) {
        $error = 'Please provide your name';
    } elseif (empty($email)) {
        $error = 'Please provide your email';
    } elseif (empty($phone_number)) {
        $error = 'Please provide your phone number';
    } elseif (empty($course)) {
        $error = 'Please provide your course';
    } else {

        foreach($students as $student) {
            if ($student['id'] !== $id) {
                if ($student['id'] == $id) {
                    $error = "ID already exsists";
                }
            }
        }

        if ($error !== "ID already exsists") {
            $details_array = [
                "id" => $id,
                "student_name" => $name,
                "student_email" => $email,
                "phone_number" => $phone_number,
                "course" => $course
            ];
            $edited = $db->update('details', $details_array, $id); 
            if ($edited) {
                $success = "Student has been successfully edited";
            } else {
                $error = "Student has failed to edit";
            }
        } 
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header text-end">
                        <a href="./index.php" class="btn btn-outline-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $id; ?>" method="post">
                            <div class="text-danger"><?php echo $error; ?></div>
                            <div class="text-success"><?php echo $success; ?></div>

                            <div class="mb-2">
                                <label for="id">Student ID</label>
                                <input type="text" name="id" id="id" class="form-control" placeholder="Enter your ID!" value="<?php echo $id; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name!" value="<?php echo $name; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email!" value="<?php echo $email; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="phone_number">Phone Number </label>
                                <input type="tel " name="phone_number" id="phone_number" class="form-control" placeholder="Enter your Phone Number!" value="<?php echo $phone_number; ?>">
                            </div>

                            <div class="mb-2">
                                <label for="course">Course</label>
                                <input type="text " name="course" id="course" class="form-control" placeholder="Enter your Course!" value="<?php echo $course; ?>">
                            </div>

                            <div>
                                <input type="submit" name="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</html>