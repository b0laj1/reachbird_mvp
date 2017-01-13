<!DOCTYPE html>
<html>



<head>




<link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">

<link href="emoji-picker-gh-pages/lib/css/nanoscroller.css" rel="stylesheet">
<link href="emoji-picker-gh-pages/lib/css/emoji.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">









<header><img src="Images/reachbird-logo.png" ></img></header>





</head>



<body>


<h1 >Reachbird Advisor</h1>



<div style="float: center; margin-right: 30%;" >

<form method="post" name="form">

<div style="float: center;">
<img id="image" onclick="openfilechooser()" src="Images/upload.png" class="image" style="position:bottom;  height: 300px; width: 300px margin: 10px;"></img>
</div>


<div style="float: center; margin-right: 30%;">
<label>Caption:</label>
<input type="textarea" name="caption" id="caption" data-emojiable="true" data-emoji-input="unicode" >
<label>Hashtags:</label>
<input type="text" name="caption" id="hashtag">
<label></label>
<input type="button" id="submit" value="Test" onclick="action()">
</div>

<input type="file" accept="image/*" onchange="loadFile(event)" style="visibility:hidden;" id="de">

</form>
</div>





<div style="float: center; margin-right: 30%;">
<label>Engagement:</label>
<input type="text" name="caption" id="eng">

<label>Suggestion:</label>
<input type="text" name="caption" id="sug">

<label>Possible Engagement:</label>
<input type="text" name="caption" id="posseng">
</div>























	<script src="jquery-3.1.1.js"></script>
  <script src="emoji-picker-gh-pages/lib/js/nanoscroller.min.js"></script>
  <script src="emoji-picker-gh-pages/lib/js/tether.min.js"></script>
  <script src="emoji-picker-gh-pages/lib/js/config.js"></script>
  <script src="emoji-picker-gh-pages/lib/js/util.js"></script>
  <script src="emoji-picker-gh-pages/lib/js/jquery.emojiarea.js"></script>
  <script src="emoji-picker-gh-pages/lib/js/emoji-picker.js"></script>




</body>



</html>




 <script>
    $(function() {
      // Initializes and creates emoji set from sprite sheet
      window.emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: 'emoji-picker-gh-pages/lib/img/',
        popupButtonClasses: 'fa fa-smile-o'
      });
      // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
      // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
      // It can be called as many times as necessary; previously converted input fields will not be converted again
      window.emojiPicker.discover();
    });


function openfilechooser(){
	var a = document.getElementById("de");
	de.click();
}

  var loadFile = function(event) {
    var output = document.getElementById('image');
    output.src = URL.createObjectURL(event.target.files[0]);
  };


 






















</script>