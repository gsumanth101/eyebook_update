<?php
include("sidebar.php");


// Fetch courses from the database
$sql = "SELECT id, name, description FROM courses";
$result = $conn->query($sql);
$courses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

$conn->close();
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <!-- <h3 class="font-weight-bold">Hello, <em><?php echo htmlspecialchars($userData['name']); ?></em></h3> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <p class="card-title mb-0" style="font-size:x-large">My Courses</p><br>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4 d-flex align-items-stretch">
                            <div class="card mb-4" style="width: 100%;">
                                <!-- <img class="card-img-top" src="../views\public\assets\images\book.jpeg" alt="Card image cap" height="60%"> -->
                                <div class="card-body">
                                    <h5 class="card-title" style="font-family:cursive"><?php echo htmlspecialchars($course['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                                </div>
                                <div class="card-body">
                                    <a href="view_course.php?id=<?php echo $course['id']; ?>" class="card-link">View Course</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <?php include 'footer.html'; ?>
</div>

<!-- Include Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">