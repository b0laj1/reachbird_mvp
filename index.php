<!DOCTYPE html>
<html>



<head>




<link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">

<link href="emoji-picker-gh-pages/lib/css/nanoscroller.css" rel="stylesheet">
<link href="emoji-picker-gh-pages/lib/css/emoji.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">




<link rel="stylesheet" type="text/css" href="de/css/style.css">




<header><img src="Images/reachbird-logo.png" ></img></header>





</head>



<body>
<style>
    #holder { border: 10px dashed #ccc; width: 300px; min-height: 300px; margin: 20px auto;}
    #holder.hover { border: 10px dashed #0c0; }
    #holder img { display: block; margin: 10px auto; }
    #holder p { margin: 10px; font-size: 14px; }
    progress { width: 100%; }
    progress:after { content: '%'; }
    .fail { background: #c00; padding: 2px; color: #fff; }
    .hidden { display: none !important;}
</style>

<h1 >Reachbird Advisor</h1>



<div style="float:left; margin-left: 3%;" >

<form id="engagement_form" method="post" name="form">

<div style="float: left;" id="holder">
<img id="upload_instagram"  src="Images/Upload.PNG" class="image" style="position:bottom;  max-height: 200px; max-width: 280px; margin: 10px;" />
    <p>Upload progress: <progress id="uploadprogress" min="0" max="100" value="0">0</progress></p>
</div>
    <p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
    <p id="filereader" class="hidden">File API & FileReader API not supported</p>
    <p id="formdata" class="hidden">XHR2's FormData is not supported</p>
    <p id="progress" class="hidden">XHR2's upload progress isn't supported</p>


<div style="float: left; margin-left: 10%;">
<label>Caption:</label>
<p class="lead emoji-picker-container">
            <textarea class="form-control textarea-control" rows="3" placeholder="Write your caption here                                                     " data-emojiable="true" data-emoji-input="unicode"></textarea>
          </p>
    <p id="image_tags_output"><textarea id="image_tags" name="image_tags" class="hidden"></textarea> </p>

<input style="margin-top:5%;" type="submit" id="submit" value="Test" onclick="action()">
</div>

<input type="file" accept="image/*" onchange="loadFile(event)" style="visibility:hidden;" id="de">
</form>
</div>





<div style="margin-right: 20%;margin-top:30%; margin-left: 3%;">
<label>Engagement:</label>
<input style="width: 70%;" type="text" name="caption" id="eng">

<label>Suggestion:</label>
<input style="width: 70%;" type="text" name="caption" id="sug">

<label>Possible Engagement:</label>
<input style="width: 70%;" type="text" name="caption" id="posseng">
</div>


  <script src="jquery-3.1.1.js"></script>
  <script src="bundle.js"></script>
  <script src="js/upload_image.js"></script>
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