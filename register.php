<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

// DATA FORM REQUEST

$data=$_POST;
$data=json_encode($data);
$data=json_decode($data);
//$data = json_decode(file_get_contents("php://input"));
$returnData = [];

if ($_SERVER["REQUEST_METHOD"] != "POST") :

    $returnData = msg(0, 404, 'Page Not Found!');

elseif (
    !isset($data->fname)
    || !isset($data->fname)
    || !isset($data->lname)
    || !isset($data->password)
    || !isset($data->role)
    || empty(trim($data->fname))
    || empty(trim($data->lname))
    || empty(trim($data->email))
    || empty(trim($data->password))
    || empty(trim($data->role))
) :

    $fields = ['fields' => ['fname','lname', 'email', 'password', 'role']];
    $returnData = msg(0, 422, 'Please Fill in all Required Fields!', $fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else :

    $fname = trim($data->fname);
    $lname = trim($data->lname);
    $email = trim($data->email);
    $password = trim($data->password);
    $role = trim($data->role);

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $returnData = msg(0, 422, 'Invalid Email Address!');

    elseif (strlen($password) < 8) :
        $returnData = msg(0, 422, 'Your password must be at least 8 characters long!');

    elseif (strlen($fname) < 3) :
        $returnData = msg(0, 422, 'Your name must be at least 3 characters long!');

    elseif (strlen($lname) < 3) :
        $returnData = msg(0, 422, 'Your name must be at least 3 characters long!');
    
    elseif ($role!="admin" && $role!="client") :
        $returnData = msg(0, 422, 'Your role must be admin or client!');
    

    else :
        try {

            $check_email = "SELECT `email` FROM `users` WHERE `email`=:email";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $check_email_stmt->execute();

            if ($check_email_stmt->rowCount()) :
                $returnData = msg(0, 422, 'This E-mail already in use!');

            else :
                $insert_query = "INSERT INTO `users`(`fname`,`lname`,`email`,`password`,`role`) VALUES(:fname,:lname,:email,:password, :role)";

                $insert_stmt = $conn->prepare($insert_query);

                // DATA BINDING
                $insert_stmt->bindValue(':fname', htmlspecialchars(strip_tags($fname)), PDO::PARAM_STR);
                $insert_stmt->bindValue(':lname', htmlspecialchars(strip_tags($lname)), PDO::PARAM_STR);
                $insert_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                $insert_stmt->bindValue(':role', htmlspecialchars(strip_tags($role)), PDO::PARAM_STR);

                $insert_stmt->execute();

                $returnData = msg(1, 201, 'You have successfully registered.');

            endif;
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }
    endif;
endif;

echo json_encode($returnData);