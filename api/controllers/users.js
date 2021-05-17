const express = require('express');
const router = express.Router();
var db = require('../database')

router.get('/users', (req, res) => {
    let sql = "SELECT * FROM user"
    let query = db.query(sql, (err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})

router.get('/users/:id', (req, res) => {
    let sql = "SELECT * FROM user WHERE user.id = ?"
    let query = db.query(sql,[req.params.id] ,(err,results)=> {
        if(err){
            throw err
        }
        res.send(results)
    })
})

router.post('/users', (req, res) => {
    let data = {
        nom: req.body.nom,
        prenom: req.body.prenom,
        profil: req.body.profil,
        mail: req.body.mail,
        mdp: req.body.mdp
    };
    let mails = [];
    let sql = "SELECT user.mail FROM user";

    let query = db.query(sql, (err, results) => {

        if (err) {
            throw err;
        }else{
            Object.keys(results).forEach(function (key) {
                var row = results[key];
                mails.push(row.mail);
            });
            if (!mails.includes(data.mail)) {
                let sql = "INSERT INTO user SET ?";
                let query = db.query(sql, data, (err, results) => {
                    if (err) {
                        throw err
                    }
                    res.send("inserted")
                })
            }
            else {
                res.send("exists_user_same_mail")
            }
        }
    })
})

router.put('/users/:id', (req, res) => {
    let nom = req.body.nom;
    let prenom = req.body.prenom;
    let profil = req.body.profil;
    let mail = req.body.mail;
    let mdp = req.body.mdp;
    let id = req.params.id;
    let mails = [];
    let sql1 = "SELECT user.mail FROM user WHERE id <> ?";
    let query = db.query(sql1,[id], (err, results) => {

        if (err) {
            throw err;
        } else {
            Object.keys(results).forEach(function (key) {
                var row = results[key];
                mails.push(row.mail);
            });
            if (!mails.includes(mail)) {
                let sql2 = "UPDATE user SET nom = ?, prenom = ?, profil = ?, mail = ?, mdp = ? WHERE id = ?";
                db.query(sql2, [nom, prenom, profil, mail, mdp, id], (err, results) => {
                    if (err) {
                        throw err
                    }
                    res.send("updated")
                })
            }else {
                res.send("exists_user_same_mail");
            }
        }
    })
})

router.delete('/users/:id', (req, res) => {
    let sql = "DELETE FROM user WHERE id = ?";
    db.query(sql, [req.params.id], (err,results)=> {
        if(err){
            throw err
        }
        res.send("ok")
    })
})

module.exports = router;