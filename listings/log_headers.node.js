var http = require("http");

http.createServer(function(request,response){
  console.log(request.method+" "+request.url);
  console.log(request.headers);

  if(request.url!="/sse"){
    response.end("<html>"+
      "<head><title>Logging test</title></head>"+
      "<body><script>"+
      "var es = new EventSource('/sse');"+
      "</script></body></html>\n");
    return;
    }

  response.writeHead(200,
    { "Content-Type": "text/plain" });
  response.end();
  }).listen(1234);
