<?php

class fileManager {

    /**
      * compressFile.
      * ------------------------
      * @param $date = null
      * @return boolean
      * @author Ibrahim Shendy
      * @copyright 2017-03-08 Takweed.co
      */
    public function compressFile($date = null)
    {

        if(! self::validateDate($date)) {
            echo json_encode([
                    'status' => 0,
                    'file'   => '',
                ], true);
            exit;
        }

        $file_name  = md5(microtime().rand(1,20).time()).'_'.date('Y-m-d', strtotime($date)).'.zip'; 
        $zip_file   = $file_name;

        $zip = new ZipArchive();

        if ( $zip->open($zip_file, ZipArchive::CREATE) !== TRUE) {
            exit("message");
        }

        self::__getModifiedFiles('../', $zip, $date);
        
        $zip->addFromString(time()."author.txt", "#1 Ibrahim Shendy .\n");
        $zip->close();

        echo json_encode([
                'status' => 1,
                'file'   => $file_name,
            ], true);
    } 

    /**
      * __getModifiedFiles.
      * ------------------------
      * @param $dir, $zip
      * @return string
      * @author Ibrahim Shendy
      * @copyright 2017-03-08 Takweed.co
      */
    private function __getModifiedFiles($dir, $zip, $date)
    {
        $ffs = scandir($dir);

        foreach($ffs as $ff){
            if($ff != '.' && $ff != '..' && (strpos($dir.$ff, 'resources') !== false || strpos($dir.$ff, 'app') !== false)){
                if(date('Y-m-d', filemtime($dir.'/'.$ff)) == date('Y-m-d', strtotime($date))) {
                    if (file_exists($dir.'/'.$ff) && is_file($dir.'/'.$ff)){
                        $file = str_replace('..//', '', $dir.'/'.$ff);
                        $file = str_replace('/', '\\', $file);

                        $zip->addFile($dir.'/'.$ff, $file);
                    }
                    
                }

                if(is_dir($dir.'/'.$ff))
                    self::__getModifiedFiles($dir.'/'.$ff, $zip, $date);
            }
        }
        return $zip;
    }

    /**
     * @url : https://stackoverflow.com/questions/12322824/php-preg-match-with-working-regex/12323025#12323025
     *
     */
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

(new fileManager)->compressFile($_POST['date']);


exit;