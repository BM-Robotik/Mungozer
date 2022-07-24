<!DOCTYPE HTML>
<html>

<head>
    <title>Mungozer</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

    <p id="pagetitle">Mungozer</p>
    <div style="text-align: center;">
        <p style="padding: 5px;">Uber Global Hackathon 2022 Mungozer Project</p>
        <p><a href="https://docs.google.com/document/d/1lLqGLsornnGeWNztgT_D-3rXzOkDOwlTFEkS4VndnfA" target="_blank" rel="noopener" class="footerlink">Disclaimer</a></p>
        <p><a href="mailto:batuhanmrmr@gmail.com" target="_blank" rel="noopener" class="footerlink">Batuhan Mermer</a>, <a href="mailto:venoa@protonmail.com" target="_blank" rel="noopener" class="footerlink">Umut Mutlu</a> and <a href="mailto:egenogay@gmail.com" target="_blank" rel="noopener" class="footerlink">Ege Nogay Öztürk</a></p>
    </div>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div id="inputbox1">
            <p class="divtitle"><b>Select your symptoms:</b></p>
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
                        $element = "<label style='display: inline-block;' class='container'>" . $nf . "<input type='checkbox' id='checkbox" . $i . "' name='checkbox[]' value='" . $nf . "' " . $tvar . "><span class='checkmark'></span></label>";
                        echo $element;
                        $i = $i + 1;
                    }
                }
            }

            ?>

        </div>
        <div id="submit-clear">
            <button onclick="clearchecks()" class="clear_button">Clear Checkboxes</button>
            <input type="submit" class="submit_button" value="Submit" name="submit">
        </div>
    </form>

    <div id="outputbox1">
        <p class="divtitle"><b>Calculated results of possible diseases:</b></p>
        <?php
        if (isset($_POST['submit']) and !empty($_POST['checkbox'])) {
            $chkindex = 1;

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
                if (strpos($fa, "Medium Possibility")) {
                    echo "<p class='diseasetext'> &#129001 " . $fa . "</p>";
                } elseif (strpos($fa, "High Possibility")) {
                    echo "<p class='diseasetext'> &#129000 " . $fa . "</p>";
                } elseif (strpos($fa, "Very Likely")) {
                    echo "<p class='diseasetext'> &#128997 " . $fa . "</p>";
                } elseif (strpos($fa, "that serious")) {
                    echo "<p class='diseasetext'> &#128153 " . $fa . "</p>";
                }
            }

            #unlink("data2.txt");

        } else {
            echo "<p class='diseasetext' style='font-size: 20px'> &#128309 Diseases will show up here in 3-5 seconds after you submit.</p>";
        }

        ?>
    </div>

    </div>

    <div id="howto">
        <p style="font: 16px 'Ubuntu_Light';"><b style="font: 16px 'Ubuntu_Regular';">How to use: </b><br>1. Select your symptoms.<br>2. Click "Submit".<br>3. Look at your results after 3-5 seconds.</p>
    </div>

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