<?php
declare(strict_types = 1);

/*
 * binary_search(array $, mixed $key, callable $functor)
 *
 * input: 
 * $comparator can be either a lambda or a binary predicate object (like GermanComparator below).
 * Note: Type 'object' can be used in place of 'callable' without code breaking.
 * $key - the key to find
 * 
 * Examples:
 *
 * 1. Find 'bekommen' in array of german verbs using the GermanCompartor predicate object (defined below). 
 *
 *    binary_search($german_verbs, "bekommen", new GermanComparator('de_DE'));
 *   
 * 2. Use a lambda function as the comparator
 *
 *  $germanComp = new Collator('de_DE');
 *
 *  $closure = function (string $str1, string $str2) use ($germanComp) { return $germanComp->compare($str1, $str2); };
 *  
 *  binary_search($keys, 'ächzen', $closure); 
 *
 */

function binary_search(array $a, mixed $key, callable $functor)
{   
  $lo = 0;

  $hi = count($a) - 1;

    while ($lo <= $hi) {

        $mid = $lo + (int)(($hi - $lo) / 2);
   
        $cmp = $functor($a[$mid], $key);

        if ($cmp < 0)             
            $lo = $mid + 1;

        elseif ($cmp > 0) 
            $hi = $mid - 1;

        else 
            return $mid; // OR: {true, $mid};        
    }
    return -1;  
}

/*
 Callable for doing German string comparision. They can also be used for sorting 
 arrays of German strings.
 
 You can create a German language string comparison function object two ways:
 
   1. Define the GermanCompartor class below that uses PHP's __invoke magic method to supply an
     overloaded binary function call operator, i.e. one that take left and right string parameter.

   2. Create a closure  
  
 Method 1: GermanCompartor supports a function object for doing German string comparisons.
 */
class GermanComparator extends Collator {

   public function __construct()
   {
       parent::__construct('de_DE');
   }

   public function __invoke(string $str1, string $str2)
   {
       return $this->compare($str1, $str2); 
   }
}
/*
Method 2: a closure/lambda that does the same thing
 */

$de_collator = new Collator('de_DE');

$de_compare = function(string $left, string $right) use($de_collator) {
    return $de_collator->compare($left, $right);
}
 
