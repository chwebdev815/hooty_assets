var Subscriptions = require('../models/subscriptions');


async function subscribe(req, res) {

    console.log(req.body);

    let data = {
        user_id: req.body.user_id,
        email: req.body.email,
        phrases: req.body.phrases,
        outlets: req.body.outlets,
        hooty_id: req.body.hooty_id,
        name: req.body.name
    }

    newSubscription = new Subscriptions(data);

    newSubscription.save(function(err, result) {
        console.log(result);
    });

    res.send(200);

}

module.exports = subscribe;