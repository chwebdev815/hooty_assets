const mongoose = require('mongoose');


const subscriptionsSchema = new mongoose.Schema({
    user_id: Number,
    email: String,
    name: String,
    phrases: String,
    outlets: [String],
    hooty_id: Number
});

module.exports = mongoose.model('Subscriptions', subscriptionsSchema);