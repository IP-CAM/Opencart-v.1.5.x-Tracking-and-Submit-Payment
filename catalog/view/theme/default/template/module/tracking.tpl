<div class="box">
    <div class="box-heading"><?php echo $heading_title; ?></div>
        <div class="box-content">
            <div class="box-tracking">
            <div id="slider">
            <ul>  
            <?php foreach ($orders as $order) { ?>
            	<li>
                    <a href="<?php echo $order['href']; ?>" class="active"><?php echo $order['firstname'] . ' ' . $order['lastname']; ?></a><br />
                	<span><?php echo $text_orderstatus; ?> <?php echo $order['status']; ?></span><br />
                    <span><?php echo $text_orderdate; ?> <?php echo $order['date_added']; ?></span>
                    
                </li>
            <?php } ?>
            </ul>
            </div>
            <!--<span><strong><?php echo $text_todayorder; ?></strong></span><br /><span class="todayorder"><?php echo $today_order; ?></span><br />
            <span><strong><?php echo $text_totalorder; ?></strong></span><br /><span class="todayorder"><?php echo $total_order; ?></span>-->
    	</div>
    </div>
</div>
<!-- Easy Slider Image -->
<link rel="stylesheet" href="catalog/view/javascript/easyslider/1.7/css/screen.css" type="text/css" media="screen" />
<script src="catalog/view/javascript/easyslider/1.7/js/easySlider1.7.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#slider").easySlider({
			auto: true,
			continuous: true,
			speed: 800,
			pause: 3000,
			numericId: 'controls',
			controlsShow: false,
			numeric: false
		});
		$("#slider").mouseenter(function(){
			animate("stop",true);
		}).mouseleave(function(){
			animate("next",true);
		});
	});
</script>