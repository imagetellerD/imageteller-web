<?php
$this->registerJsFile('/js/imageteller/imageteller.js', ['depends' => '\app\assets\AppAsset']);
?>
<div class="main_top">
	<input type="file" id="image_input" name="image" style="display:none">
	<div id="upload_field" class="">
		<p>点我上传</p>
	</div>
	<div class="col-md-12 switch_tab">
		<ul class="" style="width:100px;height:30px">
			<li class="poem_tab"><a href="javascript:;">给我写诗！</a></li>
			<li class="creative_tab active"><a href="javascript:;">我要工作！</a></li>
		</ul>
	</div>
</div>
<div class="main_bottom">
	<div class="main_bottom_body" style="width:70%;margin:auto">
		<div class="col-md-12" style="padding-top:25px">
			<select class="poem_title col-md-5" style="background-color:#7882a0;height:35px">
				<?php foreach($poemTitles as $id => $name):?>
					<option value="<?= $id?>"><?= $name?></option>
				<?php endforeach;?>
			</select>
			<div class="col-md-7" style="padding-right:0px">
			<input type="text" class="tag_input" style="width:100%;background-color:#7882a0;border-color:#7882a0;height:35px"></input>
			</div>
		</div>
		<div class="tag_container col-md-12" style="padding-top:15px">
		</div>
		<div class="col-md-12" style="padding-top:25px;">
			<textarea class="imageteller_display" style="height:100px;width:100%"></textarea>
		</div>
		<div class="col-md-12" style="padding-top:15px">
			<button type="input" class="generate btn">生成诗歌</button>
		</div>
	</div>
</div>
<style>
#upload_field {
	cursor: pointer;
	width: 400px;
	height: 250px;
	margin: auto;
	background-color: aliceblue;
	margin-top: 80px;
}
.main_top {
	background-image: url('/css/analyze_image/main_up.png');
	min-height: 500px;
	background-repeat: no-repeat;
	background-size: cover;
	height: 60%;
	padding-top: 15px;
	position: relative;
}
.main_bottom {
	background-image: url('/css/analyze_image/main_bottom.png');
	min-height: 300px;
	margin-top: -15px;
	padding-top: 15px;
	background-repeat: no-repeat;
	background-size: cover;
	height:62%;
}
.switch_tab {
	position: absolute;
	bottom: 0px;
}
.switch_tab ul {
	width: 100px;
	height: 30px;
	padding-left: 0;
	margin-bottom: 0;
	border-bottom: 1px solid #ddd;
}
.switch_tab li {
	display: table-cell;
	float: none;
	width: 1%;
}
.switch_tab a {
	height:30px;
	width:150px;
	border-bottom: 1px solid #ddd;
	border-radius: 4px 4px 0 0;
	margin-right: 0;
}
.tag {
	width: 100px;
	height: 25px;
	background-color: #ff8586;
	display:inline-block;	
	position: relative;
	cursor: pointer;
}
.tag p {
	text-align: center;
	width: 80px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.remove-icon {
	background-image: url('/css/analyze_image/x.png');
	width: 12px;
	height: 12px;
	display: inline-block;
	position: absolute;
	top: 5px;
	right: 5px;
	cursor: pointer;
}
.generate {
	height:30px;
	width: 100px;
	position: absolute;
	right: 15px;	
}
textarea {
	resize: none;
	background-color: #7882a0;
	border-color: #7882a0;
}
</style>
