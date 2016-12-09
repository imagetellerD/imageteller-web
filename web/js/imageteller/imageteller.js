var DATA = {
	tags: {},
	descriptions: [],
}

function getActiveTab() {
	return $('.creative_tab').hasClass('active') ? 'creative' : 'poem';
}

function addTag(tag) {
	var html = [];
	html.push(
		'<span class="tag" text="' + tag.text + '">',
			'<p title="' + tag.text + '">' + tag.text + '</p>',
			'<i class="remove-icon"></i>',
		'</span>'
	);
	DATA.tags[tag.text] = tag;
	$('.tag_container').append(html.join('\n', html));
}

function getPoem() {
	$('.imageteller_display').text('少女蓄力中...')
	$.ajax({
		url: '/imageteller/get-poem',
		data: {
			tags: JSON.stringify(DATA.tags),
			descriptions: JSON.stringify(DATA.descriptions),
			poemTitle: $('.poem_title').val(),
		},
		success: function(ret) {
			if (ret && ret.errorCode == 0) {
				$('.imageteller_display').text(ret.data.poem);
			} else {
				alert(ret.message);
			}
		},
		error: function() {
			alert('呀，画译娘不见了！');
		}
	})

}

function getCreativeText() {
	$('.imageteller_display').text('别催我，我真的没偷懒...')
	$.ajax({
		url: '/imageteller/get-creative-text',
		data: {
			tags: JSON.stringify(DATA.tags),
			descriptions: JSON.stringify(DATA.descriptions),
		},
		success: function(ret) {
			if (ret.errorCode == 0) {
				$('.imageteller_display').empty().text(ret.data.text);
			} else {
				alert(ret.message);
			}
		},
		error: function() {
			alert('呀，画译娘不见了！');
		}
	})
}

function analyzeImage() {
	//var input = document.createElement('input');
	var input = document.getElementById('image_input');
	var isPoem = getActiveTab() == 'poem';
	var image = input.files[0];
	var formData = new FormData();
	formData.append('image', image);
	$.ajax({
		url: (isPoem ? '/imageteller/image-analyst?language=zh' : '/imageteller/image-analyst?language=en'),
		type: 'post',
		data: formData,
		processData: false,
		contentType: false,
		beforeSend: function(xhr) {
			console.log('uploading');
		},
		success: function(ret){
			if (ret.errorCode == 0) {
				DATA.descriptions = ret.data.descriptions;
				DATA.tags = {};
				$('.tag_container').empty();
				$.each(ret.data.tags, function(i,tag) {
					addTag(tag);
				})
				
			} else {
				if (ret.message) {
					alert(ret.message)
				}
				console.errog(ret.errorCode, ret.message);
			}
		},
		error: function() {
			alert('呀，画译娘不见了！');
		},
	});
}

$('body').on('click', '#upload_field', function(){
	$('#image_input').click();
}).on('change', '#image_input', function(){
	analyzeImage();
}).on('click', 'i.remove-icon', function(){
	var text = $(this).parent('.tag').attr('text');
	if (DATA.tags[text]) {
		delete DATA.tags[text];
	}
	$(this).parent('.tag').remove();
}).on('click', '.generate', function(){
	var isPoem = (getActiveTab() == 'poem');
	if (isPoem) {
		getPoem()
	} else {
		getCreativeText();
	}
}).on('click', '.switch_tab li', function(){
	if (!$(this).hasClass('active')) {
		$('.switch_tab li').removeClass('active');
		$(this).addClass('active');
		analyzeImage();
	}
}).on('keydown', '.tag_input', function(e) {
	if (e.keyCode == 13) {
		addTag({
			text: $(this).val(),
			confidence: 100,
		});
	}
});

$('document').ready(function(){
	addTag({text: '我', confidence: 100});
	addTag({text: '是', confidence: 100});
	addTag({text: '画译', confidence: 100});
})
