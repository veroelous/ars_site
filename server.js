/**
 * Arquivo de entrada para hospedagens cPanel com "Setup Node.js App" (Phusion Passenger),
 * como a Host4. Em outros ambientes use `npm start`.
 *
 * Passos no servidor: npm install → npm run build → reiniciar a aplicação.
 */
const { createServer } = require("node:http");
const next = require("next");

const port = Number(process.env.PORT) || 3000;
const app = next({ dev: false, dir: __dirname });
const handle = app.getRequestHandler();

app
  .prepare()
  .then(() => {
    createServer((req, res) => handle(req, res)).listen(port, () => {
      console.log(`[ars] site no ar na porta ${port}`);
    });
  })
  .catch((err) => {
    console.error("[ars] falha ao iniciar", err);
    process.exit(1);
  });
