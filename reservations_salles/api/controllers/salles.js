const express = require('express');
const router = express.Router();
var mysql = require('mysql');
var db = require('../database')

router.get('/salles', (req, res) => {
    let sql = "SELECT * FROM salle"
    let query = db.query(sql, (err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})
//
router.get('/salles/:id', (req, res) => {
    let sql = "SELECT * FROM salle WHERE salle.id = ?"
    let query = db.query(sql,[req.params.id] ,(err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})

module.exports = router;