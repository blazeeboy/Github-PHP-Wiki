<?php if( $mode=='config' ): ?>
flash:
	type:file
	label:flash file
width:
	type:number
height:
	type:number
bg:
	type:text
	label:background color 
quality:
	type:dropdown
	options:
		best:best
		high:high
		medium:medium
		low:low
align:
	type:dropdown
	options:
		left:left
		right:right
		top:top
		bottom:bottom	
loop:
	type:checkbox 
	default:true
transparent:
	type:checkbox
<?php elseif( $mode=='layout' ): ?>
0
<?php elseif( $mode=='view' ): ?>
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
 width="<?=$width?>"
 height="<?=$height?>"
 align="<?=$align?>" >
<param name=movie value="<?=base_url().$flash?>">
<param name=quality value=<?=$quality?>> 
<?php if($transparent ): ?>
<param name=wmode value=transparent> 
<?php endif; ?>
<param name=bgcolor value=<?=$bg?>>
<param name="loop" value="<?= ($loop)?'true':'false' ?>">
<EMBED 
		src="<?=base_url().$flash?>" 
		quality="<?=$quality?>"
		bgcolor="<?=$bg?>"
		width="<?=$width?>"
		height="<?=$height?>"
		loop="<?= ($loop)?'true':'false' ?>"
		type="application/x-shockwave-flash"
		align="<?=$align?>"
		<?php if($transparent){?>wmode="transparent" <?php } ?>
		
		pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"
 >
</EMBED>
</OBJECT> 
<?php endif; ?>
