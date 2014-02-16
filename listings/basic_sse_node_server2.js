var http = require("http");

http.createServer(function(request, response){
  response.writeHead(200, { "Content-Type": "text/event-stream" });
  setInterval(function(){
    var content = "data:" +
      new Date().toISOString() + "\n\n";
    response.write(content);
    }, 1000);
  }).listen(1234);
