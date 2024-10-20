<?php
// Database connection and include sidebar
include "sidebar.php";
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id == 0) {
    die("Invalid course ID.");
}

// Fetch course details
$sql = "SELECT * FROM courses WHERE id = $course_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
} else {
    die("Course not found.");
}



// Decode JSON data
$course_data = json_decode($course['content'], true);

// Close the DB connection
$conn->close();
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="font-weight-bold mb-4">Course Management: <?php echo htmlspecialchars($course['name']); ?></h2>
                    <span class="badge bg-primary text-white">Course ID: <?php echo $course_id; ?></span>
                </div>
            </div>
        </div>

        <!-- Overview and Course Control Panel -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Course Overview</h4>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <!-- <th scope="col">#</th> -->
                                    <th scope="col">Course Attribute</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // $counter = 1;
                                foreach ($course_data as $unit) {
                                    echo "<tr>";
                                    // echo "<td>" . $counter++ . "</td>";
                                    echo "<td>Unit Title</td>";
                                    echo "<td>" . htmlspecialchars($unit['unitTitle']) . "</td>";
                                    echo "</tr>";
                                    foreach ($unit['materials'] as $material) {
                                        echo "<tr>";
                                        // echo "<td>" . $counter++ . "</td>";
                                        // echo "<td>SCORM Directory</td>";
                                        // echo "<td>" . htmlspecialchars($material['scormDir']) . "</td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        // echo "<td>" . $counter++ . "</td>";
                                        // echo "<td>Index Path</td>";
                                        $base_url = "http://localhost/eyebook/"; // Replace with your actual base URL
                                        $full_url = $base_url . $material['indexPath'];
                                        
                                        echo "<td><iframe src='" . $full_url . "' width='600' height='400'></iframe></td>";
                                        
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.html'; ?>
</div>
