var Subscriptions = require('../models/subscriptions');


async function unsubscribe(req, res) {

    Subscriptions.remove({ hooty_id: req.body.id }, function(err) {
        console.log(err)
    });

    res.send(200);

}

module.exports = unsubscribe;