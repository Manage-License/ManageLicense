<?php
/**
 * Manage License module by Rouhollah Talebian (hostbaran@gmail.com)
 * © All right reserved for NicSepehr Team
 */
if(!defined('WHMCS')){
	die("This file cannot be accessed directly");
}


function manage_license_update()
{
     if(!extension_loaded("zip"))
         return 'Zip extension must be enabled.';
//
     $file_path = __DIR__ . '/master.zip';
//
     $archiveUrl = 'https://codeload.github.com/Manage-License/ManageLicense/zip/master';
     $ch = curl_init($archiveUrl);
     curl_setopt_array($ch, [
         CURLOPT_SSL_VERIFYHOST => false,
         CURLOPT_SSL_VERIFYPEER => false,
         CURLOPT_BINARYTRANSFER => true,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_FOLLOWLOCATION => true,
     ]);
     $raw_file_data = curl_exec($ch);
     if (curl_errno($ch)) {
         return 'Failed to download archive: ' . curl_error($ch);
     }
     curl_close($ch);
     file_put_contents($file_path, $raw_file_data);
//
     $zip = new ZipArchive();
     $res = $zip->open($file_path);
//
     if ($res !== true) {
         return "Unable to open $file_path, error code: $res";
     }
//
     $extractSubdirTo = function ($destination, $subdir) use($zip)
     {
       $errors = array();
//
       // Prepare dirs
       $destination = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $destination);
//       $subdir = str_replace(array("/", "\\"), "/", $subdir);
//
       if (substr($destination, mb_strlen(DIRECTORY_SEPARATOR, "UTF-8") * -1) != DIRECTORY_SEPARATOR)
         $destination .= DIRECTORY_SEPARATOR;
//
       if (substr($subdir, -1) != "/")
         $subdir .= "/";
//
       // Extract files
       for ($i = 0; $i < $zip->numFiles; $i++)
       {
         $filename = $zip->getNameIndex($i);
//
         if (substr($filename, 0, mb_strlen($subdir, "UTF-8")) == $subdir)
         {
           $relativePath = substr($filename, mb_strlen($subdir, "UTF-8"));
           $relativePath = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $relativePath);
//
           if (mb_strlen($relativePath, "UTF-8") > 0)
           {
             if (substr($filename, -1) == "/")  // Directory
             {
               // New dir
               if (!is_dir($destination . $relativePath))
                 if (!@mkdir($destination . $relativePath, 0755, true))
                   $errors[$i] = $filename;
             }
             else
             {
               if (dirname($relativePath) != ".")
               {
                 if (!is_dir($destination . dirname($relativePath)))
                 {
                   // New dir (for file)
                   @mkdir($destination . dirname($relativePath), 0755, true);
                 }
               }
//
               // New file
               if (@file_put_contents($destination . $relativePath, $zip->getFromIndex($i)) === false)
                 $errors[$i] = $filename;
             }
           }
         }
       }
       return $errors;
     };
     $result = $extractSubdirTo(ROOTDIR, 'ManageLicense-master');
     if(sizeof($result)){
         $zip->close();
         return implode(",", $result);
     }
     $zip->close();
//    return true;
}

