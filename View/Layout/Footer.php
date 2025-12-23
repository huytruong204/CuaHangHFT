<section id="footer" class="clearfix">
  <div class="container">
    <div class="row">
      <div class="footer_1 clearfix">
        
        <div class="col-sm-3">
          <div class="footer_1l clearfix">
             <a class="navbar-brand" href="index.php"> 
                <i class="fa fa-cutlery col_1"></i> HFT Food <br> 
                <span class="small_tag">Hương vị tuyệt hảo</span> 
            </a>
          </div>
        </div>

        <div class="col-sm-5">
          <div class="footer_1m clearfix">
            <p class="mgt col">
                Chúng tôi cam kết mang đến những món ăn ngon nhất, nguyên liệu tươi sạch và hương vị đậm đà. HFT Food - Nơi gửi gắm niềm tin vào từng bữa ăn.
            </p>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="footer_1r clearfix">
            <h4 class="text-white mgt">Đăng ký nhận tin</h4>
            <div class="input-group">
                <input type="text" class="form-control form_2" placeholder="Nhập email của bạn...">
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-orange-footer" type="button">
                        <i class="fa fa-paper-plane"></i> Gửi
                    </button>
                </span>
            </div>
          </div>
        </div>

      </div>

      <div class="footer_2 clearfix">
        <div class="col-sm-6">
          <div class="footer_2l clearfix">
            <p class="mgt">© 2025 HFT Food. Bảo lưu mọi quyền. | Thiết kế bởi HFT Team</p>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="footer_2r text-right clearfix">
            <ul class="social-network social-circle mgt">
                <li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
                <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
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