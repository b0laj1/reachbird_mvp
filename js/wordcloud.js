/*function wordcloud(input, width, height) {
    var fill = d3.scale.category20();

    d3.layout.cloud()
        .size([width, height])
        .words(input)
        .rotate(function() {
            return ~~(Math.random() * 2) * 90;
        })
        .font("Impact")
        .fontSize(function(d) {
            return d.size;
        })
        .on("end", drawSkillCloud)
        .start();

// Finally implement `drawSkillCloud`, which performs the D3 drawing:

    // apply D3.js drawing API
    function drawSkillCloud(words) {
        d3.select("#cloud").append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + ~~(width / 2) + "," + ~~(height / 2) + ")")
            .selectAll("text")
            .data(words)
            .enter().append("text")
            .style("font-size", function(d) {
                return d.size + "px";
            })
            .style("-webkit-touch-callout", "none")
            .style("-webkit-user-select", "none")
            .style("-khtml-user-select", "none")
            .style("-moz-user-select", "none")
            .style("-ms-user-select", "none")
            .style("user-select", "none")
            .style("cursor", "default")
            .style("font-family", "Impact")
            .style("fill", function(d, i) {
                return fill(i);
            })
            .attr("text-anchor", "middle")
            .attr("transform", function(d) {
                return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
            })
            .text(function(d) {
                return d.text;
            });
    }

// set the viewbox to content bounding box (zooming in on the content, effectively trimming whitespace)

    var svg = document.getElementsByTagName("svg")[0];
    var bbox = svg.getBBox();
    var viewBox = [bbox.x, bbox.y, bbox.width, bbox.height].join(" ");
    svg.setAttribute("viewBox", viewBox);
}*/

function wordcloud(input, width, height) {
    var fill = d3.scale.category20();

    d3.layout.cloud().size([width, height])
        .words(input.map(function(d) {
            return {text: d.word, size: d.weight};
        }))
        .padding(5)
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d) { return d.size; })
        .on("end", draw)
        .start();

}

function draw(words) {
    d3.select("#cloud").append("svg")
        .attr("width", 300)
        .attr("height", 300)
        .append("g")
        .attr("transform", "translate(150,150)")
        .selectAll("text")
        .data(words)
        .enter().append("text")
        .style("font-size", function(d) { return d.size + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return fill(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {

            return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });
}
function drawUpdate(words){
    d3.layout.cloud().size([500, 500])
        .words(words)
        .padding(5)
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d) { return d.size; })
        .start();


    d3.select("svg")
        .selectAll("g")
        .attr("transform", "translate(150,150)")
        .selectAll("text")
        .data(words).enter().append("text")
        .style("font-size", function(d) { return d.size + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return fill(i); })

        .attr("transform", function(d) {

            return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });



}

setInterval(function () {
    var d_new = data;
    d_new.push({word:randomWord(),weight:randomWeight()});

    drawUpdate(d_new.map(function(d) {
        return {text: d.word, size: d.weight};
    }));
}, 1500);

function randomWord() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
function randomWeight(){
    var r = Math.round(Math.random() * 100);
    return r;
}