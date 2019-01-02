<?php

// Retrieve and save a file
function wget($url, $output_document) {
    //print_r([$url, $output_document]);
    file_put_contents($output_document, file_get_contents($url));
}

// Extract the images url from the html document and save them to a csv file
function extract_img_url($html, $csv) {
    exec("node ".__DIR__."/extract_images_url_from_html.js $html > $csv");
}

function download_images($image_url_array, $img_folder) {
    if ( ! file_exists($img_folder)) 
        return false;

    foreach ($image_url_array as $image_url) {
        // Retrieve the image and save on disk
        wget($image_url, $img_folder . pathinfo($image_url)['basename']);
    }
}

function extract_txt_from_images($img_folder, $txt_folder) {
    $images = array_diff( scandir($img_folder), [".", ".."]);
    $images = array_map( function($img) use($img_folder) { return $img_folder . $img; }, $images);

    foreach($images as $image) {
        $txt_filename = $txt_folder . pathinfo($image)['filename'] . ".txt";
        
        // Extract text from image
        exec("python  ".__DIR__."/extract_text_from_image.py $image > $txt_filename");
    }
}

// Get the age
function extract_age($content) {
    preg_match("/anni \d+/", $content, $matches);

    if ( ! empty($matches)) { 
        $age = preg_split("/anni /", $matches[0]); 
        return $age[1];
    }

    return false;
}

function extract_ages($txt_folder, $age_csv) {
    $fp = fopen($age_csv, 'w'); 
    
    fputcsv($fp, [ 'filename', 'age' ]);

    $files = array_diff( scandir($txt_folder), [".", ".."]);

    // Populate csv with the ages
    foreach ($files as $filename) {
        if ($age = extract_age( file_get_contents($txt_folder . $filename))) {
            fputcsv($fp, [ $filename, $age ]);
        }
    }

    fclose($fp);
}