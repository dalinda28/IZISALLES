const express = require('express');
const router = express.Router();
var db = require('../database')

router.get('/reservations', (req, res) => {
    let sql = "SELECT * FROM reservation"
    let query = db.query(sql, (err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})

router.get('/reservations/:id', (req, res) => {
    let sql = "SELECT * FROM reservation WHERE reservation.id = ?"
    let query = db.query(sql,[req.params.id] ,(err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})

// Get reservations by user id
router.get('/reservations/user/:id', (req, res) => {
    let sql = "SELECT * FROM reservation WHERE reservation.id_user = ?"
    let query = db.query(sql,[req.params.id] ,(err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})

router.post('/reservations', (req, res) => {
    let data =  {
        id_user: req.body.id_user, 
        id_salle: req.body.id_salle, 
        date: req.body.date, 
        heure: req.body.heure
    };
    let sql1 = "SELECT * FROM reservation WHERE id_salle = ? AND date = ? AND heure = ?";
    db.query(sql1, [data.id_salle, data.date, data.heure], (err,results)=> {
        if(err){
            throw err
        }
        let reservations = JSON.parse(JSON.stringify(results));
        if (reservations.length === 0){
            let sql2 = "INSERT INTO reservation SET ?";
            db.query(sql2, data, (err,results)=> {
                if (err){
                    throw err
                }
                res.send("inserted")
            })
        }
        else {
            res.send("exists_reservation")
        }
    })

})
router.put('/reservations', (req, res) => {
    let id_reserv = req.body.id_reserv;
    let id_salle = req.body.id_salle;
    let date = req.body.date;
    let heure = req.body.heure;
    let sql1 = "SELECT * FROM reservation WHERE id_salle = ? AND date = ? AND heure = ?";
    let query = db.query(sql1, [id_salle, date, heure], (err, results) => {
        if (err) {
            throw err
        } else {
            let updateReservation = JSON.parse(JSON.stringify(results));
            if (updateReservation.length === 0) {
                let sql2 = "UPDATE reservation SET id_salle = ?, date = ?, heure = ? WHERE id = ?";
                db.query(sql2, [id_salle, date, heure, id_reserv], (err, results) => {
                    if (err) {
                        throw err
                    }else{
                        res.send("update");
                    }
                })
            }else{ 
                res.send("exists_reservation");
            }
        }
    })
})

router.delete('/reservations/:id', (req, res) => {
    let sql = "DELETE FROM reservation WHERE id = ?";
    db.query(sql, [req.params.id], (err,results)=> {
        if(err){
            throw err
        }
        res.send("ok")
    })
})

module.exports = router;