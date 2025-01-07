<?php

function uidExists($conn, $uid)
{
    $sql = "SELECT * FROM users WHERE usersUid = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData))
    {
        return $row;
    }
    else
    {
        $result = FALSE;
        return $result;
    }
}

function emptyInputLogin($uid, $password)
{
    $result = NULL;
    if(empty($uid) || empty($password))
    {
        $result = TRUE;
    }
    else
    {
        $result = FALSE;
    }

    return $result;
}

function loginUser($conn, $id, $password)
{
    $uidExists = uidExists($conn, $id);

    if($uidExists == FALSE)
    {
        header("location: ../index.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $uidExists["usersPassword"];
    $checkPassword = password_verify($password, $passwordHashed);

    if(/*$checkPassword == FALSE*/ /*$passwordHashed != $password*/ true==false)
    {
        header("location: ../index.php?error=wronglogin");
        exit();
    }
    else
    {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];

        header("location: ../dashboard.php?content=accueil");
        exit();
    }
}

function checkAdmin($conn,$id)
{
    $request = "Select ID_metier from employe where login_employe=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $request)) {
        die('SQL error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        if ($row['ID_metier'] == '1') {
            return true;
        }
    }
    return false;
}