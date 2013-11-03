<?php

/*
 * @author      S. Zain Mehdi
 * @file        Album.class.php
 * @project     AutoAdsToday
 * @description Album class definition.
*/

//require Database
require_once "Database.class.php";
require_once $cfg['root_dir'] . "includes/functions.inc.php";

//class definition
class NauhaAlbum {
    //Variable definitions for Album class
    public $id;                 //Album ID
    public $nauhakhan;           //Nauhakhan object
    public $title;               //first name
    public $releaseDate;              //last name
    public $year_hijri;              //Album links
    public $year_gregorian;            //Last Update Timestamp
    public $tracklist;            //array of Nauha objects
    public $artwork;            //Last Update Timestamp
    public $notes;
    public $created;

    const TABLE = "albums";

    const FORMAT_FULL = '
    <div class="album_wrap">
        <div class="album_artwork" style="background-image: url(%(artwork)s)"></div><!--
    ---><div class="album_content">
            <div class="album_heading">
                <h3><strong>%(year_gregorian)s</strong>%(title)s</h3>
                <span>Released on %(releaseDate)s &middot; Muharram %(year_hijri)s A.H.</span>
            </div>
            <div class="album_tracklist">
                %(tracks)s
            </div>
        </div>
    </div>';

    const FORMAT_FULL_TRACKLIST = '
    <a class="album_track" href="viewNauha.php?n=%(urlname)s">
        <span class="track_number">%(num)s</span>
        <span class="track_name">%(title)s</span>
    </a>';

    //Default Constructor
    function __construct($data) {

        //copy data from data array to variables.
        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->nauhakhan = (isset($data['nauhakhan'])) ? Nauhakhan::get("id", $data['nauhakhan']) : false;
        $this->title = (isset($data['title'])) ? $data['title'] : "";
        $this->releaseDate = (isset($data['releaseDate'])) ? strtotime($data['releaseDate']) : false;
        $this->year_hijri = (isset($data['year_hijri'])) ? $data['year_hijri'] : false;
        $this->year_gregorian = (isset($data['year_gregorian'])) ? $data['year_gregorian'] : false;
        $this->artwork = (isset($data['artwork'])) ? $data['artwork'] : false;
        $this->notes = (isset($data['notes'])) ? $data['notes'] : false;


        $this->tracklist = (isset($data['id'])) ? Nauha::getTracksByAlbum($this->id) : false;

        $this->created = (isset($data['created'])) ? strtotime($data['created']) : 0;

    }
    public function edit($data) {
        $db = new Database();
        //copy data from data array to variables.

        //copy data from data array to variables.
        $this->id = (isset($data['id'])) ? $data['id'] : $this->id;
        $this->nauhakhan = (isset($data['nauhakhan'])) ? Nauhakhan::get("id", $data['nauhakhan']) : $this->nauhakhan;
        $this->title = (isset($data['title'])) ? $data['title'] : $this->title;
        $this->releaseDate = (isset($data['releaseDate'])) ? strtotime($data['releaseDate']) : $this->releaseDate;
        $this->year_hijri = (isset($data['year_hijri'])) ? $data['year_hijri'] : $this->year_hijri;
        $this->year_gregorian = (isset($data['year_gregorian'])) ? $data['year_gregorian'] : $this->year_gregorian;
        $this->artwork = (isset($data['artwork'])) ? $data['artwork'] : $this->artwork;

        //save the vehicle to the database
        return $this->save();
    }

    //update or add album to the albums table
    private function save() {
        global $cfg;

        $db = new Database();

        $exists = (strlen($this->id)==0) ? false : true;

        //set the data array
        $data = array(
            "title" => (string)$this->title,
            "nauhakhan" => (int)$this->nauhakhan->id,
            "releaseDate" => (string)date("Y-m-d",$this->releaseDate),
            "year_hijri" => (int)$this->year_hijri,
            "year_gregorian" => (int)$this->year_gregorian,
            "artwork" => (string)$this->artwork,
            "notes" => (string)$this->notes,
        );

        //IF THE ALBUM IS A NEW ALBUM
        if(!$exists) {
            if($db->insert(self::TABLE, $data)) {
                $this->id = $db->getInsertId();
                return $this->id;
            }
            //successfully inserted new album
            else {
                return false;
            }
            //Failed to insert new album
        }

        //IF UPDATING EXISTING ALBUM
        else {
            $db->where("id", $this->id);
            if($db->update(self::TABLE, $data)) {return true; } //successfully tags new album
            else { return false; } //Failed to update new album
        }
    }
    private function _prepareDatabase() {
        //create and insert all the necessary data

    }
    public static function get($field,$value) {
        $db = new Database();
        return new NauhaAlbum($db->where($field,$value)->getOne(self::TABLE));
    }
    public function formatTracklist($format) {
        $output = "";
        switch($format) {
            case self::FORMAT_FULL_TRACKLIST:
                $count = 1;
                foreach($this->tracklist as $each) {
                    $args = $each->toArray();
                    $args['num'] = $count;
                    $output .= dsprintf(self::FORMAT_FULL_TRACKLIST, $args);
                    $count++;
                }
                break;
        }
        return $output;
    }
    public function toArray() {
        return array(
            "title" => (string)$this->title,
            "nauhakhan" => (int)$this->nauhakhan->id,
            "releaseDate" => (int)$this->releaseDate,
            "year_hijri" => (int)$this->year_hijri,
            "year_gregorian" => (int)$this->year_gregorian,
            "artwork" => (string)$this->artwork,
            "notes" => (string)$this->notes,
        );
    }
}

