var http = require('http');
var url  = require('url');
var qs   = require('querystring');

var writeOut = function (query, res) {
    res.write('hello ' + JSON.stringify(query.name) + '\n');
    res.write('your age is ' + JSON.stringify(query.age) + '\n');
    res.end();
}

http.createServer(function (req, res) {

    res.writeHead(200, {'Content-Type': 'text/plain; charset = utf-8'});
    if (req.method.toUpperCase() == 'POST') {
        var postData = "";
        req.addListener("data", function (data) {
            postData += data;
            console.log(postData);
        });
        req.addListener("end", function () {
            var query = qs.parse(postData);
            writeOut(query, res);
        });
    }

}).listen(8888, function () {
    console.log("listen on port 8888");
});