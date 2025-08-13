<?php
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_name   = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $clinic_name   = $_POST['clinic_name'];
    $address       = $_POST['address'];
    $city          = $_POST['city'];
    $pincode       = $_POST['pincode'];
    $mobile_number = $_POST['mobile_number'];
    $email_id      = $_POST['email_id'];

    $stmt = $conn->prepare("INSERT INTO doctors 
        (doctor_name, specialization, clinic_name, address, city, pincode, mobile_number, email_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $doctor_name, $specialization, $clinic_name, $address, $city, $pincode, $mobile_number, $email_id);

    if ($stmt->execute()) {
        $success_message = "Doctor record added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Hospital Doctor Records</h2>

    <?php if (!empty($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } elseif (!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <div class="card p-4 mb-5 shadow-sm">
        <h4 class="mb-3">Add Doctor</h4>
        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Doctor Name</label>
                <input type="text" name="doctor_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Clinic Name</label>
                <input type="text" name="clinic_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Pincode</label>
                <input type="text" name="pincode" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Email ID</label>
                <input type="email" name="email_id" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Add Doctor</button>
            </div>
        </form>
    </div>

    <h4 class="mb-3">Currently Working Doctors</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Clinic</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Pincode</th>
                    <th>Mobile</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM doctors ORDER BY doctor_id DESC");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['doctor_id']}</td>
                                <td>{$row['doctor_name']}</td>
                                <td>{$row['specialization']}</td>
                                <td>{$row['clinic_name']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['city']}</td>
                                <td>{$row['pincode']}</td>
                                <td>{$row['mobile_number']}</td>
                                <td>{$row['email_id']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No doctors found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
