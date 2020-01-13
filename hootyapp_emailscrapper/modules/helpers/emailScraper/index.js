var filterer = require("./email-filterer.js");
var HtmlParser = require("./html-parser-utils.js");
var unique = require("array-unique");
let async = require("async");
let rp = require("request-promise");

function extractEmails(urls, levels = 1) {
  let emails = [];
  let currentLevel = 1;
  return new Promise(function(resolve, reject) {
    let functions = [];
    urls.forEach(function(url) {
      functions.push(function(callback) {
        rp({ url: url, maxRedirects: 3, timeout: 5000, headers: { "User-Agent": "request" } })
          .then(htmlString => {
            try {
              console.log("URL", url);
              let parser = new HtmlParser(htmlString, url);
              emails = emails.concat(parser.extractEmails());
              console.log(emails.join(", "));
              if (currentLevel < levels) {
                console.log("CURRENT LEVEL");
                let newLinks = parser.extractLinks();
                if (newLinks.length) {
                  extractEmails(newLinks, levels).then(function() {
                    callback();
                  });
                } else {
                  callback();
                }
                currentLevel++;
              } else {
                callback();
              }
            } catch (e) {
              callback();
            }
          })
          .catch(err => {
            callback();
          });
      });
    });

    async.series(functions, function(url, callback) {
      resolve(unique(emails));
    });
  });
}

module.exports = extractEmails;
