
var Clarifai = require('./../node_modules/clarifai/sdk/clarifai-latest');

var app = new Clarifai.App('client_id', 'secret');


function getTags(image_url) {
    app.models.predict(Clarifai.GENERAL_MODEL, image_url).then(
        function(response) {
            if(response.data.outputs[0].data.concepts) {
                var x = response.data.outputs[0].data.concepts;
                x.forEach(function (o, index , arr) {
                    if(o.name && o.value && o.value > 0.55) {
                        var data = {tag: o.name, probability: o.value};
                        tags.push(data);
                        if(index == (x.length - 1)) {
                            //write the tags to the post object

                        }
                    }
                });
            }
        },
        function(err) {
            console.error(err);
            writeImageTagsToPost(p, tags);
        }
    );
}