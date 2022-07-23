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

            $filearr = explode("\n", $str);

            #print_r($filearr);

            #echo "<br>";

            if (count($filearr)) {
                $i = 1;
                foreach ($filearr as $nf) {
                    $tvar = "";
                    if (isset($_POST['submit']) and !empty($_POST['checkbox'])) {                      
                        if (in_array($nf."\n",$_POST['checkbox'])==1) {
                            $tvar = "checked";

                        }
                    }
                    $element = "<input type='checkbox' id='checkbox" . $i . "' name='checkbox[]' value='" . $nf . "' " . $tvar . "><label for='checkbox" . $i . "'>" . $nf . "</label><br>";
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

            foreach ($_POST['checkbox'] as $value) {
                echo "Chosen checkbox : " . $value . '<br>';
            }
        }
    }
    ?>

    <script>
        function clearchecks() {
            $('input:checkbox').removeAttr('checked');
        }
    </script>


</body>

</html>