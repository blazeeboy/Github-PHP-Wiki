<?php
$ci =& get_instance();
theme_add( 'assets/admin/edit panel/style.css' );
theme_add( 'jquery/jquery.js' );
theme_add( 'assets/fancybox/jquery.fancybox.js' );
theme_add( 'assets/fancybox/jquery.fancybox.css' );
$local = base_url().'/assets/admin/';
$logout = site_url( 'auth/logout' );
$XHR_URL = site_url('editmode/'.($ci->system->mode=='edit'? 'view':'edit'));

theme_add( <<<EOT

<script type="text/javascript">

function systemButtonToggler(){
		$(".panel").toggle("fast");
		$(this).toggleClass("active");
		return false;
}

$(function (){
	$(".trigger").click(systemButtonToggler);
	$("a.iframe").fancybox({
			frameWidth: 600,
			frameHeight: 450,
	});
});

// switching editmode
function admin_editmode_toolbar()
{
	$.get( "{$XHR_URL}", function(response){
			document.location.reload();
	});
}
</script>
EOT
);
?>


<div class="panel">

	<a href="<?=site_url('sectionEditor')?>" class="iframe"  title="Sections manager">
		<img src="<?=$local?>link.png" /> Sections manager
	</a>
	
	<a href="<?=site_url('usersEditor')?>" class="iframe" title="Users manager" >
		<img src="<?=$local?>link.png" /> User manager
	</a>
	
	<a href="javascript:admin_editmode_toolbar()" >
		<img src="<?=$local?>link.png" title="Editmode toggle" /> Toggle Edit mode
	</a>
	
	<a href="<?=site_url('auth/change_password')?>" class="iframe" >
		<img src="<?=$local?>link.png" title="Change Password" />Change Password
	</a>
	
	<a href="<?=$logout?>" >
		<img src="<?=$local?>link.png" title="Logout" /> Logout
	</a>

</div>
<a class="ui-draggable trigger" href="#"></a>

