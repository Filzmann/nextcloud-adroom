<?php

declare(strict_types=1);

$root=dirname(__DIR__); $iterator=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root,FilesystemIterator::SKIP_DOTS));
foreach($iterator as $file) if($file->isFile()&&$file->getExtension()==='php'&&!str_contains($file->getPathname(),'/.git/')){passthru('php -l '.escapeshellarg($file->getPathname()),$code);if($code!==0)exit($code);}
foreach(array_merge(glob(__DIR__.'/*Test.php'),glob(__DIR__.'/Controller/*Test.php'),glob(__DIR__.'/Service/*Test.php'),glob(__DIR__.'/Ui/*Test.php')) as $test){passthru('php '.escapeshellarg($test),$code);if($code!==0)exit($code);}
echo "AD Raumplaner PHP tests passed\n";

