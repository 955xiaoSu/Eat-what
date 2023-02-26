// 监听 7000 端口（此方法现已弃用）

const http = require('http');
const { exec } = require('child_process');

http.createServer((req, res) => {
  exec('./eatwhat.sh', (err, stdout, stderr) => {
    if (err) {
      res.writeHead(500, { 'Content-Type': 'text/plain' });
      res.end('Error: ' + err.message);
    } else {
      res.writeHead(200, { 'Content-Type': 'text/plain' });
      res.end(stdout);
    }
  });
}).listen(7000);

