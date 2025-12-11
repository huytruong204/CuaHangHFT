
 <section id="footer" class="clearfix">
 <div class="container">
  <div class="row">
    <div class="footer_1 clearfix">
     <div class="col-sm-3">
	  <div class="footer_1l clearfix">
	    <a class="navbar-brand" href="index.html"> <i class="fa fa-spoon col_1"></i> Online Food <br> <span class="small_tag">Restaurant</span> </a>
	  </div>
	 </div>
	 <div class="col-sm-5">
	  <div class="footer_1m clearfix">
	    <p class="mgt col">These are thei tastiest restaurants in this city right now. So we scour the city every day for great eats, great value.</p>
	  </div>
	 </div>
	 <div class="col-sm-4">
	  <div class="footer_1r clearfix">
	    <div class="input-group">
					<input type="text" class="form-control form_2" placeholder="Your Email...">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button">
							<i class="fa fa-paper-plane"></i></button>
					</span>
      </div>
	  </div>
	 </div>
	</div>
	<div class="footer_2 clearfix">
     <div class="col-sm-6">
	  <div class="footer_2l clearfix">
	    <p class="mgt">© 2013 Your Website Name. All Rights Reserved | Design by <a class="col_1" href="http://www.templateonweb.com">TemplateOnWeb</a></p>
	  </div>
	 </div>
     <div class="col-sm-6">
	  <div class="footer_2r text-right clearfix">
	    <ul class="social-network social-circle mgt">
			<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
			<li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
			<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
			<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
			<li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
        </ul>
	  </div>
	 </div>
	</div>
  </div>
 </div> 
</section>

<script>
$(document).ready(function(){
	/*****Fixed Menu******/
	var secondaryNav = $('.cd-secondary-nav'),
	   secondaryNavTopPosition = secondaryNav.offset().top;
		$(window).on('scroll', function(){
			if($(window).scrollTop() > secondaryNavTopPosition ) {
				secondaryNav.addClass('is-fixed');	
			} else {
				secondaryNav.removeClass('is-fixed');
			}
		});	
		
});
</script>

<script>
	$(document).ready(function() {              
    $('i.glyphicon-thumbs-up, i.glyphicon-thumbs-down').click(function(){    
        var $this = $(this),
        c = $this.data('count');    
        if (!c) c = 0;
        c++;
        $this.data('count',c);
        $('#'+this.id+'-bs3').html(c);
    });      
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });                                        
}); 

</script>

</body>
 
</html>