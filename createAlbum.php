<?php
require_once($cfg['root_dir'] . "includes/global.inc.php");


//handle post data

if(isset($_POST['create-album'])) {
    var_dump($_POST);
    var_dump($_FILES);

    $nauhakhan = Nauhakhan::get("id", $_POST['nauhakhan']);

    $artworkFileName = "album_" . strtolower(str_replace(" ","-",$nauhakhan->name) . "_" . $_POST['year_hijri']);
    $artwork = "";

    if($_FILES['artwork']['name']) {
        list($file,$error) = upload('artwork', 'img/uploads/', $artworkFileName, 'jpeg,jpg,png');
        if($error) echo $error;
        $artwork = $file;
    }
    $albumData = array(
        "title" => $_POST['title'],
        "nauhakhan" => (int)$_POST['nauhakhan'],
        "releaseDate" => $_POST['releaseDate'],
        "year_hijri" => (int)$_POST['year_hijri'],
        "year_gregorian" => (int)$_POST['year_gregorian'],
        "notes" => $_POST['notes'],
        "artwork" => $artwork,
    );
    echo "<h2>Album Data</h2>";
    var_dump($albumData);
    $album = new NauhaAlbum(array());
    $album->edit($albumData);

    /* NAUHA CREATION */
    echo "<h2>Nauha Data</h2>";

    foreach($_POST['nauha'] as $key=>$nauha) {
        if($nauha['title']) {

            var_dump($key);
            var_dump($nauha);

            $audioFileName = strtolower(str_replace(' ', '-',$nauha['title'])) . "_" .
                strtolower(str_replace(" ","-",$album->nauhakhan->name));
            $audio = "";
            $path = "audio/" . strtolower(str_replace(" ","_",$album->nauhakhan->name)) . "/" . $album->year_hijri . "/";

            if($_FILES['nauha']['name'][$key]) {
                list($file,$error) = uploadFromArray('nauha', $path, $audioFileName, 'mp3', $key);
                if($error) echo $error;
                $audio = $file;
            }

            $nauhaData = array(
                "album" => (int)$album->id,
                "nauhakhan" => (int)$album->nauhakhan->id,
                "title" => $nauha['title'],
                "text" => $nauha['text'],
                "audio" => $audio,
                "tags" => $nauha['tags']
            );
            var_dump($nauhaData);

            $nauha = new Nauha(array());
            if($nauha->edit($nauhaData) >0 ) {
                echo "Nauha created successfully.";
            }


            echo "<hr />";

        }

    }

}
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8" />
        <style type="text/css">
            label {
                width: 150px;
                display: inline-block;
                vertical-align: top;;
            }
            body {
                line-height: 2.0em;
                padding: 10px 40px;
            }
            li {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <h1>Create an Album</h1>
        <form action="createAlbum.php" method="post" enctype="multipart/form-data">
            <label for="nauhakhan">Nauhakhan: </label>
            <select id="nauhakhan" name="nauhakhan">
                <option value="0"> - Select One -</option>
                <?php

                foreach($db->get(Nauhakhan::TABLE, "id,name") as $each) {
                    echo "<option value='$each[id]'>$each[name]</option>";
                }

                ?>
            </select><br />
            <label for="title">Title: </label><input type="text" id="title" name="title" /><br />
            <label for="releaseDate">Release Date: </label><input type="date" id="releaseDate" name="releaseDate" /><br />
            <label for="year_hijri">Year (Hijri): </label><input type="text" id="year_hijri" name="year_hijri" /><br />
            <label for="year_gregorian">Year (Gregorian): </label><input type="text" id="year_gregorian" name="year_gregorian" /><br />
            <label for="artwork">Album Cover: </label><input type="file" id="artwork" name="artwork" /><br />
            <label for="notes">Notes: </label><textarea id="notes" name="notes"></textarea><br />

            <h2>Track List</h2>
            <ol>
                <li>
                    <label for="nauha[0][title]">Title: </label><input type="text" id="nauha[0][title]" name="nauha[0][title]" /><br />
                    <label for="nauha[0][tags]">Tags: </label><textarea id="nauha[0][tags]" name="nauha[0][tags]"></textarea><br />
                    <label for="nauha[0][text]">Text: </label><textarea id="nauha[0][text]" name="nauha[0][text]"></textarea><br />
                    <label for="nauha[0]">Audio (MP3): </label><input type="file" id="nauha[0]" name="nauha[0]" />
                </li>
                <li>
                    <label for="nauha[1][title]">Title: </label><input type="text" id="nauha[1][title]" name="nauha[1][title]" /><br />
                    <label for="nauha[1][tags]">Tags: </label><textarea id="nauha[1][tags]" name="nauha[1][tags]"></textarea><br />
                    <label for="nauha[1][text]">Text: </label><textarea id="nauha[1][text]" name="nauha[1][text]"></textarea><br />
                    <label for="nauha[1]">Audio (MP3): </label><input type="file" id="nauha[1]" name="nauha[1]" />
                </li>
                <li>
                    <label for="nauha[2][title]">Title: </label><input type="text" id="nauha[2][title]" name="nauha[2][title]" /><br />
                    <label for="nauha[2][tags]">Tags: </label><textarea id="nauha[2][tags]" name="nauha[2][tags]"></textarea><br />
                    <label for="nauha[2][text]">Text: </label><textarea id="nauha[2][text]" name="nauha[2][text]"></textarea><br />
                    <label for="nauha[2]">Audio (MP3): </label><input type="file" id="nauha[2]" name="nauha[2]" />
                </li>
                <li>
                    <label for="nauha[3][title]">Title: </label><input type="text" id="nauha[3][title]" name="nauha[3][title]" /><br />
                    <label for="nauha[3][tags]">Tags: </label><textarea id="nauha[3][tags]" name="nauha[3][tags]"></textarea><br />
                    <label for="nauha[3][text]">Text: </label><textarea id="nauha[3][text]" name="nauha[3][text]"></textarea><br />
                    <label for="nauha[3]">Audio (MP3): </label><input type="file" id="nauha[3]" name="nauha[3]" />
                </li>
                <li>
                    <label for="nauha[4][title]">Title: </label><input type="text" id="nauha[4][title]" name="nauha[4][title]" /><br />
                    <label for="nauha[4][tags]">Tags: </label><textarea id="nauha[4][tags]" name="nauha[4][tags]"></textarea><br />
                    <label for="nauha[4][text]">Text: </label><textarea id="nauha[4][text]" name="nauha[4][text]"></textarea><br />
                    <label for="nauha[4]">Audio (MP3): </label><input type="file" id="nauha[4]" name="nauha[4]" />
                </li>
                <li>
                    <label for="nauha[5][title]">Title: </label><input type="text" id="nauha[5][title]" name="nauha[5][title]" /><br />
                    <label for="nauha[5][tags]">Tags: </label><textarea id="nauha[5][tags]" name="nauha[5][tags]"></textarea><br />
                    <label for="nauha[5][text]">Text: </label><textarea id="nauha[5][text]" name="nauha[5][text]"></textarea><br />
                    <label for="nauha[5]">Audio (MP3): </label><input type="file" id="nauha[5]" name="nauha[5]" />
                </li>
                <li>
                    <label for="nauha[6][title]">Title: </label><input type="text" id="nauha[6][title]" name="nauha[6][title]" /><br />
                    <label for="nauha[6][tags]">Tags: </label><textarea id="nauha[6][tags]" name="nauha[6][tags]"></textarea><br />
                    <label for="nauha[6][text]">Text: </label><textarea id="nauha[6][text]" name="nauha[6][text]"></textarea><br />
                    <label for="nauha[6]">Audio (MP3): </label><input type="file" id="nauha[6]" name="nauha[6]" />
                </li>
                <li>
                    <label for="nauha[7][title]">Title: </label><input type="text" id="nauha[7][title]" name="nauha[7][title]" /><br />
                    <label for="nauha[7][tags]">Tags: </label><textarea id="nauha[7][tags]" name="nauha[7][tags]"></textarea><br />
                    <label for="nauha[7][text]">Text: </label><textarea id="nauha[7][text]" name="nauha[7][text]"></textarea><br />
                    <label for="nauha[7]">Audio (MP3): </label><input type="file" id="nauha[7]" name="nauha[7]" />
                </li>
                <li>
                    <label for="nauha[8][title]">Title: </label><input type="text" id="nauha[8][title]" name="nauha[8][title]" /><br />
                    <label for="nauha[8][tags]">Tags: </label><textarea id="nauha[8][tags]" name="nauha[8][tags]"></textarea><br />
                    <label for="nauha[8][text]">Text: </label><textarea id="nauha[8][text]" name="nauha[8][text]"></textarea><br />
                    <label for="nauha[8]">Audio (MP3): </label><input type="file" id="nauha[8]" name="nauha[8]" />
                </li>
                <li>
                    <label for="nauha[9][title]">Title: </label><input type="text" id="nauha[9][title]" name="nauha[9][title]" /><br />
                    <label for="nauha[9][tags]">Tags: </label><textarea id="nauha[9][tags]" name="nauha[9][tags]"></textarea><br />
                    <label for="nauha[9][text]">Text: </label><textarea id="nauha[9][text]" name="nauha[9][text]"></textarea><br />
                    <label for="nauha[9]">Audio (MP3): </label><input type="file" id="nauha[9]" name="nauha[9]" />
                </li>
                <li>
                    <label for="nauha[10][title]">Title: </label><input type="text" id="nauha[10][title]" name="nauha[10][title]" /><br />
                    <label for="nauha[10][tags]">Tags: </label><textarea id="nauha[10][tags]" name="nauha[10][tags]"></textarea><br />
                    <label for="nauha[10][text]">Text: </label><textarea id="nauha[10][text]" name="nauha[10][text]"></textarea><br />
                    <label for="nauha[10]">Audio (MP3): </label><input type="file" id="nauha[10]" name="nauha[10]" />
                </li>
                <li>
                    <label for="nauha[11][title]">Title: </label><input type="text" id="nauha[11][title]" name="nauha[11][title]" /><br />
                    <label for="nauha[11][tags]">Tags: </label><textarea id="nauha[11][tags]" name="nauha[11][tags]"></textarea><br />
                    <label for="nauha[11][text]">Text: </label><textarea id="nauha[11][text]" name="nauha[11][text]"></textarea><br />
                    <label for="nauha[11]">Audio (MP3): </label><input type="file" id="nauha[11]" name="nauha[11]" />
                </li>
                <li>
                    <label for="nauha[12][title]">Title: </label><input type="text" id="nauha[12][title]" name="nauha[12][title]" /><br />
                    <label for="nauha[12][tags]">Tags: </label><textarea id="nauha[12][tags]" name="nauha[12][tags]"></textarea><br />
                    <label for="nauha[12][text]">Text: </label><textarea id="nauha[12][text]" name="nauha[12][text]"></textarea><br />
                    <label for="nauha[12]">Audio (MP3): </label><input type="file" id="nauha[12]" name="nauha[12]" />
                </li>
                <li>
                    <label for="nauha[13][title]">Title: </label><input type="text" id="nauha[13][title]" name="nauha[13][title]" /><br />
                    <label for="nauha[13][tags]">Tags: </label><textarea id="nauha[13][tags]" name="nauha[13][tags]"></textarea><br />
                    <label for="nauha[13][text]">Text: </label><textarea id="nauha[13][text]" name="nauha[13][text]"></textarea><br />
                    <label for="nauha[13]">Audio (MP3): </label><input type="file" id="nauha[13]" name="nauha[13]" />
                </li>
                <li>
                    <label for="nauha[14][title]">Title: </label><input type="text" id="nauha[14][title]" name="nauha[14][title]" /><br />
                    <label for="nauha[14][tags]">Tags: </label><textarea id="nauha[14][tags]" name="nauha[14][tags]"></textarea><br />
                    <label for="nauha[14][text]">Text: </label><textarea id="nauha[14][text]" name="nauha[14][text]"></textarea><br />
                    <label for="nauha[14]">Audio (MP3): </label><input type="file" id="nauha[14]" name="nauha[14]" />
                </li>

                <input type="submit" name="create-album" value="Create Album" />
            </ol>

        </form>
    </body>
</html>