<?php

/*
 * @author      S. Zain Mehdi
 * @file        User.class.php
 * @project     AutoAdsToday
 * @description User class definition.
*/

//require Database
require_once "Database.class.php";
require_once $cfg['root_dir'] . "includes/functions.inc.php";

//class definition
class User {
    //Variable definitions for User class
    public $id;                 //User ID
    public $username;           //Username
    public $fname;               //first name
    public $lname;              //last name
    private $password;          //User Password
    public $email;              //User email
    public $updated;            //Last Update Timestamp
    public $type;               //User type;

    const TABLE = "users";

    const TYPE_USER_ADMIN = 7;
    const TYPE_USER_CONTRIBUTER = 2;
    const TYPE_USER_BASIC = 1;
    const TYPE_USER_DISABLED = 0;
    const TYPE_USER_BANNED = -1;

    const FORMAT_DATETIME_MYSQL = "Y-m-d H:i:s";
    const FORMAT_DATE_MYSQL = "Y-m-d";
    const FORMAT_TIME_MYSQL = "H:i:s";


    //Default Constructor
    function __construct($data) {

        //copy data from data array to variables.
        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->username = (isset($data['username'])) ? $data['username'] : "";
        $this->password = (isset($data['password'])) ? $data['password'] : "";
        $this->fname = (isset($data['fname'])) ? $data['fname'] : "";
        $this->lname = (isset($data['lname'])) ? $data['lname'] : "";
        $this->email = (isset($data['email'])) ? $data['email'] : "";
        $this->updated = (isset($data['updated'])) ? strtotime($data['updated']) : false;
        $this->type = (isset($data['type'])) ? $data['type'] : self::TYPE_USER_BASIC;

    }
    public function edit($data) {
        $db = new Database();
        //copy data from data array to variables.

        if(isset($data['password']) && $data['password']!="") {

            $user = (isset($data['fname']))             ? $data['fname']            : $this->fname;
            $user = strip_tags(substr($user,0,32));
            $plain_pw = strip_tags(substr($data['password'],0,32));
            $password = crypt(md5($plain_pw),md5($user));
        }

        $this->username = (isset($data['username'])) ? $data['username'] : $this->username;
        $this->password = (isset($data['password'])) ? $password : $this->password;
        $this->fname = (isset($data['fname'])) ? $data['fname'] : $this->fname;
        $this->lname = (isset($data['lname'])) ? $data['lname'] : $this->lname;
        $this->email = (isset($data['email'])) ? $data['email'] : $this->email;
        $this->type = (isset($data['type'])) ? $data['type'] : $this->type;
        $this->updated = time();

        //save the vehicle to the database
        return $this->save();
    }

    //update or add user to the users table
    private function save() {
        global $cfg;

        $db = new Database();

        $exists = (strlen($this->id)==0) ? false : true;

        //set the data array
        $data = array(
            "username" => $this->username,
            "password" => $this->password,
            "email" => $this->email,
            "fname" => $this->fname,
            "lname" => $this->lname,
            "type" => $this->type,
            "updated" => date(self::FORMAT_DATETIME_MYSQL,$this->updated)
        );

        //IF THE USER IS A NEW USER
        if(!$exists) {
            if($db->insert(self::TABLE, $data)) {
                $this->id = $db->getInsertId();
                return $this->id;
            }
            //successfully inserted new user
            else {
                return false;
            }
            //Failed to insert new user
        }

        //IF UPDATING EXISTING USER
        else {
            $db->where("id", $this->id);
            if($db->update(self::TABLE, $data)) {return true; } //successfully updated new user
            else { return false; } //Failed to update new user
        }
    }

    public function login($pw) {
        if($pw==$this->password) {
            return true;
        }
        else {
            return false;
        }
    }
    private function _prepareDatabase() {
        //create and insert all the necessary data

    }
    public static function getUser($field,$value) {
        $db = new Database();
        return new User($db->where($field,$value)->getOne(self::TABLE));
    }
}
