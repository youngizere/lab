<?php

include "Crud.php";
include "authenticator.php";



Class User implements Crud, Authenticator{
    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;

    private $username;
    private $password;

    function __construct($first_name,$last_name,$city_name, $username, $password){
        $this->first_name= $first_name;
        $this->last_name= $last_name;
        $this->city_name= $city_name;
        $this->username = $username;
        $this->password = $password;
    }

    public static function create(){
        $instance = new self();
        return $instance;
    }
    public function setUsername($username){
        $this->username = $username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }

    public function setUserId($user_id){
        $this->user_id= $user_id;
    }
    public function getUserId(){
        return $this->$user_id;
    }
    public function save(){
        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;
        $uname = $this->username;
        $this->hashPassword();
        $pass = $this->password;
        $con = new DBConnector;
        $mysqli = $con->conn;
        $res = $mysqli -> query("INSERT INTO user(first_name, last_name, user_city, username, password) VALUES('$fn', '$ln', '$city', '$uname', '$pass')") or die("Error: ".mysqli_connect_error());
        $con->closeDatabase();
        return $res;
    }
    public function readAll(){
        $con = new DBConnector;
        $mysqli = $con->conn;
        $result = $mysqli -> query("SELECT * FROM user");
        $rowData=array();
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $rowData[]=$row;
        }
        $con->closeDatabase();
        return $rowData;
    }
    public function readUnique(){
        return null;
    }
    public function search(){
        return null;
    }
    public function update(){
        return null;
    }
    public function removeOne(){
        return null;
    }
    public function removeAll(){
        return null;
    }
    public function validateForm(){
        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;
        if($fn == "" || $ln == "" || $city ==""){

            return false;

        }
        return true;
    }
    public function createFormErrorSessions(){
        session_start();
        $_SESSION['form_errors'] = "All fields are required";
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function isPasswordCorrect(){
        $con = new DBConnector;
        $found = false;
        $res = $mysqli -> query("SELECT * FROM user") or die("Error: ".mysqli_connect_error());

        while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
            if(password_verify($this->getPassword(), $row['password']) && $this->getUsername() == $row['username']){

                $found = true;

            }
        }
        $con->closeDatabase();
        return $found;
    }
    public function login(){
        if($this->isPasswordCorrect()){

            header("Location:private_page.php");

        }
    }

    public function createUserSession(){
        session_start();
        $_SESSION['username'] = $this->getUsername();
    }

    public function logout(){
        session_start();
        unset($_SESSION['username']);
        session_destroy();
        header("Location:lab1.php");
    }
}