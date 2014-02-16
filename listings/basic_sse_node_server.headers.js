var http = require('http'), fs = require("fs"),
  url = require('url');
var port = parseInt( process.argv[2] || 1234 );

http.createServer(function(request, response){
  var urlParts = url.parse(request.url, true);  //true gives us a parsed query string
  console.log("Client connected:" + JSON.stringify(urlParts) + "\n  " + JSON.stringify(request.headers));

  if(urlParts.pathname != "/sse"){
    fs.readFile("basic_sse_with_get.html", function(err,file){
      response.writeHead(200, { 'Content-Type': 'text/html' });
      var s = file.toString();  //file is a buffer
      s = s.replace("basic_sse.php","sse");
      response.end(s);
      });
    return;
    }  

  //Below is to handle SSE request. It never returns.

  var lastId = null;
  if(request.headers['last-event-id']){
    lastId = request.headers['last-event-id'];
    }
  else if(urlParts.query['lastId'])lastId = urlParts.query['lastId'];
  console.log("Last-Event-Id:" + lastId);

  response.writeHead(200, { 'Content-Type': 'text/event-stream' });
  var timer = setInterval(function(){
    var now = new Date();
    var content = "id:" + now.getTime() + "\ndata:" + now.toISOString() + "\n\n";
    var b = response.write(content);
    if(!b)console.log("Data got queued in memory (content="+content+")");
    else console.log("Flushed! (content="+content+")");
    },1000);
  request.connection.on('close',function(){
    response.end();
    clearInterval(timer);
    console.log("Client closed connection. Aborting.");
    });
  }).listen(port);
console.log("Server running at http://localhost:"+port);
