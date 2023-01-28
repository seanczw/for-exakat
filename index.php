<!doctype html>
<html>
<head>
<title>Search trains</title>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myform").submit(function(e) {
            $("#first").hide();
        });
    });
</script>
</head>


<body>
<p>22051107 SEAN CHENG</p>

<div>
<?php
session_start();
if (isset($_POST['Submit'])){
$capacity=$_POST['capacity'];
$usage_rate=$_POST['usage_rate'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webjti";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("SELECT * FROM train_info WHERE capacity>=:capacity AND usage_rate<:usage_rate");
    //WHERE capacity>=:capacity AND usage_rate<:usage_rate
    $stmt->bindParam(':capacity', $capacity);
    $stmt->bindParam(':usage_rate', $usage_rate);

    $results = $stmt->execute();
    if ($results){
        $rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row){
        echo 'Train ID = '. $row["train_id"].'<br>'.'Journey Code = '. $row["journey_code"]. '<br>'. 'Maximum passenger capacity = '. $row["capacity"].'<br>'.'Current usage rate = '. $row["usage_rate"].'%<br><br>';
        }
        echo '<a href="http://localhost/webjti/index.php#">Go back to search page</a>';

    } else {
        echo 'No trains found!';
        echo '<a href="http://localhost/webjti/index.php#">Go back to search page</a>';
    }
}
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;

}
?>
</div>


<form id = "myform" method="POST" action="#">
  <div id = "first">
    <label>Search trains:</label><br>
    <label for = "capacity">Maximum capacity greater than or equals :</label>
    <input type="number" id="capacity" name="capacity"><br>
    <label for = "usage_rate">Current usage rate less than :</label>
    <input type="number" id="usage_rate" name="usage_rate">%<br>
    <input type="submit" value="Submit" id = "Submit" name = "Submit">
</div>
</form> 
</body>
</html>
