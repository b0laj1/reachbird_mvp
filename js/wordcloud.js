function wordcloud(words, width, height) {
    maxSize = d3.max(words, function(d) {
        return d.size;
    });
    minSize = d3.min(words, function(d) {
        return d.size;
    });

    var fontScale = d3.scale.linear() // scale algo which is used to map the domain to the range
        .domain([minSize, maxSize]) //set domain which will be mapped to the range values
        .range([5, 40]); // set min/max font size (so no matter what the size of the highest word it will be set to 40 in this case)


    var fill = d3.scale.category20();
    d3.layout.cloud().size([width, height])
        .words(words)
        .padding(5)
        .rotate(function() {
            return ~~(Math.random() * 2) * 90;
        })
        .font("Impact")
        .fontSize(function(d) {
            return fontScale(d.size)
        }) // the d3 scale function is used here
        .on("end", draw)
        .start();


    function draw(words) {
        d3.select("#cloud").append("svg")
            .attr("width", 300)
            .attr("height", 300)
            .append("g")
            .attr("transform", "translate(150,150)")
            .selectAll("text")
            .data(words)
            .enter().append("text")
            .style("font-size", function(d) {
                return d.size + "px";
            })
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
}
