var handlebars = require('handlebars');
var fs = require('fs');
var path = require('path');
var appDir = path.dirname(require.main.filename);
var News = require('../models/news');
require('dotenv').config();

function parseEmail(docs, subscription) {
    console.log('SUBSCRIPTION', subscription);
    return new Promise(function(resolve, reject) {
        var source = fs.readFileSync(__dirname + '/../templates/news.html', 'utf8');
        var template = handlebars.compile(source);
        var html = template({ hooty_url: process.env.HOOTY_URL, docs: docs, subscription: subscription });
        resolve(html);
    })
}

module.exports = parseEmail;