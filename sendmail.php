<?php 

$dbconfig = parse_ini_file(".env");

$host = $dbconfig["DB_HOST"];
$username = $dbconfig["DB_USER"];
$password = $dbconfig["DB_PASS"];
$dbname = $dbconfig["DB_NAME"];

$conn = mysqli_connect($host, $username, $password, $dbname); 
if (!$conn)
{
    echo 'exception';
}
else echo "success_3";

$curentDate = date('Y-m-d');

$templates = [];
$templates[0] = file_get_contents("mail.html");

$rowsCount = 0;

$sql = "SELECT * FROM news WHERE date >= $curentDate";
if ($result = $conn->query($sql))
{
    $rowsCount = $result->num_rows;
    $i = 0;
    foreach ($result as $row)
    {
        $templates[$i] = str_replace('{{ headline }}', $row["headline"], $templates[$i]);
        $templates[$i] = str_replace('{{ text }}', $row["text"], $templates[$i]);
        $templates[$i] = str_replace('{{ date }}', $row["date"], $templates[$i]);

        // $headline = $row["headline"];
        // $text = $row["text"];
        // $date = $row["date"];

        $i++;
    }
}

$sqlusers = "SELECT email FROM subscribers WHERE agreement = true";
if ($result = $conn->query($sqlusers))
{
    $rowsCount = $result->num_rows;
    foreach ($result as $row)
    {
        $to = $row["email"];
        $subject = "Ежедневная рассылка новостей";
        
        foreach ($templates as $template)
        {
            $message = $template;
            mail($to, $subject, $message);
        }
    }
}

?>