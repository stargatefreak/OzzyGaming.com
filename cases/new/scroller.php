<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Image Scroller</title>
</head>
<body>

</body>
</html>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        var scroller = $('#scroller div.innerScrollArea');
        var scrollerContent = scroller.children('ul');
        scrollerContent.children().clone().appendTo(scrollerContent);
        var curX = 0;
        scrollerContent.children().each(function(){
            var $this = $(this);
            $this.css('left', curX);
            curX += $this.outerWidth(true);
        });
        var fullW = curX / 2;
        var viewportW = scroller.width();

        // Scrolling speed management
        var controller = {curSpeed:0, fullSpeed:8};
        var $controller = $(controller);
        var tweenToNewSpeed = function(newSpeed, duration)
        {
            if (duration === undefined)
                duration = 600;
            $controller.stop(true).animate({curSpeed:newSpeed}, duration);
        };

        // Pause on hover
        scroller.hover(function(){
            //tweenToNewSpeed(0);
        }, function(){
            //tweenToNewSpeed(controller.fullSpeed);
        });

        // Scrolling management; start the automatical scrolling
        var doScroll = function()
        {
            var curX = scroller.scrollLeft();
            var newX = curX + controller.curSpeed;
            if (newX > fullW*2 - viewportW)
                newX -= fullW;
            scroller.scrollLeft(newX);
        };
        setInterval(doScroll, 20);
        tweenToNewSpeed(controller.fullSpeed);
    });
</script>

<style type="text/css">
    #scroller {
        position: relative;
    }
    #scroller .innerScrollArea {
        overflow: hidden;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    #scroller ul {
        padding: 0;
        margin: 0;
        position: relative;
    }
    #scroller li {
        padding: 0;
        margin: 0;
        list-style-type: none;
        position: absolute;
    }
</style>

<div id="scroller" style="width: 1280px; height: 720px; margin: 0 auto;">
    <div class="innerScrollArea">
        <ul>
            <!-- Define photos here -->
            <li><img src="img/DMR_01_F.jpg" width="1080" height="720" /></li> <!-- Rahim -->
            <li><img src="img/EBR_F.jpg" width="1080" height="720" /></li> <!-- Mk18 -->
            <li><img src="img/Katiba_F.jpg" width="1080" height="720" /></li> <!-- Katiba -->
            <li><img src="img/Mk20_F.jpg" width="1080" height="720" /></li> <!-- Mk20 -->
            <li><img src="img/Mk200_F.jpg" width="1080" height="720" /></li> <!-- Mk200 -->
            <li><img src="img/MX_F.jpg" width="1080" height="720" /></li> <!-- MX -->
            <li><img src="img/MXM_F.jpg" width="1080" height="720" /></li> <!-- MXM -->
            <li><img src="img/PDW2000_F.jpg" width="1080" height="720" /></li> <!-- PDW -->
            <li><img src="img/Rook40_F.jpg" width="1080" height="720" /></li> <!-- Rook -->
            <li><img src="img/SDAR_F.jpg" width="1080" height="720" /></li> <!-- SDAR -->
            <li><img src="img/TRG21_F.jpg" width="1080" height="720" /></li> <!-- TRG21 -->
            <li><img src="img/SMG_02_F.jpg" width="1080" height="720" /></li> <!-- String -->
        </ul>
    </div>
</div>

