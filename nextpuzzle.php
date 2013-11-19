<?php
    //start session to get access to stored data from first submission
    session_start();
    
    include('inc/functions.php');
    
    $_SESSION['current_puzzle'] = $_SESSION['current_puzzle'] + 1;
    if ($_SESSION['current_puzzle'] > $_SESSION['number_of_puzzles'])
    {
        //redirect back to first page
        header("location: http://picpuzzle.dkteacherswiki.com"); 
    }
    else
    {
        //get new image size
        list($width, $height) = getimagesize($_SESSION['image_array'][($_SESSION['current_puzzle'] - 1)]);
        
        //Set box sizes in pixels
        $boxW = round($width / $_SESSION['xy_values'][0]);
        $boxH = round($height / $_SESSION['xy_values'][1]);
        
        $pagestart = pp_build_page($_SESSION['image_array'][($_SESSION['current_puzzle'] - 1)], $height, $width, $boxH, $boxW);

        print $pagestart;
        exit;
        
        
        
    }
?>