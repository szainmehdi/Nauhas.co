<?php

/*
 * @author      S. Zain Mehdi
 * @file        Nauhakhan.class.php
 * @project     AutoAdsToday
 * @description Nauhakhan class definition.
*/

//require Database
require_once "Database.class.php";
require_once $cfg['root_dir'] . "includes/functions.inc.php";

//class definition
class Nauhakhan {
    //Variable definitions for Nauhakhan class
    public $id;                 //Nauhakhan ID
    public $name;           //name
    public $description;               //first name
    public $images;              //last name
    public $links;              //Nauhakhan links
    public $tags;            //Last Update Timestamp

    const TABLE = "nauhakhans";
    const FORMAT_TOPNAUHAKHANS = '
    <div class="nauhakhan featured">
        <a href="viewNauhakhan.php?n=%(urlname)s" class="full-box-link"></a>
        <div class="nauhakhan-image" style="background-image: url(%(image)s);">
            <div class="nauhakhan-image-overlay"></div>
        </div>
        <div class="nauhakhan-content">
            <span class="nauhakhan-name">%(name)s</span>
            <div class="nauhakhan-description-preview">
                %(description)s
                <div class="fade"></div>
            </div>
        </div>
    </div>';

    const FORMAT_SMALL_CARD = '
    <div class="nauhakhan small">
        <a href="viewNauhakhan.php?n=%(urlname)s" class="full-box-link"></a>
        <div class="nauhakhan-image" style="background-image: url(%(image)s);">
            <div class="nauhakhan-image-overlay"></div>
        </div><!---
    ---><div class="nauhakhan-content">
            <span class="nauhakhan-name">%(name)s</span>
        </div>
    </div>';

    //Default Constructor
    function __construct($data) {

        //copy data from data array to variables.
        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->name = (isset($data['name'])) ? $data['name'] : "";
        $this->description = (isset($data['description'])) ? $data['description'] : "";
        $this->images = (isset($data['images'])) ? explode("|", $data['images']) : array();
        $this->links = (isset($data['links'])) ? explode("|", $data['links']) : array();
        $this->tags = (isset($data['tags'])) ? explode(",", $data['tags']) : array();

    }
    public function edit($data) {
        $db = new Database();
        //copy data from data array to variables.

        $this->name = (isset($data['name'])) ? $data['name'] : $this->name;
        $this->description = (isset($data['description'])) ? $data['description'] : $this->description;
        $this->images = (isset($data['images'])) ? explode("|", $data['images']) : $this->images;
        $this->links = (isset($data['links'])) ? explode("|", $data['links']) : $this->links;
        $this->tags = (isset($data['tags'])) ? explode(",", $data['tags']) : $this->tags;

        //save the vehicle to the database
        return $this->save();
    }

    //update or add nauhakhan to the nauhakhans table
    private function save() {
        global $cfg;

        $db = new Database();

        $exists = (strlen($this->id)==0) ? false : true;

        //set the data array
        $data = array(
            "name" => $this->name,
            "description" => $this->description,
            "links" => implode("|",$this->links),
            "images" => implode("|",$this->images),
            "tags" => implode(",",$this->tags)
        );

        //IF THE NAUHAKHAN IS A NEW NAUHAKHAN
        if(!$exists) {
            if($db->insert(self::TABLE, $data)) {
                $this->id = $db->getInsertId();
                return $this->id;
            }
            //successfully inserted new nauhakhan
            else {
                return false;
            }
            //Failed to insert new nauhakhan
        }

        //IF UPDATING EXISTING NAUHAKHAN
        else {
            $db->where("id", $this->id);
            if($db->update(self::TABLE, $data)) {return true; } //successfully tags new nauhakhan
            else { return false; } //Failed to update new nauhakhan
        }
    }
    private function _prepareDatabase() {
        //create and insert all the necessary data

    }
    public static function get($field,$value) {
        $db = new Database();
        return new Nauhakhan($db->where($field,$value)->getOne(self::TABLE));
    }

    public function getImage() {
        return (isset($this->images[0])) ? $this->images[0] : false;
    }
    public function getFirstName() {
        $name = explode(" ", $this->name);
        return (isset($name[0])) ? $name[0] : false;
    }
    public function getLastName() {
        $name = explode(" ", $this->name);
        $count = count($name);
        return ($count>0) ? $name[$count-1] : false;
    }
    public function getUrlName() {
        return urlencode($this->name);
    }
    public function countNauhas() {
        $db = new Database();
        return count($db->where("nauhakhan",$this->id)->get(Nauha::TABLE));
    }
    public function countAlbums() {
        $db = new Database();
        return count($db->where("nauhakhan",$this->id)->get(NauhaAlbum::TABLE));
    }

    public function toArray() {
        return array(
            "name" => $this->name,
            "description" => $this->description,
            "links" => $this->links,
            "images" => $this->images,
            "tags" => $this->tags,
            "image" => $this->getImage(),
            "fname" => $this->getFirstName(),
            "lname" => $this->getLastName(),
            "urlname" => $this->getUrlName()
        );
    }
}
