<div class="shareAllThings">
	<?php 
		$this->image_forShare = $item->getSafeFirstPicUrl();
		$this->description_forShare = $item->summary;
		$this->title_forShare = "[ZLOOP] " . $item->title;
	?>
	
	<!-- facebook share -->
	<a target="_blank" href='http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($item->getFullAndSafeUrl());?>'>
		<img src="/images/decoration/facebook_share_button.png" />
	</a> 
	
	<!-- weibo Share -->
	<script type="text/javascript" charset="utf-8">
	(function(){
	  var _w = 32 , _h = 32;
	  var param = {
	    url:'<?php echo $item->getFullAndSafeUrl();?>',
	    type:'1',
	    count:'', /**是否显示分享数，1显示(可选)*/
	    appkey:'', /**您申请的应用appkey,显示分享来源(可选)*/
	    title:'<?php echo CHtml::encode($this->title_forShare . " [DETAIL] " . $this->description_forShare);?>', /**分享的文字内容(可选，默认为所在页面的title)*/
	    pic:'<?php echo $this->image_forShare;?>', /**分享图片的路径(可选)*/
	    ralateUid:'<?php echo Yii::app()->params['weibo_id'];?>', /**关联用户的UID，分享微博会@该用户(可选)*/
		language:'zh_tw', /**设置语言，zh_cn|zh_tw(可选)*/
	    rnd:new Date().valueOf()
	  }
	  var temp = [];
	  for( var p in param ){
	    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
	  }
	  document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
	})()
	</script>
	
	<!-- RENREN share -->
	<a target="_blank" href='http://share.renren.com/share/buttonshare?link=<?php echo urlencode($item->getFullAndSafeUrl());?>&title=<?php echo $this->title_forShare . " [DETAIL] " . $this->description_forShare;?>'>
		<img src="/images/decoration/share_renren_button.png" />
	</a>
	
	<!-- twitter share -->
	<a target="_blank" href='https://twitter.com/share?text=<?php echo urlencode($this->title_forShare . " [DETAIL] " . $this->description_forShare);?>&url=<?php echo urlencode($item->getFullAndSafeUrl());?>'>
		<img src="/images/decoration/twitter_share_icon.png" />
	</a>
	
</div>

<div class="itemInstruction">
<h3>How to get it?</h3>
<ol>
	<li>Leave a message below</li>
	<li>Make a deal with seller</li>
	<li>Trade face-to-face</li>
</ol>
</div>