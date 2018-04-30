<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	.containerSlider {
	  box-sizing: border-box;
	}
	.containerSlider, .containerSlider:before, .containerSlider:after {
	  box-sizing: inherit;
	}

	.loaderDarkContainer{
		background-color: rgba(0,0,0,0.8);margin:auto;text-align: center;width: 100%;height: 100%;position: absolute;display: none
	}
	.bigImgContainer{
		max-width: 400px;
		object-fit: cover;
		margin:auto;padding:0px;position: relative;text-align: center;
	}
	.bigImgContainer img {
		max-width: 100%;
		height: 300px;
		padding:0px;
		display: block;
		margin: auto;
		/*border:2px solid rgba(255, 122, 51, 1);*/
	}
	.slider_nav{
		max-width:400px;overflow: hidden;position: relative;
	}
	.containerSliderImages{
		position: relative;height: 72px;margin-left: 38px;overflow: unset;cursor: pointer;
		-webkit-transition: all 0.2s; 
   		 transition: all 0.2s;
	}
	.containerSliderImages img{
		height: 72px;
	}
	.containerSliderImages .imgItem{
		float: left;/*margin-right:1px*/;display: block;
		opacity: 0.8;transition: all 0.3s;
	}
	.containerSliderImages .imgItem:hover{
		opacity: 1
	}
	.containerSlider{
		max-width: 400px;margin:auto;position: relative;
	}
	.changeToNextSlide,.changeToBackSlide{
		height:72px;
		background:transparent;
		position:absolute;
		top:0px;
		text-align: center;
		font-size: 35px;
		cursor: pointer;
		z-index: 1000;
		color:rgba(255, 122, 51, 1);
		display:table;transition:all 0.3s;
		/*background-color: rgba(255, 122, 51, 1)*/
	}
	.changeToNextSlide:hover,.changeToBackSlide:hover{
		background-color: rgba(255, 122, 51, 0.3);color:white;
	}


	.changeToBackSlide{right:0px;}
	.changeToNextSlide{left:0px;}
	.changeToBackSlide .fa,.changeToNextSlide .fa{
		height: 100%;  display:table-cell;
		vertical-align: middle;padding: 0px 10px;
	}
	@media screen and (max-width: 400px) {
		.bigImgContainer img {
			height: auto;width: 100%;
		}
	}
	.loader {border: 4px solid #f3f3f3;border-top: 4px solid rgba(255, 122, 51, 1); border-radius: 50%;width: 30px;height: 30px;animation: spin 2s linear infinite;margin:auto;position: relative;top: 50%;top: calc(50% - 15px)}
	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	</style>
</head>
<body>
<div class="container">
	<div class="containerSlider" id="slider">
		<div class="bigImgContainer">
			<div class="loaderDarkContainer">
				<div class="loader"></div>
			</div>
			<img class="bigImg" src="400/milky-way-1030765_1920.jpg" alt="">
		</div>
		<div class="slider_nav">
			<div class="changeToNextSlide"><i class="fa fa-angle-left fa-lg" aria-hidden="true"></i></div>
				<div class="containerSliderImages">
					<?php
					$images = glob("{small/*.jpg,*.bmp,*.gif,*.png,*.jpeg}",GLOB_BRACE);?>
					<?php foreach ($images as $image): ?>
						<div class="imgItem"><img class="sliderImg" name="<?php echo basename($image); ?>" src="<?php echo $image; ?>" alt=""></div>
					<?php endforeach ?>
				</div>
			<div class="changeToBackSlide"><i class="fa fa-angle-right fa-lg" aria-hidden="true"></i></div>
		</div>
	</div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

<script>
class Slider {

    constructor (element) {
    	this.element=element;
    	this.pixelMove=100;

    	this.containerSliderImages = $(element).find('.containerSliderImages');
    	this.allElemSmallSlides = $(element).find(".imgItem");
    	this.elemChangeToNextSlide = $(element).find('.changeToNextSlide');		
    	this.elemChangeToBackSlide = $(element).find('.changeToBackSlide');	

        this.setSliderContainerImagesWidthByAllItemsWidth();
        this.changeBigPhoto(this.element);
        this.changeToBackSlide(this.containerSliderImages,this.pixelMove);
        this.changeToNextSlide(this.containerSliderImages,this.pixelMove);

    }

    setSliderContainerImagesWidthByAllItemsWidth(){
    	let totalWidth = 0;
		this.containerSliderImages.children().each(function() {
			totalWidth += $(this).outerWidth();
		});
		this.containerSliderImages.css("width", totalWidth);
    }

    changeBigPhoto(element){
    	$(element).on("click", ".sliderImg", function(event){
    		$(element).find('.loaderDarkContainer').show();
    		const bigImgSrc= $(this).attr('name');
			$(element).find('.bigImg').attr('src','400/'+bigImgSrc).bind('onreadystatechange load', function(){
		        if (this.complete) {
		        	$(element).find('.loaderDarkContainer').hide();
		        }
		    });
    	});
    }

    changeToBackSlide(containerSliderImages,move){
 
    	$(this.elemChangeToBackSlide).click(function(event) {
			event.preventDefault();
			const arrow_offset=$(this).offset();
			const last_nav_imgItem_offset = $(containerSliderImages).find( ".imgItem:last" ).offset();
			
		    if (last_nav_imgItem_offset.left > arrow_offset.left-70) {
		    	$(containerSliderImages).css({ left : "-=" + move});
		    }else{
		    	const difference_item=arrow_offset.left-last_nav_imgItem_offset.left;
		    	$(containerSliderImages).css({ left : "+=" + difference_item});
		    }	
		});
    }

    changeToNextSlide(containerSliderImages,move){

    	$(this.elemChangeToNextSlide).click(function(event) {
			event.preventDefault();
			const position = $(containerSliderImages).offset();
		    const currentPosition = parseInt(containerSliderImages.css("left"));
		    if (currentPosition < 0) {
		    	$(containerSliderImages).css({ left : "+=" + move});
		    }else{
		    	$(containerSliderImages).css('left','0');
		    }
		});

    }
}



window.onload = function() {
  const first_slider = new Slider('#slider');
};
</script>
</body>
</html>