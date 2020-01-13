var Scraper = require("email-crawler");

var searchEngineScraper = require('../modules/helpers/searchEngineScraper');
var async = require('async');
var request = require('request');
var emailScrapper = require('../modules/helpers/emailScraper');
var stringScore = require('../modules/helpers/stringSimilarity');
var puppeteer = require('puppeteer');

// let urls = []


function emailScrapping(searchTerm) {

    return new Promise(function(resolve, reject) {

        var options = {
            query: searchTerm.name + '' + searchTerm.outlet + ' @ email',
            limit: 10
        };


        searchEngineScraper.search(options, function(err, urls, meta) {
            // console.log('ERR', err);
            if (err) {
                console.log('ERROR SEARCH ENGINE SCRAPPER', err);
                reject();
            } else {
                emailScrapper(urls).then(function(emails) {
                    
                    let emailMatch;

                    if(emails && emails.length){
                        emailMatch = stringScore.findBestMatch(searchTerm.name, emails);
                    }
                    
                    if (emailMatch && emailMatch.bestMatch && emailMatch.bestMatch.rating >= 0.3) {
                        console.log(searchTerm.name, emailMatch.bestMatch)
                        resolve(emailMatch.bestMatch.target);
                    } else {
                        resolve()
                    }
                }).catch(function(err) {
                    console.log('ERROR EMAIL SCRAPPER', err);
                    resolve();
                })
            }
        });


    })
}


module.exports = emailScrapping;