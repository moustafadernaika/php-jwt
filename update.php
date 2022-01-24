<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/classes/Database.php';
require __DIR__.'/AuthMiddleware.php';

$allHeaders = getallheaders();
$db_connection = new Database();
$conn = $db_connection->dbConnection();
$auth = new Auth($conn, $allHeaders);

 //echo json_encode($auth->isValid());
$data=$auth->isValid();
print_r($data);
exit;
$mainrole=$data['user']['role'];
$mainid=$data['user']['id'];
if($data['success'])
{

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

// DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
$returnData = [];

if ($_SERVER["REQUEST_METHOD"] != "PUT") :

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

            $check_email = "SELECT `email` FROM `users` WHERE `email`=:email AND `id`!=:id";
            $check_email_stmt = $conn->prepare($check_email);
            $check_email_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $check_email_stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
            $check_email_stmt->execute();

            if ($check_email_stmt->rowCount()) :
                $returnData = msg(0, 422, 'This E-mail already in use!');

            else :
                $update_query = "UPDATE `users` SET `fname`=:fname,`lname`=:lname,`email`=:email,`password`=:password, `role`=:role WHERE `id`=:id";

                $update_stmt = $conn->prepare($update_query);

                // DATA BINDING
                $update_stmt->bindValue(':fname', htmlspecialchars(strip_tags($fname)), PDO::PARAM_STR);
                $update_stmt->bindValue(':lname', htmlspecialchars(strip_tags($lname)), PDO::PARAM_STR);
                $update_stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $update_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                $update_stmt->bindValue(':role', htmlspecialchars(strip_tags($role)), PDO::PARAM_STR);
                $update_stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
                if($mainid!=$_GET['id'] && $mainrole=="client")
                $returnData = msg(0, 422, 'you are not allowed !');
                else
                {
                $update_stmt->execute();

                $returnData = msg(1, 201, 'You have successfully updated.');
                }

            endif;
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }
    endif;
endif;

echo json_encode($returnData);
}