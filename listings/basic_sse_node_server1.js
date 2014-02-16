var http = require("http");

http.createServer(function(request,response){
  response.writeHead(200,
    { "Content-Type": "text/plain" }
    );
  var content="Hello World\n";
  response.end(content);
  }).listen(1234);
