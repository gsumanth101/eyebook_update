<?php include "sidebar.php"; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="font-weight-bold mb-4">Course Management: <?php echo htmlspecialchars($course['name'] ?? ''); ?></h2>
                    <span class="badge bg-primary text-white">Course ID: <?php echo htmlspecialchars($course['id'] ?? ''); ?></span>
                </div>
            </div>
        </div>

        <!-- Overview and Course Control Panel -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Course Overview</h4>
                        
                        <!-- Course Plan Section -->
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Course Plan</h5>
                            <?php if (!empty($course['course_plan'])) : ?>
                                <button class="btn btn-primary" onclick="redirectToCoursePlan()">View</button>
                            <?php endif; ?>
                        </div>

                        <!-- Course Book Section -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <h5>Course Book</h5>
                            <?php if (!empty($course['course_book'])) : ?>
                                <?php
                                $hashedId = base64_encode($course['id']);
                                $hashedId = str_replace(['+', '/', '='], ['-', '_', ''], $hashedId);
                                ?>
                                <button class="btn btn-primary" onclick="redirectToCourseBook('<?php echo $hashedId; ?>')">View</button>
                            <?php endif; ?>
                        </div>

                        <table class="table table-hover mt-2">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">S. No.</th>
                                    <th scope="col">Unit Title</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Completed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $studentCompletedBooks = json_decode($student['completed_books'] ?? '[]', true)[$course['id']] ?? [];
                                if (!empty($course['course_book'])) {
                                    $serialNumber = 1; 
                                    foreach ($course['course_book'] as $unit) {
                                        if (isset($unit['materials'])) {
                                            foreach ($unit['materials'] as $material) {
                                                $isCompleted = in_array($material['indexPath'], $studentCompletedBooks);
                                                echo "<tr>";
                                                echo "<td>" . $serialNumber++ . "</td>"; // Increment the serial number
                                                echo "<td>" . htmlspecialchars($unit['unitTitle']) . "</td>";
                                                $full_url = $material['indexPath'];
                                                echo "<td><a href='/student/view_book/" . $hashedId . "?index_path=" . urlencode($full_url) . "' class='btn btn-primary'>View Course Book</a></td>";
                                                echo "<td><button class='btn btn-success' onclick='markAsCompleted(\"" . htmlspecialchars($full_url) . "\", " . ($isCompleted ? "true" : "false") . ", this)'>" . ($isCompleted ? "Completed" : "Mark as Completed") . "</button></td>";
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No course books available.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        
                        <!-- Course Materials Section -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <h5>Course Materials</h5>
                        </div>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Unit Number</th>
                                    <th scope="col">Topic</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($course['course_materials'])) {
                                    foreach ($course['course_materials'] as $unit) {
                                        if (isset($unit['materials'])) {
                                            foreach ($unit['materials'] as $material) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($unit['unitNumber']) . "</td>";
                                                echo "<td>" . htmlspecialchars($unit['topic']) . "</td>";
                                                $full_url = $material['indexPath'];
                                                echo "<td><a href='#' class='btn btn-primary' onclick='redirectToCourseMaterial(\"" . htmlspecialchars($full_url) . "\")'>View</a></td>";
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No course materials available.</td></tr>";
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

<script>
function redirectToCoursePlan() {
    var coursePlan = <?php echo json_encode($course['course_plan'] ?? []); ?>;
    var baseUrl = "http://localhost/eyebook_update/"; // Replace with your actual base URL
    var coursePlanUrl = "";
    if (coursePlan && coursePlan.url) {
        coursePlanUrl = baseUrl + coursePlan.url;
    }

    if (coursePlanUrl) {
        window.open(coursePlanUrl, '_blank');
    } else {
        alert('Course Plan URL not available.');
    }
}

function redirectToCourseBook(hashedId) {
    var baseUrl = "http://localhost/eyebook_update/"; // Replace with your actual base URL
    var courseBookUrl = baseUrl + "book_view.php?course_id=" + hashedId;

    if (hashedId) {
        window.location.href = courseBookUrl;
    } else {
        alert('Course Book URL not available.');
    }
}

function redirectToCourseMaterial(url) {
    var baseUrl = "http://localhost/eyebook_update/"; // Replace with your actual base URL
    var courseMaterialUrl = baseUrl + url;

    if (url) {
        window.open(courseMaterialUrl, '_blank');
    } else {
        alert('Course Material URL not available.');
    }
}

function markAsCompleted(indexPath, isCompleted, button) {
    if (isCompleted) {
        alert('This course book is already marked as completed.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/student/mark_as_completed", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert('Course book marked as completed.');
            button.innerHTML = 'Completed';
            button.disabled = true;
        }
    };
    xhr.send("indexPath=" + encodeURIComponent(indexPath) + "&course_id=<?php echo $course['id']; ?>");
}
</script>