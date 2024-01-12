# Overview

* Input: text file with two language, like  German and English, separated by `:`.
* Output: 
  * HTML file, whose name is the 2nd input argument. 
  * German HTML file.
  * English HTML file.
  * 
## Summary of Tools

### Algorithms

[algorithms.php](./algorithms.php) has:

* `GermanCollator` class. See the PHP built-in [Collator class](https://www.php.net/manual/en/class.collator.php)
* `binary_search` - a binary search that takes a `Collator`-derived class that implements `__invoke(string $left, $right)`.

### DOM and XPath

* [Parsing HTML files with DOMDocument and DOMXpath]()https://www.the-art-of-web.com/php/html-xpath-query/)
* [DOCXPath](https://www.phpdocx.com/documentation/introduction/docxpath) -- not free, but good description of desirable methods.

### FileReadIterator class 

FileReadIterator allows a file whose name is passed in the constructor to be used in foreach loops by implementing the \Iterator interface. It is strictly just a read-only forward iterator. 

### PHP Data Structures Extension

* [Efficient Data Structures for PHP](https://medium.com/@rtheunissen/efficient-data-structures-for-php-7-9dda7af674cd)

### Polyfill Extension

See it on [github](https://github.com/php-ds/polyfill)

[Github Repository](https://github.com/php-ds/ext-ds)

Note: To restart the PHP Fascgi process, do: 

    sudo systemctl restart php8.0-fpm

### html2utf.php

Converts all .html files in the current directory to unix unicode by:

* calling dos2unx
* calling `iconv` to convert from ISO-8859-1 to UTF-8.

To recurse the subdirectories, change `DirectoryIterator` to `RecursiveDirectoryIterator`:

```php

    $dir_recurse_iter = new \RecursiveIteratorIterator(RecursiveDirectoryIterator($dir_path));

    $files_only_iter = new \CallbackFilterIterator($dir_recurse_iter, function(\SplFileInfo $file_info) {
                    return $file_info->isFile();
                });
                
    $filter_iter = new \RegexIterator($files_only_iter, $regex);
    
```

A `foreach` loop returns a \DirectoryIterator--is that correct?--which extends SplFileInfo:

```php

    // class DirectoryIterator extends SplFileInfo implements SeekableIterator {...}

    foreach($filter_iter as $dir_iter) 
          FunctionObject($dir_iter); 
```

### replace-menus.php

This is a php script called from `find . -maxdepth1 -name "*.html" -exec ./replace-menu.php {} \;`
It does this:

* Doing: `$line = preg\_replace('/(charset=)(?:iso|ISO)-8859-1/', '$1UTF-8', $line);`
* Replacing selected German menu text with English

## TODO

* Merge replace-menus.php code into html2utf?
* Add algorithms.php and other relevant code from the 501 Verbs repository to this repository.
* See also: https://github.com/php-ds/ext-ds
