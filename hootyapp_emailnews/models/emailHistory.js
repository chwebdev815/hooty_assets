const mongoose = require('mongoose');

const emailHistorySchema = new mongoose.Schema({
    newsId: String,
    email: String,
    newsDate: Date,
    date: Date
});

module.exports = mongoose.model('emailHistory', emailHistorySchema);