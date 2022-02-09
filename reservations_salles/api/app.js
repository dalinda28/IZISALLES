var express = require('express');
var db = require('./database')
var cors = require('cors');

var app = express();
app.use(express.json());
app.use(cors());

//Add headers
app.use(function (req, res, next) {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
    res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
    res.setHeader('Access-Control-Allow-Credentials', true);

    next();
});

//USERS
app.get('/users', require('../api/controllers/users.js')) 

// SALLES
app.get('/salles', require('../api/controllers/salles.js')) 

// RESERVATIONS
app.get('/reservations', require('../api/controllers/reservations.js')) 


app.listen('3000', function(){
    console.log("server OK!")
})
