var mysql = require('mysql');

var connexion = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'reservations_salles',
    port: '8888',
    socketPath : '/Applications/MAMP/tmp/mysql/mysql.sock'
}) 

connexion.connect(function(error){
    if (error){
        throw error;
    }
    else{
        console.log("connexion a la BDD réussie");
    }
})

module.exports = connexion;
