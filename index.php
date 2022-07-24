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
        } else {
            $str = fread($myfile, filesize("data.txt"));

            fclose($myfile);

            $tmpfilearr = explode("\n", $str);

            $filearr = [];

            foreach ($tmpfilearr as $fd) {
                if (strpos($fd, "||1") !== false) {
                    break;
                } else {
                    $filearr[] = $fd;
                }
            }

            #print_r($filearr);

            #echo "<br>";

            if (count($filearr)) {
                $i = 1;
                foreach ($filearr as $nf) {
                    $tvar = "";
                    if (isset($_POST['submit']) and !empty($_POST['checkbox'])) {
                        if (in_array($nf . "\n", $_POST['checkbox']) == 1) {
                            $tvar = "checked";
                        }
                    }
                    $element = "<label class='container'>" . $nf . "<input type='checkbox' id='checkbox" . $i . "' name='checkbox[]' value='" . $nf . "' " . $tvar . "><span class='checkmark'></span></label>";
                    echo $element;
                    $i = $i + 1;
                }
            }
        }

        ?>

        <button onclick="clearchecks()">Clear Checkboxes</button>

        <input type="submit" value="Submit" name="submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $chkindex = 1;
        if (!empty($_POST['checkbox'])) {

            $myfile = fopen("data.txt", "a") or die("Unable to open file!");

            foreach ($_POST['checkbox'] as $value) {
                fwrite($myfile, $value);
                #echo "Chosen checkbox : " . $value . '<br>';
            }

            fwrite($myfile, "||2\n");

            fclose($myfile);

            while (!file_exists("data2.txt")) {
            }

            sleep(2);

            #print_r("File Received");

            $myfile = fopen("data2.txt", "r") or die("Unable to open file!");
            $str = "";
            $str = fread($myfile, filesize("data.txt"));
            fclose($myfile);
            $filearr2 = explode("\n", $str);

            #print_r($filearr2);

            foreach ($filearr2 as $fa) {
                print_r($fa);
                echo "<br>";
            }

            #unlink("data2.txt");

        }
    }

    ?>

    <script>
        function clearchecks() {
            $('input:checkbox').removeAttr('checked');
        }

        /*function sleep(milliseconds) {
            const date = Date.now();
            let currentDate = null;
            do {
                currentDate = Date.now();
            } while (currentDate - date < milliseconds);
        }*/
    </script>

</body>

</html>