<!DOCTYPE HTML>
<html>

<head>
    <title>Mungozer</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <?php
    $myfile = fopen("data.txt", "r") or die("Unable to open file!");
    $str = "";
    if (filesize("data.txt") === 0) {
        fclose($myfile);
    } else {
        $str = fread($myfile, filesize("data.txt"));

        fclose($myfile);

        $filearr = explode("\n", $str);

        print_r($filearr);

        echo "<br>";

        if (count($filearr)) {
            $i = 1;
            foreach ($filearr as $nf) {
                $element = "<input type='checkbox' id='checkbox" . $i . "' name='checkbox" . $i . "' value='" . $nf . "'><label for='checkbox" . $i . "'>" . $nf . "</label><br>";
                echo $element;
            }
        }
    }

    ?>
</body>

</html>