<?php 
// echo 'hello world';

$dbconfig = parse_ini_file(".env");

$host = $dbconfig["DB_HOST"];
$username = $dbconfig["DB_USER"];
$password = $dbconfig["DB_PASS"];
$dbname = $dbconfig["DB_NAME"];

// INSERT FOR subsribers

if (isset($_POST["fullname"]) && isset($_POST["email"]) && isset($_POST["agreement"]))
{
    $conn = mysqli_connect($host, $username, $password, $dbname); 
    if (!$conn)
    {
        echo 'exception';
    }
    else echo "success_2";

    $fullname = $conn->real_escape_string($_POST["fullname"]);
    $email = $conn->real_escape_string($_POST["email"]);
    if ($_POST['agreement'] == '1')
    {
        $agreement = true;
    }
    else $agreement = false;

    $insertQuery = mysqli_query($conn, "INSERT INTO subscribers (full_name, email, agreement) 
            VALUES ('$fullname', '$email', '$agreement');");
    
    if (!mysqli_query($conn, $insertQuery)) 
    {
        echo "Success!";
    }
    else 
    {
        echo "Error";
    }

    mysqli_close($link);
}

// INSERT FOR news

if (isset($_POST["headline"]) && isset($_POST["text"]) && isset($_POST["date"]))
{
    $conn = mysqli_connect($host, $username, $password, $dbname); 
    if (!$conn)
    {
        echo 'exception';
    }
    else echo "success_1";

    $headline = $conn->real_escape_string($_POST["headline"]);
    $text = $conn->real_escape_string($_POST["text"]);
    $date = strtotime($_POST["date"]);
    $date = date('Y-m-d H:i:s', $date);

    $insertQuery = mysqli_query($conn, "INSERT INTO news (headline, text, date) 
            VALUES ('$headline', '$text', '$date');");
    
    if (!mysqli_query($conn, $insertQuery)) 
    {
        echo "Success!";
    }
    else 
    {
        echo "Error";
    }

    mysqli_close($link);
}

// SEND EMAIL

?>