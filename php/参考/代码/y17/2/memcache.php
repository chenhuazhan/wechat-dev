<?php 


$mmc=memcache_init();

memcache_set($mmc,"key",'value',0,60);



 ?>