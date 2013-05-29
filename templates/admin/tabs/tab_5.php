<style>
	.progress_bar {
	    height:20px;
	    background-color: blue;
	    width: 0;
	}
	
	.progress {
	    margin-top: 10px;
	    width: 300px;
	    border:solid 1px black;
	}
</style>

<div>
    <input type="checkbox"> Item 1
    <input type="checkbox"> Item 2
    <input type="checkbox"> Item 3
    <input type="checkbox"> Item 4
</div>

<div class="progress">
    <div class="progress_bar"></div>
</div>

<script type="text/javascript">

	jQuery(function() {
	    var checkbox = jQuery(":checkbox"),
	        checkbox_length = checkbox.length;
	    
	    checkbox.change(function () {
	        var that = jQuery(this),
	            progress = 0,
	            checked_length = 0;
	        
	        if(that.is(':last-child')) {
	              that.siblings().attr('checked', true);
	        }
	        
	        checked_length = jQuery(":checkbox:checked").length;
	        progress = checked_length / checkbox_length * 100;
	        
	        jQuery('.progress_bar').css('width', progress + '%');
	        
	        // just incase you wanted it to be a little bit fancy :P
	        // jQuery('.progress_bar').animate({'width' : progress + '%'}, 400); 
	    });
	}); 

</script>