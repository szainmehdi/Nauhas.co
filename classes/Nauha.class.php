<?php

/*
 * @author      S. Zain Mehdi
 * @file        Nauha.class.php
 * @project     AutoAdsToday
 * @description Nauha class definition.
*/

//require Database
require_once "Database.class.php";
require_once $cfg['root_dir'] . "includes/functions.inc.php";

//class definition
class Nauha {
    //Variable definitions for Nauha class
    public $id;                 // Nauha ID
    public $album;              // Album object
    public $nauhakhan;              // Album object
    public $title;              // Nauha Title
    public $text;               // Nauha Writeup
    public $updated;            // Last Update Timestamp
    public $audio;              // Audio Array (mp3, yt, etc.)
    public $tags;               // Last Update Timestamp;
    public $contributors;       // Last Update Timestamp
    public $hits;


    const TABLE = "nauhas";

    const ERROR_NO_WRITEUP = "<p class='err'>No writeup available for this nauha.</p>";

    const FORMAT_FEATURED = '<div class="topNauha">
        <a href="viewNauha.php?n=%(urlname)s" class="full-box-link"></a>
        <div class="nauhakhan-image" style="background-image: url(%(nauhakhan_image)s);"></div><!--
    ---><div class="nauha-heading">
            <span class="nauha-title">%(title)s</span>
            <span class="nauha-details">
                <span class="nauha-nauhakhan">%(nauhakhan)s</span> &middot;
                <span class="nauha-release-year">%(year)s</span>
            </span>
        </div><!--
    ---><div class="nauha-content">
            <div class="nauha-preview">
                %(text)s
                <div class="fade"></div>
            </div>
        </div>
    </div>';

    //Default Constructor
    function __construct($data) {

        //copy data from data array to variables.
        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->album = (isset($data['album'])) ? $data['album'] : false; //NauhaAlbum::get("id", $data['album']) : false;
        $this->nauhakhan = (isset($data['nauhakhan'])) ? Nauhakhan::get("id", $data['nauhakhan']) : false;
        $this->title = (isset($data['title'])) ? $data['title'] : "";
        $this->text = (isset($data['text'])) ? $data['text'] : false;
        $this->hits = (isset($data['hits'])) ? (int)$data['hits'] : false;
        $this->audio = (isset($data['audio'])) ? explode("|", $data['audio']) : array();
        $this->tags = (isset($data['audio'])) ? explode(",", $data['audio']) : array();
        $this->contributors = (isset($data['contributors'])) ? explode(",", $data['contributors']) : array();

        $this->updated = (isset($data['updated'])) ? strtotime($data['updated']) : 0;

    }
    public function edit($data) {
        $db = new Database();
        //copy data from data array to variables.

        $this->id = (isset($data['id'])) ? $data['id'] : $this->id ;
        $this->album = (isset($data['album'])) ? $data['album'] : $this->album; //NauhaAlbum::get("id", $data['album']) : false;
        $this->nauhakhan = (isset($data['nauhakhan'])) ? Nauhakhan::get("id", $data['nauhakhan']) : $this->nauhakhan; //NauhaAlbum::get("id", $data['album']) : false;
        $this->title = (isset($data['title'])) ? $data['title'] : $this->title;
        $this->text = (isset($data['text'])) ? $data['text'] : $this->text;
        $this->audio = (isset($data['audio'])) ? explode("|", $data['audio']) : $this->audio;
        $this->tags = (isset($data['audio'])) ? explode(",", $data['audio']) : $this->tags;
        $this->contributors = (isset($data['contributors'])) ? explode(",", $data['contributors']) : $this->contributors ;
        $this->hits = (isset($data['hits'])) ? $data['hits'] : $this->hits;

        $this->updated = time();

        //save the vehicle to the database
        return $this->save();
    }

    //update or add nauha to the nauhas table
    private function save() {
        global $cfg;

        $db = new Database();

        $exists = (strlen($this->id)==0) ? false : true;

        //set the data array
        $data = array(
            "album" => (int)$this->album,
            "nauhakhan" => (int)$this->nauhakhan->id,
            "hits" => (int)$this->hits,
            "title" => (string)$this->title,
            "text" => (string)$this->text,
            "audio" => (string)implode("|",$this->audio),
            "tags" => (string)implode(",",$this->tags),
            "contributors" => (string)implode(",",$this->contributors)
        );

        //IF THE NAUHA IS A NEW NAUHA
        if(!$exists) {
            if($db->insert(self::TABLE, $data)) {
                $this->id = $db->getInsertId();
                return $this->id;
            }
            //successfully inserted new nauha
            else {
                return false;
            }
            //Failed to insert new nauha
        }

        //IF UPDATING EXISTING NAUHA
        else {
            $db->where("id", $this->id);
            if($db->update(self::TABLE, $data)) {return true; } //successfully tags new nauha
            else { return false; } //Failed to update new nauha
        }
    }

    public function getMP3() {
        return (isset($this->audio[0])) ? $this->audio[0] : false;
    }
    public static function get($field,$value) {
        $db = new Database();
        return new Nauha($db->where($field,$value)->getOne(self::TABLE));
    }
    public static function getTracksByAlbum($album) {
        $db = new Database();
        $tracklist = array();
        foreach($db->where("album",$album)->orderBy("id","ASC")->get(self::TABLE) as $each) {
            array_push($tracklist, new Nauha($each));
        }
        return $tracklist;
    }
    public function toArray() {
        $album = NauhaAlbum::get("id", $this->album);
        return array(
            "album" => (int)$this->album,
            "hits" => (int)$this->hits,
            "title" => (string)$this->title,
            "text" => (string) (strlen($this->text)>0) ? $this->text : self::ERROR_NO_WRITEUP,
            "audio" => (string)implode("|",$this->audio),
            "tags" => (string)implode(",",$this->tags),
            "contributors" => (string)implode(",",$this->contributors),
            "nauhakhan" => (string)$this->nauhakhan->name,
            "year" => (string)$album->year_gregorian,
            "nauhakhan_image" => (string)$this->nauhakhan->getImage(),
            "writeup_available" => (strlen($this->text)>0) ? "yes" : "no",
            "urlname" => (string)urlencode($this->title) . "&id=" . $this->id
        );
    }
    public function recordHit() {
        $this->hits++;
        return $this->save();
    }
}

