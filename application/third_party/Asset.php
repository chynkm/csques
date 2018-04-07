<?php
$current_directory = dirname(__FILE__);
$directoryTree = explode('/', $current_directory);
$directoryTree = array_splice($directoryTree, 0, -2);
define('ASSETPATH', implode('/', $directoryTree).'/');

/**
 * Fingerprint assets for cache busting
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string $filename
 *
 * @return string
 */
class Asset {

    public static function fingerprint_assets() {
        $source_directory = ASSETPATH.'assets';
        $destination_directory = ASSETPATH.'production-assets';

        exec('rm -rf '.$destination_directory);

        self::recursive_copy($source_directory, $destination_directory);
    }

    private static function recursive_copy($source_directory, $destination_directory) {
        $dir = opendir($source_directory);
        @mkdir($destination_directory);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.gitignore' )) {
                if ( is_dir($source_directory . '/' . $file) ) {
                    self::recursive_copy($source_directory . '/' . $file,$destination_directory . '/' . $file);
                } else {
                    $destinationFileName = $file;
                    if($file != 'index.html' && $source_directory != ASSETPATH.'assets/q-images') {
                        $explodedFileName = explode('.', $file);
                        $fileExtension = array_pop($explodedFileName);

                        if(!in_array($fileExtension, ['eot', 'svg', 'ttf', 'woff'])) {
                            if(end($explodedFileName) == 'min') {
                                $fileExtension = array_pop($explodedFileName).'.'.$fileExtension;
                            }
                            $destinationFileName = implode('.', $explodedFileName).'-'.md5_file($source_directory.'/'.$file).'.'.$fileExtension;
                            echo $destinationFileName." \n";
                        }
                    }
                    copy($source_directory . '/' . $file,$destination_directory . '/' . $destinationFileName);
                }
            }
        }
        closedir($dir);
    }

}

Asset::fingerprint_assets();
