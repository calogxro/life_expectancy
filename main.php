<?php

require('constants.php');
require('src/functions.php');

// Create the folder output/
if ( ! file_exists('output')) {
    mkdir('output', 0777, true);
}


// STEP 1
if ( ! file_exists(DOC_HTML)) {
    wget(URL, DOC_HTML);
}


// STEP 2
if ( ! file_exists(IMG_CSV) && file_exists(DOC_HTML)) {
    extract_img_url(DOC_HTML, IMG_CSV);
}


// STEP 3
if ( ! file_exists(IMG_FOLDER) && file_exists(IMG_CSV)) {
    // Create the folder img/
    mkdir(IMG_FOLDER, 0777, true);
    
    // Retrieve the images and save them on disk
    download_images( file(IMG_CSV, FILE_IGNORE_NEW_LINES), IMG_FOLDER);
}


// STEP 4
if ( ! file_exists(TXT_FOLDER) && file_exists(IMG_FOLDER)) {
    // Create the folder txt/
    mkdir(TXT_FOLDER, 0777, true);
    
    extract_txt_from_images(IMG_FOLDER, TXT_FOLDER);
}


// STEP 5
if ( ! file_exists(AGE_CSV) && file_exists(TXT_FOLDER)) {
    extract_ages(TXT_FOLDER, AGE_CSV);
}
