<?php
if (isset($_POST["button"])) {
    $output = "";
    if ($_FILES['zip_file']['name'] != '') {
        $file_name = $_FILES['zip_file']['name'];
        $array = explode(".", $file_name);
        $name = $array[0];
        $extension = $array[1];
        if ($extension == "zip") {
            $path = getcwd().DIRECTORY_SEPARATOR . "upload/";
            $cache_path = getcwd().DIRECTORY_SEPARATOR . "cache/";
            $location = $path . $file_name;
            if (!file_exists($path)) mkdir($path, 0777, true);
            if (!file_exists($cache_path)) mkdir($cache_path, 0777, true);
            if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
                $zip = new ZipArchive;
                if ($zip->open($location)) {
                    $zip->extractTo($path);
                    $zip->close();
                }
                $files = scandir($path);
                foreach($files as $file) {
                    $tmp = explode('.', $file);
                    $file_extension = end($tmp);
                    $allowed_extension = array('jpg', 'png');
                    if (in_array($file_extension, $allowed_extension)) {
                        $new_name = md5(rand()) . "." . $file_extension;
                        $output .= '<div class="col-md-6"><img src="cache/'. $new_name .'" width=500px height=250px/></div>'; 
                        copy($path.$file, $cache_path . $new_name);
                        unlink($path.$file);
                    }
                }
                unlink($location); 
                rmdir($path);
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Engineering Internship Assessment</title>
    <meta name="description" content="The HTML5 Herald" />
    <meta name="author" content="Digi-X Internship Committee" />

    <link rel="stylesheet" href="style.css?v=1.0" />
    <link rel="stylesheet" href="custom.css?v=1.0" />

</head>

<body>

    <div class="top-wrapper">
        <img src="https://assets.website-files.com/5cd4f29af95bc7d8af794e0e/5cfe060171000aa66754447a_n-digi-x-logo-white-yellow-standard.svg" alt="digi-x logo" height="70" />
        <h1>Engineering Internship Assessment</h1>
    </div>

    <div class="instruction-wrapper">
        <h2>What you need to do?</h2>
        <h3 style="margin-top:31px;">Using this HTML template, create a page that can:</h3>
        <ol>
            <li><b class="yellow">Upload</b> a zip file - containing 5 images (Cats, or Dogs, or even Pokemons)</li>
            <li>after uploading, <b class="yellow">Extract</b> the zip to get the images </li>
            <li><b class="yellow">Display</b> the images on this page</li>
        </ol>

        <h2 style="margin-top:51px;">The rules?</h2>
        <ol>
            <li>May use <b class="yellow">any programming language/script</b>. The simplest the better *wink*</li>
            <li><b class="yellow">Best if this project could be hosted</b></li>
            <li><b class="yellow">If you are not hosting</b>, please provide a video as proof (GDrive video link is ok)</li>
            <li><b class="yellow">Submit your code</b> by pushing to your own github account, and share the link with us</li>
        </ol>
    </div>

    <form method="post" enctype="multipart/form-data">
        <label>Choose zip file</label>
        <input type="file" name="zip_file" />
        <br />
        <input type="submit" name="button" class="btn btn-info" value="Submit" />
    </form>

    <!-- DO NO REMOVE CODE STARTING HERE -->
    <div class="display-wrapper">
        <h2 style="margin-top:51px;">My images</h2>
        <div class="append-images-here">
            <!-- THE IMAGES SHOULD BE DISPLAYED INSIDE HERE -->
            <?php  
                if(isset($output))  {  
                    echo $output;  
                }  
            ?>
        </div>
    </div>
    <!-- DO NO REMOVE CODE UNTIL HERE -->

</body>

</html>