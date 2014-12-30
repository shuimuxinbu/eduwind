<h3 class="dxd-fancybox-header">系统更新进度</h3>
<div class="dxd-fancybox-body">
<div id="upgradeInfoBox">

</div>
</div>

<div class="dxd-fancybox-footer">
</div>

<script type="text/javascript">
$(document).ready(function(){
	var versions=[<?php echo $versions;?>];
	var version = '';
	var bupgrade = false;
	var bprocess = false;
	var versionIdx = 0;
	var stageIdx = 0;
	var versionNum = versions.length;

	$.ajax({
		url: "<?php echo $this->createAbsoluteUrl('upgradeClient/checkEnv');?>",
		async:false,
		context: $("#upgradeInfoBox"),
		dataType: 'json',
		success:function(data) {
			//$(this).append(data.html);
			(data.status == 'success')?bupgrade = true:bupgrade = false;	
			$(this).append(data.message);			
		}
	});
	if (bupgrade == true) {
		//$.each(versions,function(key,val){
			//提示升级包版本号
			
			//$("#upgradeInfoBox").append('<p>现在开始升级版本'+versions[i]+'</p>');
			
			run();
		//});
	}

	function run(){
		if(bprocess){
			setTimeout(run,1000);
		}else {
			bprocess = true;
			version = versions[versionIdx];
			$("#upgradeInfoBox").append('<p>现在开始升级版本'+version+'</p>');
			stageIdx = 0;
			doUpgrade();
			if(bupgrade && versionIdx<versionNum-1){
				versionIdx++;
				setTimeout(run,0);
			}
		}
	}
	function doUpgrade(){
		//doDownload();
		//doUnzip();
		//doOverride();
		
		switch(stageIdx){
		case 0:
			doDownload();
			break;
		case 1:
			doUnzip();	
			break;
		case 2:
			doOverride();
			bprocess = false;
			break;
		default:
			break;	
		}

		if(stageIdx<3){
			stageIdx++;
			setTimeout(doUpgrade,0);
		}
		
	}
	 
	//进行升级包下载
	function doDownload(){
		if (bupgrade == true) {
			bupgrade = false;
			$.ajax({
				url: "<?php echo $this->createAbsoluteUrl('upgradeClient/downloadPackage');?>",
				type: 'POST',
				data:{version:version},
				async:false,
				context: $("#upgradeInfoBox"),
				dataType: 'json',
				success:function(data) {
					(data.status == 'success')?bupgrade = true:bupgrade = false;	
					$(this).append(data.message);
				}
			});
		}
		if (!bupgrade)
			return bupgrade;
	}
	//解压升级包
	function doUnzip(){
		if (bupgrade == true) {
			bupgrade = false;
			$.ajax({
				url: "<?php echo $this->createAbsoluteUrl('upgradeClient/extractPackage');?>",
				type: 'POST',
				data:{version:version},
				async:false,
				context: $("#upgradeInfoBox"),
				dataType: 'json',
				success:function(data) {
					(data.status == 'success')?bupgrade = true:bupgrade = false;	
					$(this).append(data.message);
				}
			});
		}
		if (!bupgrade)
			return bupgrade;
	}
	
	//更新包覆盖
	function doOverride(){
		
		if (bupgrade == true) {
			bupgrade = false;
			$.ajax({
				url: "<?php echo $this->createAbsoluteUrl('upgradeClient/upgradeImplement');?>",
				type: 'POST',
				data:{version:version},
				async:false,
				context: $("#upgradeInfoBox"),
				dataType: 'json',
				success:function(data) {
					(data.status == 'success')?bupgrade = true:bupgrade = false;	
					$(this).append(data.message);
				}
			});
		}
		if (!bupgrade)
			return bupgrade;
	}
	
});
</script>