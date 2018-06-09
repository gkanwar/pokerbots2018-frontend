// Javascript for using Plotly to display money graphs
function hashCode(str) { // java String#hashCode
    var hash = 0;
    for (var i = 0; i < str.length; i++) {
	hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return hash;
}

function strToRGB(str) {
    var hash = hashCode(str + 'thisisalongsalttototallymix');
    var r = (hash & 0xff0000) >> 16;
    var g = (hash & 0x00ff00) >> 8;
    var b = (hash & 0x0000ff);
    console.log('hashing ' + str + ' to ' + [r,g,b]);
    return 'rgb(' + r + ',' + g + ',' + b + ')';
}

window.onload = function() {
    var layout = {
	margin: {t:0, b:0, l:0, r:0}
    };
    var plotElts = document.getElementsByClassName('money-plot');
    for (var i = 0; i < plotElts.length; i++) {
	var dataSrc = plotElts[i].getAttribute('data-src');
        var data = eval(dataSrc);
	for (var j = 0; j < data.length; j++) {
	    data[j].mode = 'lines';
	    data[j].line = {
		color: strToRGB(data[j].name)
	    };
	}
	Plotly.plot(plotElts[i], data, layout);
    }
};