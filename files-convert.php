#!/usr/bin/env php
<?php

   $cmd = 'find . -maxdepth 1 -name "*.html" -exec dos2unix {} \;';

   system($cmd);

   $cmd = 'find . -maxdepth 1 -name "*.html" -exec iconv -f ISO-8859-1 -t UTF-8 {} -o {}.utf-8 \;l';

   system($cmd);

   echo "Created .utf-8 unicode files.";

   system('rm *.html');

   system('rename "s/\.utf-8$/\.html/" *.utf-8');