<?php
declare(strict_types=1);

$dirIter = new \RecursiveDirectoryIterator('/home/kurt/adocs-4-genealogy/modules/', \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO  | \FilesystemIterator::SKIP_DOTS);

$iter = new \RecursiveIteratorIterator($dirIter);

class FileExtensionFilterIterator extends FilterIterator {

     private string $extension;
    
     function accept() 
     {
         $file_info = $this->getInnerIterator()->current();
         
         return ($file_info->isFile() && ($file_info->getExtension() === $this->extension)) ? true : false;
     }

     function __construct(\Iterator $iter, string $ext)
     {
        parent::__construct($iter);

        $this->extension = $ext;
     }      
}

$filter_iterator = new FileExtensionFilterIterator($iter, "adoc");

foreach ($filter_iterator as $file) {
    
   echo $file->getPathname() . PHP_EOL;
   
}
echo "================\n";
// Alternative 2

// Filter directories
$callback_iter = new \CallbackFilterIterator($iter, function ($current, $key, $iterator) {

    return $current->isFile() && $current->getExtension() ===  'adoc';
});

foreach ($callback_iter as $file) {
    
   echo $file->getPathname() . PHP_EOL;
   
}


