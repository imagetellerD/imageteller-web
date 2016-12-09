<?php
$this->registerJsFile('/js/imageteller/imageteller.js', ['depends' => '\app\assets\AppAsset']);
?>
<div class="main_top">
	<input type="file" id="image_input" name="image" style="display:none">
	<div id="upload_field" class="">
		<p>点我上传</p>
	</div>
	<div class="col-md-12 switch_tab">
		<ul class="nav nav-tabs">
			<li class="poem_tab active"><a href="javascript:;">写诗在这里</a></li>
			<li class="creative_tab"><a href="javascript:;">创意看这边</a></li>
		</ul>
	</div>
</div>
<div class="main_bottom">
	<div class="main_bottom_body">
		<div class="creative_tag_input_field col-md-12 hide" style="padding-top:25px">
			<input type="text" class="tag_input" placeholder="回车输入tag..."></input>
		</div>
		<div class="poem_tag_input_field col-md-12" style="padding-top:25px">
			<select class="poem_title col-md-5">
				<?php foreach($poemTitles as $id => $name):?>
					<option value="<?= $id?>"><?= $name?></option>
				<?php endforeach;?>
			</select>
			<div class="col-md-7" style="padding-right:0px">
			<input type="text" class="tag_input poem_tag_input" placeholder="回车输入tag..."></input>
			</div>
		</div>
		<div class="tag_container col-md-12" style="padding-top:15px">
		</div>
		<div class="col-md-12" style="padding-top:25px;">
			<textarea class="imageteller_display"></textarea>
		</div>
		<div class="col-md-12" style="padding-top:15px">
			<button type="input" class="generate btn">生成诗歌</button>
		</div>
	</div>
</div>
<style>
#upload_field {
	cursor: pointer;
	width: 40%;
	height: 50%;
	margin: auto;
	background-color: #7882a0;
	margin-top: 15%;
	border-radius: 10px;
	background-size: cover;
	text-align: center;
	padding: 13%;
}
#upload_field p {
	
}
#upload_field:hover {
	background-color: #97c8fb;
}
.main_top {
	background-image: url('/css/analyze_image/main_up.png');
	background-repeat: no-repeat;
	background-size: cover;
	height: 59%;
	padding-top: 15px;
	position: relative;
}
.main_bottom {
	background-image: url('/css/analyze_image/main_bottom.png');
	margin-top: -1%;
	padding-top: 1%;
	background-repeat: no-repeat;
	background-size: cover;
	height:42%;
	min-height:450px;
}
.main_bottom_body {
	width:70%;
	margin:auto
}
.switch_tab {
	position: absolute;
	bottom: 0px;
	padding: 0px;
}
.switch_tab ul.nav {
	padding-left: 60px;
	    border-bottom: 1px solid #313c4f;
}
.switch_tab ul.nav li {
	margin-right: 10px;
	background-color: #7882a0;
	border-radius: 9px 9px 0 0;
}
.switch_tab ul.nav li a {
	    border-radius: 9px 9px 0 0;
}
.switch_tab ul.nav li a:hover {
	background-color: #313c4f;
	border: 1px solid #313c4f;
}
.switch_tab ul.nav li.active a {
	background-color: #313c4f;
	border: 1px solid #313c4f;
}
/*
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
*/
.poem_title {
	background-color:#7882a0;
	border-color: #7882a0;
	height:35px;
	border-radius: 4px;
}
.tag_input {
	width:100%;
	background-color:#7882a0;
	border-color:#7882a0;
	height:36px;
	border-radius: 5px;
	margin-top: -2px;
	box-shadow: 0 0 15px rgb(120, 130, 160);
}
.tag {
	width: 100px;
	height: 25px;
	background-color: #ff8586;
	display:inline-block;	
	position: relative;
	cursor: pointer;
	margin-right:5px;
	border-radius: 4px;
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
	background-color: #7882a0;
	line-height: 15px;
}
.generate:hover {
	background-color: #97c8fb;
}
textarea.imageteller_display {
	resize: none;
	background-color: #7882a0;
	border-color: #7882a0;
	border-radius: 4px;
	height:200px;
	width:100%;
	box-shadow: 0 0 20px rgb(120, 130, 160);
}
input::-ms-input-placeholder{text-align: center;} 
input::-webkit-input-placeholder{text-align: center;} 
</style>
