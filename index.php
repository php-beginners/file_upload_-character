<!doctype html>
<html>
<head>
</head>
<body>
	<p>uploaded.txt -&gt; <?= file_get_contents('uploaded.txt') ?></p>
	<form method="post" action="./index.php">
		<input type="file"   name="test"   value="hoge" id="file"/>
		<button type="button" id="button" disabled="disabled"> Submit character </button>
	</form>
	<p>content -&gt; <span id="content"></span></p>
	<hr/>
	<code><pre><?= file_get_contents('README.md') ?></pre></code>
</body>
</html>
<script>
// ...
function got_content(content){
	document.getElementById('content').innerText = content;
	document.getElementById('file').disabled     = true;
	document.getElementById('button').disabled   = false;
}

//	...
function put_content(size){
	//	...
	var content   = document.getElementById('content').innerText;
	var character = content.charAt(size);

	//	...
	if( character ){
		console.log(character);
	}else{
		return;
	}

	//	...
	fetch('api.php?content='+character)
	.then(response => response.json())
	.then(function(json){
		console.log(json.result.size);
	});
}

//	...
document.querySelector('#file').addEventListener('change', function(){
	//	...
	if(!this.value ){
		return;
	}

	//	...
	let file = this.files[0];
	console.log( file.name, file.type, file.size, file.lastModified );

	//	Specifies size of content to load.
	let temp = file.slice(0, file.size, file.type);

	//	...
	let file_reader = new FileReader();
	file_reader.onloadend = function(e){
		if(file_reader.error){
			return;
		}
		got_content(file_reader.result);
	};
	file_reader.readAsText(temp);
});

//	...
document.querySelector('#button').addEventListener('click', function(){
	fetch('api.php')
	.then(response => response.json())
	.then(function(json){
		put_content(json.result.size);
	});
});
</script>
