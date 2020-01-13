var express = require('express');
var subscribe = require('../controller/subscribe');
var unSubscribe = require('../controller/unsubscribe');
var Authors = require('../models/authors');
var _ = require('underscore');

var router = express.Router();


router.post('/subscribe', subscribe);
router.post('/unsubscribe', unSubscribe);


module.exports = router;