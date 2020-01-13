var express = require('express');
var News = require('../models/news');
var Authors = require('../models/authors');
var _ = require('underscore');

var router = express.Router();


router.post('/subscribe', async(req, res) => {
    try {
        res.send(articles);
    } catch (e) {
        console.log(e);
    }
})


module.exports = router;