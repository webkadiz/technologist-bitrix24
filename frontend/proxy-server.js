const express = require('express')
const app = express()
const https = require('https')
const fs = require('fs')
const axios = require('axios')

app.use(express.json())
app.use(express.urlencoded({ extended: true }))

app.all('*', (req, res) => {
  res.setHeader('Access-Control-Allow-Origin', '*')

  if (/\/technologist\//.test(req.url)) {
    console.log('on php server')
    axios(`http://technologist-php-lite${req.url}`)
      .then(({ data }) => {
        res.send(data)
      })
      .catch(err => console.log('error on php server'))

    return
  }

  console.log(req.method, req.url, req.body, req.params, req.query)
  axios(`http://localhost:4000${req.url}`)
    .then(({ data }) => {
      res.send(data)
    })
    .catch(err => console.log('error'))
})

const credential = {
  key: fs.readFileSync('encryption/server.key'),
  cert: fs.readFileSync('encryption/server.crt'),
  passphrase: 'webkadiz'
}

https.createServer(credential, app).listen(3100, () => {
  console.log('server is listening')
})
