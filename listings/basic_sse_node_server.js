var http = require("http"), fs = require("fs");
var port = parseInt( process.argv[2] || 1234 );

http.createServer(function(request, response){
  console.log("Client connected:" + request.url);
  if(request.url!="/sse"){
    fs.readFile("basic_sse.html", function(err,file){
      response.writeHead(200, { 'Content-Type': 'text/html' });
      var s = file.toString();  //file is a buffer
      s = s.replace("basic_sse.php","sse");
      response.end(s);
      });
    return;
    }
  //Below is to handle SSE request. It never returns.
  response.writeHead(200, { "Content-Type": "text/event-stream" });
  var timer = setInterval(function(){
    var content = "data:" + new Date().toISOString() + "\n\n";
    var b = response.write(content);
    if(!b)console.log("Data got queued in memory (content=" + content + ")");
    else console.log("Flushed! (content=" + content + ")");
    },1000);
  request.connection.on("close", function(){
    response.end();
    clearInterval(timer);
    console.log("Client closed connection. Aborting.");
    });
  }).listen(port);
console.log("Server running at http://localhost:" + port);
