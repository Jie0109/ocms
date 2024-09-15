// Hashing the user's password for secure storage
$hash = password_hash($password, PASSWORD_DEFAULT);

// SQL query to insert the new user into the database
$sql = "INSERT INTO user (email, pw, mode, uname, registrationDate) VALUES ('$email', '$hash', 'cust', '$username', '$registrationDate')";

// Executing the query and providing user feedback
if (mysqli_query($link, $sql)) {
    echo "
    <script>
    Swal.fire({
        title: 'Successful',
        text: 'New account created, please verify your email ASAP!',
        icon: 'success'
    }).then(function() {
    location.href = 'login.php'
    })</script>";
}
