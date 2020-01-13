var Authors = require('../models/authors');
var request = require('request');
var score = require('string-score');
var GoogleSearchScraper = require('phantom-google-search-scraper');

function matchAuthors() {
    getNews();
    // getmySql();
}

async function getNews() {
    var authors = await Authors.find({});
    var name = authors.forEach((author) => {
        var name = author.name;
        var call = author.name + " " + author.source_id;
        if (call !== null) {
            getmySql(call);
            // googlescrapper(call)
        }
    })
}

function getmySql(call) {
    request.post({ url: process.env.HOOTY_URL + '/email-search', json: { search: call } }, function(err, httpResponse, body) {

        if (body && body.length && body[0].First_name && body[0].Last_name) {
            let call2 = body[0].First_name + ' ' + body[0].Last_name;
            // console.log('The search term - ' + call + ' the results -' + body[0].First_name + ' ' + body[0].Last_name);
            var scores = score(call2, call, 0.5)
            if (scores > 0.9) {
                console.log('better than most', call, call2);
            } else {
                console.log('worse than .2');
            }


        }
    })
}

module.exports = matchAuthors;