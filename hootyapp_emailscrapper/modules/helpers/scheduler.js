var Authors = require("../../models/authors");
var News = require("../../models/news");
var emailScrapper = require("../../controller/emailScrapping");
var later = require("later");
var async = require("async");
var request = require("request");
var proxy = require("./proxy");
var journalistMySqlDatabase = require("./journalistMySqlDatabase");

function scheduleScraping(text) {
  if (!text) {
    scrapeEmail();
  } else {
    var s = later.parse.text(text);
    later.setInterval(scrapeEmail, s);
  }
}

function scrapeEmail() {
  proxy
    .test()
    .then(function() {
      Authors.find({ $or: [{ scrapped: { $exists: false } }, { scrapped: false }] }, function(err, authors) {
        // console.log('NUMBER OF AUTHORS', authors.length)
        let functions = [];
        if (authors && authors.length) {
          // console.log('SCRAPPING STARTED');
          authors.forEach(function(author) {
            functions.push(function(callback) {
              let searchPhrase = author.name + " " + author.source_id + " email @";
              if (author.name) {
                emailScrapper({ name: author.name, outlet: author.source_name })
                  .then(function(email) {
                    if (email) {
                      Authors.updateOne({ _id: author._id }, { email: email, scrapped: true }, function() {});
                      let name = author.name.split(" ");
                      let savedAuthor = {
                        First_name: name[0],
                        Last_name: name.splice(1, 1).join(" "),
                        Domain_name: author.source_name,
                        email_address: email
                      };

                      journalistMySqlDatabase.findAndUpdateAuthor(savedAuthor, function(err, result) {
                        if (result) {
                          console.log("UPDATED - JOURNALIST RESULT JOURNALIST", result);
                          // console.log({ author_name: author.name, outlet: author.source_name }, result);
                          News.updateMany({ author_email_scraped: false, author_name: author.name, source_name: author.source_name }, { author_email_scraped: true, author_hooty_id: result }, function(err, r) {
                            console.log("UPDATE", err, r);
                            callback();
                          });

                          // setTimeout(function() {
                        } else {
                          callback();
                        }
                      });
                    } else {
                      Authors.updateOne({ _id: author._id }, { scrapped: true }, function() {});
                      callback();
                    }
                  })
                  .catch(function(e) {
                    callback(true);
                  });
              } else {
                callback();
              }
            });
          });
          async.series(functions, function(err, results) {
            if (err) {
              console.log("SCRAPING ERROR", err);
              setTimeout(function() {
                scrapeEmail();
              }, 2 * 60 * 1000);
            } else {
              // proxy.removeAllInstances();
              console.log("SCRAPPINNG COMPLETED !!");
              scheduleScraping("after 4 hours");
            }
          });
        } else {
          // proxy.removeAllInstances();
          console.log("NOTHING TO SCRAPE");
        }
      });
    })
    .catch(err => {
      setTimeout(function() {
        scrapeEmail();
      }, 2 * 60 * 1000);
    });
}

module.exports = scheduleScraping;
