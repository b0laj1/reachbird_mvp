<?php
if(! $_SESSION) {
    session_start();
}
unset($_SESSION['user_id']);
require 'vendor/autoload.php';

?>
<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">
<link href="emoji-picker-gh-pages/lib/css/nanoscroller.css" rel="stylesheet">
<link href="emoji-picker-gh-pages/lib/css/emoji.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="de/css/style.css">
<link rel="stylesheet" type="text/css" href="css/overlay.css">
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


<div style="float: left; width: 100%;">
    <div id="target">
    </div>
    <div style="float:left; margin-top: 20px; margin-left: 3%; width: 90%;" >
        <div id="select_influencer">
            <?php echo \Reachbird\Services\views::generateInfluencerSelect(); ?>
        </div>
        <div id="user_dashboard" style="width: 100%">
            <iframe src="user.php" id="dashboard_iframe" scrolling="no" frameBorder="0" style="width: 100%;" onload="this.style.height=this.contentDocument.body.scrollHeight +'px';"></iframe>
        </div>
        <div style="width: 100%;"><hr /></div>

        <form id="engagement_form" method="post" name="form">

            <div style="float: left;" id="holder">
                <img id="upload_instagram"  src="Images/Upload.PNG" class="image" style="position:bottom;  max-height: 200px; max-width: 280px; margin: 10px;" />
                <p id="upload_progress">Upload progress: <progress id="uploadprogress" min="0" max="100" value="0">0</progress></p>
            </div>
            <p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
            <p id="filereader" class="hidden">File API & FileReader API not supported</p>
            <p id="formdata" class="hidden">XHR2's FormData is not supported</p>
            <p id="progress" class="hidden">XHR2's upload progress isn't supported</p>


            <div style="float: left; margin-left: 30px; width: 60%;">
                <label>Caption:</label>
                <p class="lead emoji-picker-container">
                    <textarea class="form-control textarea-control"  id="caption" style="height: 100px;" placeholder="Write your caption here                                                     " data-emojiable="true" data-emoji-input="unicode"></textarea>
                </p>
                <label id="image_tags_label" class="hidden">Image Tags:</label>
                <p id="image_tags_output"><textarea id="image_tags" name="image_tags" class="hidden"></textarea> </p>

                <input style="margin-top:5%;" type="button" disabled id="submit_button" value="Analyze" onclick="submitForAnalysis();">
            </div>

            <input type="file" accept="image/*" onchange="loadFile(event)" style="visibility:hidden;" id="de">
        </form>
    </div>


    <div style="float:left;margin-left: 3%;width: 90%; margin-bottom: 50px">
        <label>Predicted Engagement:</label>
        <input style="width: 100%;" disabled="disabled" type="text" name="suggestion" id="eng">

        <label>Predicted Likes:</label>
        <input style="width: 100%;" disabled="disabled" type="text" name="predicted_engagement" id="like">

        <label>Predicted Comments:</label>
        <input style="width: 100%;" disabled="disabled" type="text" name="predicted_engagement" id="comm">
    </div>

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
  <script type="text/javascript" src="js/overlay.js"></script>


    <script>
        function submitForAnalysis() {
            var influencer = $('#influencer_select :selected').text();

            var tags = $('#image_tags').val();
            var caption = $('#caption').val();
            var image_tags = tags.substring(0, tags.length - 1);

            var url = "http://139.162.187.90:8000/predictor/";
            var predicate = b64EncodeUnicode(influencer + "/" + caption  + "/" + image_tags);

            $('#target').addClass('loading');
            $.ajax({
                type: "POST",
                url: 'get_engagement.php',
                data: {url: url + predicate + "/"},

                success: function(response) {
                    $('#target').loadingOverlay('remove');
                    var res = JSON.parse(response);
                    if(res.status ==1) {
                        console.log(res.text);
                        var engagement = res.text.x_eng[0] * 100;
                        var comments = res.text.x_comm[0];
                        var likes = res.text.x_likes[0];
                        $('#eng').val(engagement.toFixed(2) + "%");
                        $('#comm').val(comments.toFixed(2));
                        $('#like').val(likes.toFixed(2));
                    }
                },
                error: function (err) {
                    alert("some error occurred" + JSON.stringify(err));
                    $('#target').loadingOverlay('remove');
                }
            });

        }
        function getInfluencerData(influencer) {
            var id = influencer.value;
            if(id) {
                $('#target').addClass('loading');
                $.ajax({
                    type: "POST",
                    url: 'set_user.php',
                    data: {user_id: id},
                    success: function(response) {

                        document.getElementById('dashboard_iframe').src = document.getElementById('dashboard_iframe').src;
                        checkIframeLoaded('dashboard_iframe');
                    },
                    error: function (err) {
                        alert("some error occurred" + err);
                        $('#target').loadingOverlay('remove');
                    }
                });
            }

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

        function checkIframeLoaded(id) {
            // Get a handle to the iframe element
            var iframe = document.getElementById(id);
            var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

            // Check if loading is complete
            if (  iframeDoc.readyState  == 'complete' ) {
                //iframe.contentWindow.alert("Hello");
                iframe.contentWindow.onload = function(){

                };
                // The loading is complete, call the function we want executed once the iframe is loaded
                afterLoading();
                return;
            }

            // If we are here, it is not loaded. Set things up so we check   the status again in 100 milliseconds
            window.setTimeout('checkIframeLoaded();', 100);
        }

        function afterLoading(){
            $('#target').loadingOverlay('remove');
        }

        function b64EncodeUnicode(str) {
            return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
        }

    </script>

</body>
</html>




