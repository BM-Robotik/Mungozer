<!DOCTYPE HTML>
<html>

<head>
    <title>Mungozer</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <?php
        readfile1:
        $myfile = fopen("data.txt", "r") or die("Unable to open file!");
        $str = "";
        if (filesize("data.txt") === 0) {
            fclose($myfile);
            $tm = time();
            while (time() - $tm > 3) {
            }
            echo "aq";
            goto readfile1;
        } else {
            $str = fread($myfile, filesize("data.txt"));

            fclose($myfile);

            $filearr = explode("\n", $str);

            #print_r($filearr);

            #echo "<br>";

            if (count($filearr)) {
                $i = 1;
                foreach ($filearr as $nf) {
                    $element = "<input type='checkbox' id='checkbox" . $i . "' name='checkbox[]' value='" . $nf . "'><label for='checkbox" . $i . "'>" . $nf . "</label><br>";
                    echo $element;
                    $i = $i + 1;
                }
            }
        }

        ?>

        <button type="reset">Clear Checkboxes</button>

        <input type="submit" value="Submit" name="submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $chkindex = 1;
        if(!empty($_POST['checkbox'])) {

            foreach($_POST['checkbox'] as $value){
                echo "Chosen checkbox : ".$value.'<br/>';
            }
    
        }
    }
    ?>

</body>

</html>