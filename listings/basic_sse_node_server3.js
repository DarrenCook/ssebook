var http = require("http");
var port = parseInt( process.argv[2] || 1234 );

http.createServer(function(request,response){
  console.log("Client connected:" + request.url);
  response.writeHead(200, { "Content-Type": "text/event-stream" });
  var timer = setInterval(function(){
    var content = "data:" + new Date().toISOString() + "\n\n";
    var b = response.write(content);
    if(!b)console.log("Data got queued in memory (content=" + content + ")");
    else console.log("Flushed! (content=" + content + ")");
    }, 1000);
  request.connection.on("close", function(){
    response.end();
    clearInterval(timer);
    console.log("Client closed connection. Aborting.");
    });
  }).listen(port);
console.log("Server running at http://localhost:" + port);
