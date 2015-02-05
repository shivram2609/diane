<?php if(strtolower($type) == "youtube") { ?>
<iframe width="464px" height="250px" src="http://www.youtube.com/embed/<?php echo $linkid; ?>" frameborder="0" allowfullscreen></iframe>
<?php } else { ?>
<iframe src="http://player.vimeo.com/video/<?php echo $linkid; ?>" width="464px" height="250px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
<?php } ?>
<?php echo $this->Form->hidden("extlecid",array("value"=>$videoid,"id"=>"extlectid_".$ids[1],"class"=>"extlectid")); ?>
<?php echo $this->Form->hidden("extlinkid",array("value"=>$linkid,"id"=>"extlinkid_".$ids[1],"class"=>"extlinkid")); ?>
<?php echo $this->Form->hidden("extlinktype",array("value"=>$type,"id"=>"exttypeid_".$ids[1],"class"=>"exttypeid")); ?>
<?php echo $this->Form->hidden("extlinktitle",array("value"=>htmlentities($title),"id"=>"exttitleid_".$ids[1],"class"=>"exttitleid")); ?>

