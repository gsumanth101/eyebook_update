<?php
include("sidebar.php");


$email = $_SESSION['email'];

// Fetch user profile data
$profile = null;
$sql = "SELECT university_id FROM spocs WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
}
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $section = $_POST['section'];
    $stream = $_POST['stream'];
    $year = $_POST['year'];
    $department = $_POST['department'];
    $university_id = $profile['university_id'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO faculty (name, email, phone, section, stream, year, department, university_id, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $name, $email, $phone, $section, $stream, $year, $department, $university_id, $password);

    if ($stmt->execute()) {
        $message = "Faculty created successfully!";
    } else {
        $message = "Error creating faculty: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!-- HTML Content -->
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
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0" style="font-size:x-large">Add Faculty</p><br>
                        <?php if (isset($message)): ?>
                            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
                            <script>
                                setTimeout(function() {
                                    window.location.href = 'addFaculty.php';
                                }, 2000); // Redirect after 2 seconds
                            </script>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Section</label>
                                <input
                                    type="text"
                                    name="section"
                                    value="<?php echo isset($_POST['section']) ? htmlspecialchars($_POST['section']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stream</label>
                                <input
                                    type="text"
                                    name="stream"
                                    value="<?php echo isset($_POST['stream']) ? htmlspecialchars($_POST['stream']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Year</label>
                                <input
                                    type="text"
                                    name="year"
                                    value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input
                                    type="text"
                                    name="department"
                                    value="<?php echo isset($_POST['department']) ? htmlspecialchars($_POST['department']) : ''; ?>"
                                    class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required />
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary w-100">
                                Create Faculty
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <?php include 'footer.html'; ?>
</div>

<!-- Include Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">