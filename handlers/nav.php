<?php

$docid = preg_match ('|^/docs/(.+)$|', $_SERVER['REQUEST_URI'], $regs) ? $regs[1] : 'index';

$doc = new docs\Doc ($docid);
if ($doc->error) return;

echo $doc->nav ();

?>