<?php
/**
* recursive delete folder
* @param $dir
* @return bool
*/
function delFolder($dir)
{
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delFolder("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

echo (delFolder("../var/cache/"))?"OK":"Error";
echo (mkdir("../var/cache/"))?"OK":"Error";
