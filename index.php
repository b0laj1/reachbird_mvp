<?php
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html>



<head>
<link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">
<link href="emoji-picker-gh-pages/lib/css/nanoscroller.css" rel="stylesheet">
<link href="emoji-picker-gh-pages/lib/css/emoji.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="de/css/style.css">
</head>



<body style="margin-left: 20px;">
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
<header>
    <div class="header" style="margin-top: 20px; display:table-cell; vertical-align:middle; max-height: 100px;">
        <div class="logo" style="float: left;"><img src="Images/reachbird-logo.png" style="max-height: 100px;" /></div>
        <div class="name" style="padding-left: 30px; padding-top: 30px; float: left; "> <h2 style="text-align: center; ">Reachbird Advisor</h2></div>
    </div>

</header>


<div style="float: left; width: 50%;">
    <div style="float:left; margin-top: 20px; margin-left: 3%;" >
        <?php echo \Reachbird\Services\views::generateInfluencerSelect(); ?>
        <form id="engagement_form" method="post" name="form">

            <div style="float: left;" id="holder">
                <img id="upload_instagram"  src="Images/Upload.PNG" class="image" style="position:bottom;  max-height: 200px; max-width: 280px; margin: 10px;" />
                <p id="upload_progress">Upload progress: <progress id="uploadprogress" min="0" max="100" value="0">0</progress></p>
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
                <label id="image_tags_label" class="hidden">Image Tags:</label>
                <p id="image_tags_output"><textarea id="image_tags" name="image_tags" class="hidden"></textarea> </p>

                <input style="margin-top:5%;" type="submit" id="submit" value="Test" onclick="action()">
            </div>

            <input type="file" accept="image/*" onchange="loadFile(event)" style="visibility:hidden;" id="de">
        </form>
    </div>


    <div style="float:left;margin-left: 3%;width: 90%; margin-bottom: 50px">
        <label>Engagement:</label>
        <input style="width: 100%;" type="text" name="engagement" id="eng">

        <label>Suggestion:</label>
        <input style="width: 100%;" type="text" name="suggestion" id="sug">

        <label>Possible Engagement:</label>
        <input style="width: 100%;" type="text" name="predicted_engagement" id="posseng">
    </div>
</div>
<div style="float: right; width: 50%;">
    blah here
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


    <script>
        function getInfluencerData(influencer) {
            var id = influencer.value;
            alert(id);
        }

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

    </script>

</body>
</html>




