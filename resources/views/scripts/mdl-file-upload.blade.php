<script type="text/javascript">

	var fileInputTextDiv = document.getElementById('file_upload_text_div');
	var fileInput = document.getElementById('file_upload_btn');
	var fileInputText = document.getElementById('file_upload_text');
	fileInput.addEventListener('change', changeInputText);
	// fileInput.addEventListener('change', changeState);

	function changeInputText() {
	  var str = fileInput.value;
	  var i;
	  if (str.lastIndexOf('\\')) {
	    i = str.lastIndexOf('\\') + 1;
	  } else if (str.lastIndexOf('/')) {
	    i = str.lastIndexOf('/') + 1;
	  }
	  fileInputText.value = str.slice(i, str.length);

	  $('.profile_pic_label').css('color', 'rgba(0,0,0,.54)');
	  $('.profile_pic_label').text(fileInputText.value);

	}

	function changeState() {
	  if (fileInputText.value.length != 0) {
	    if (!fileInputTextDiv.classList.contains("is-focused")) {
	      fileInputTextDiv.classList.add('is-focused');
	    }
	  } else {
	    if (fileInputTextDiv.classList.contains("is-focused")) {
	      fileInputTextDiv.classList.remove('is-focused');
	    }
	  }
	}

</script>