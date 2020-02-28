<?php

$request = ms_newowsrequestobj();

foreach ($_GET as $k=>$v) {
     $request->setParameter($k, $v);
}

$request->setParameter("VeRsIoN","1.0.0");
ms_ioinstallstdouttobuffer();
$oMap = ms_newMapobj("/home/sujoy/Desktop/webgis/proj0/world/maps/dwms.map");

$new_layer =ms_newlayerobj($oMap);
$new_layer->set("type", MS_LAYER_POLYGON);
$new_layer->set("dump", 1);
$new_layer->set("status", 1);
$new_layer->set("name","cd");
$new_class = ms_newClassObj($new_layer);
$new_style = ms_newStyleObj($new_class);
$new_style-> outlinecolor->setRGB(255, 0, 0);
$new_layer->setConnectionType(MS_POSTGIS);
$new_layer->set("connection","user=postgres password=system dbname=nyc host=localhost");
$data="the_geom from (select * from cd) as foo using unique gid using SRID=2263";
$new_layer->set("data",$data) ;


$new_layer =ms_newlayerobj($oMap);
$new_layer->set("type", MS_LAYER_POINT);
$new_layer->set("dump", 1);
$new_layer->set("status", 1);
$new_layer->set("name","aoi");
$new_class = ms_newClassObj($new_layer);
$new_style = ms_newStyleObj($new_class);
$new_style-> color->setRGB(0, 0,255);
$new_style->set("symbolname", "circle");
$new_style->set("size", 5);

$new_layer->setConnectionType(MS_POSTGIS);
$new_layer->set("connection","user=postgres password=system dbname=nyc host=localhost");
$data="the_geom from (select * from aoi) as foo using unique gid using SRID=2263";
$new_layer->set("data",$data) ;

$new_layer =ms_newlayerobj($oMap);
$new_layer->set("type", MS_LAYER_LINE);
$new_layer->set("dump", 1);
$new_layer->set("status", 1);
$new_layer->set("name","hw");
$new_class = ms_newClassObj($new_layer);
$new_style = ms_newStyleObj($new_class);
$new_style-> color->setRGB(0, 134,200);
$new_style->set("width",2);

$new_style->set("size", 5);
$new_layer->setConnectionType(MS_POSTGIS);
$new_layer->set("connection","user=postgres password=system dbname=nyc host=localhost");
$data="the_geom from (select * from hw) as foo using unique gid using SRID=2263";
$new_layer->set("data",$data) ; 

$new_layer =ms_newlayerobj($oMap);
$new_layer->set("type", MS_LAYER_POLYGON);
$new_layer->set("dump", 1);
$new_layer->set("status", 1);
$new_layer->set("name","dynamicBuffer");
$new_class = ms_newClassObj($new_layer);
$new_style = ms_newStyleObj($new_class);
$new_style-> outlinecolor->setRGB(130, 120, 200);
$new_layer->setConnectionType(MS_POSTGIS);
$new_layer->set("connection","user=postgres password=system dbname=nyc host=localhost");
$data="geom from (select gid,st_buffer(the_geom,5000)as geom from hw) as foo using unique gid using SRID=2263";
$new_layer->set("data",$data) ;


$oMap->owsdispatch($request);
$contenttype = ms_iostripstdoutbuffercontenttype();
if ($contenttype == 'image/png')
{
   header('Content-type: image/png');
   ms_iogetStdoutBufferBytes();
}
else
{
	$buffer = ms_iogetstdoutbufferstring();
	echo $buffer;
}
ms_ioresethandlers();
?>
