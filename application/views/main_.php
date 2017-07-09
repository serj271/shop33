<!DOCTYPE HTML >
<html>
<head>
<title><?php echo $title ?></title>
    <meta charset="utf-8">
    <?php 
	foreach($styles as $style){ 
//	    echo html::style("css/public/".$style);
	}
//	foreach($scripts as $scr){
//	    echo html::script("js/".$scr.".js").PHP_EOL;
//	}
	$search = Kohana::$base_url;
	foreach($scripts as $scr){
		$s = str_replace($search,  '/',$scr['js']);
#		$log = Log::instance();
#		$log->add(Log::INFO, $s);
#		$log->add(Log::INFO , Debug::vars($s));
//	    echo html::script("js/public/".$s);
	}
	echo html::script("js/public/personal.js");

    ?>
    <!--[if IE]>
	<link href="<?=URL::base()?>css/ie-v4.css" rel="stylesheet" type="text/css">
    <![endif]-->

</head>
<body>

<div id="container">
    <div id="main">
        <div id="all">			
			<div id="in">
                <div id="center">
					<?php echo $content;?>
				</div>
			</div>
			<div id="left">
				<b class="bottom"></b>                
				<b class="top"></b>                
                <div class="content">
					<?php echo $navigator; ?>
                </div>
			</div>	
        </div>
    </div>
    <div id="footer">
      foter 
    </div>

</div>

<div id="header">
	<?=$menu; ?>
	<div id="logo">
	    <a title="To main" href="<?=URL::base()?>personal"></a>
	</div>
</div>


<!--[if IE]>
    <script type="text/javascript">
	document.body.setAttribute('class','ie');
    </script>
<![endif]-->


</body>
</html>