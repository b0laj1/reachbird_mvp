var Clarifai = require('clarifai');
var Promise = require('es6-promise').Promise;

var holder = document.getElementById('holder'),
    tests = {
        filereader: typeof FileReader != 'undefined',
        dnd: 'draggable' in document.createElement('span'),
        formdata: !!window.FormData,
        progress: "upload" in new XMLHttpRequest
    },
    support = {
        filereader: document.getElementById('filereader'),
        formdata: document.getElementById('formdata'),
        progress: document.getElementById('progress')
    },
    acceptedTypes = {
        'image/png': true,
        'image/jpeg': true,
        'image/gif': true
    },
    progress = document.getElementById('uploadprogress'),
    fileupload = document.getElementById('upload');

"filereader formdata progress".split(' ').forEach(function (api) {
    if (tests[api] === false) {
        support[api].className = 'fail';
    } else {
        // FFS. I could have done el.hidden = true, but IE doesn't support
        // hidden, so I tried to create a polyfill that would extend the
        // Element.prototype, but then IE10 doesn't even give me access
        // to the Element object. Brilliant.
        support[api].className = 'hidden';
    }
});

function previewfile(file) {
    if (tests.filereader === true && acceptedTypes[file.type] === true) {
        var reader = new FileReader();
        reader.onload = function (event) {
            var image = new Image();
            image.src = event.target.result;
            image.width = 250; // a fake resize
            image.id = "upload_instagram";
            document.getElementById("upload_instagram").remove();
            document.getElementById('upload_progress').remove();
            holder.appendChild(image);
        };

        reader.readAsDataURL(file);
    }  else {
        holder.innerHTML += '<p>Uploaded ' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
        console.log(file);
    }
}

function readfiles(files) {
    var formData = tests.formdata ? new FormData() : null;
    for (var i = 0; i < files.length; i++) {
        if (tests.formdata) formData.append('file', files[i]);
        previewfile(files[i]);
    }

    // now post a new XHR request
    if (tests.formdata) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload.php');
        xhr.onload = function(data) {
            progress.value = progress.innerHTML = 100;
        };

        xhr.onreadystatechange = function() {
            var status;
            if (xhr.readyState == 4) {
                status = xhr.status;
                if (status == 200) {
                    var server_response =  JSON.parse(xhr.response);
                    console.log(server_response);
                    if(server_response.status == 1) {
                        var image_url =  window.location + '/uploads/' + server_response.name;
                        console.log(image_url);
                        getTags(image_url)
                            .then(function(tags){
                                console.log('these are the tags from clarifai');
                                console.log(tags);
                                processTags(tags);

                            })
                            .catch(function(ex) {
                                console.log("error received from clarifai");
                                console.log(ex);
                            });
                    }

                } else {
                    console.log(status);
                }
            }
        };

        if (tests.progress) {
            xhr.upload.onprogress = function (event) {
                if (event.lengthComputable) {
                    var complete = (event.loaded / event.total * 100 | 0);
                    progress.value = progress.innerHTML = complete;
                }
            }
        }

        console.log(xhr.status);
        xhr.send(formData);

    }
}

if (tests.dnd) {
    holder.ondragover = function () { this.className = 'hover'; return false; };
    holder.ondragend = function () { this.className = ''; return false; };
    holder.ondrop = function (e) {
        this.className = '';
        e.preventDefault();
        readfiles(e.dataTransfer.files);
    }
} else {
    fileupload.className = 'hidden';
    fileupload.querySelector('input').onchange = function () {
        readfiles(this.files);
    };
}

if (tests.dnd) {
    holder.ondragover = function () { this.className = 'hover'; return false; };
    holder.ondragend = function () { this.className = ''; return false; };
    holder.ondrop = function (e) {
        this.className = '';
        e.preventDefault();
        readfiles(e.dataTransfer.files);
    }
} else {
    fileupload.className = 'hidden';
    fileupload.querySelector('input').onchange = function () {
        readfiles(this.files);
    };
}

function getTags (image_url) {
    console.log("getting tags");
    var params = {
        "client_id":"w_anlai3QV7IEYRyhSHzFVzr1h3Ylm-kGnBGu-xZ",
        "secret":"areoqBupvUUm8H69NF6KZHdR5fnYp1CyqPAuuELw"
    };
    var app = new Clarifai.App(params.client_id, params.secret);
console.log('created new clarifai app');
    var tags = [];
    return new Promise(function(resolve, reject) {
        app.models.predict(Clarifai.GENERAL_MODEL, image_url).then(
            function(response) {
                console.log('response is' + JSON.stringify(response));
                if(response.outputs[0].data.concepts) {
                    var x = response.data.outputs[0].data.concepts;
                    x.forEach(function (o, index , arr) {
                        if(o.name && o.value && o.value > 0.55) {
                            var data = {tag: o.name, probability: o.value};
                            tags.push(data);
                            if(index == (x.length - 1)) {
                                console.log('tags resolved');
                                console.log('tags');
                                resolve(tags);
                            }
                        }
                    });
                }
            },
            function(err) {
                console.log(err);
                reject(err);
            }
        );
    });
}

function processTags(tags) {
    var t = "";
    tags.forEach(function (tag, index , arr) {
        t += tag.name + ", ";
        if(index == (x.length - 1)) {
            //remove trailing comma
            t.replace(/(^,)|(,$)/g, "")
            tagsToTextArea(t);
        }
    });
}

function tagsToTextArea(tags) {
    var div = document.getElementById("image_tags_output");
    var input = document.createElement("textarea");
    document.getElementById('image_tags').remove();
    input.name = "image_tags";
    input.id = "image_tags";
    input.cols = "80";
    input.rows = "40";
    input.append(tags);
    div.appendChild(input);
}