

    <?php
            // create curl resource
            $ch = curl_init();
     
            // set url
            curl_setopt($ch, CURLOPT_URL, "79.133.43.76/test.txt");
     
            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
            // $output contains the output string
            $output = curl_exec($ch);
            echo($output);
        // muss irgendwas ausgeben!
     
            // close curl resource to free up system resources
            curl_close($ch);
    ?>

