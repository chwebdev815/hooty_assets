var Authors = require("../../models/authors");
var News = require("../../models/news");
var async = require("async");
var journalistMySqlDatabase = require("./journalistMySqlDatabase");

function scheduleUpdateNewsArticles(text) {
  if (!text) {
    updateNewsArticles();
  } else {
    var s = later.parse.text(text);
    later.setInterval(scrapeEmail, s);
  }
}

function updateNewsArticles() {
  let functions = [];
  News.find({ author_email_scraped: false }, function(err, news) {
    let length = news.length;
    news.forEach(n => {
      functions.push(function(callback) {
        Authors.findOne({ name: n.author_name, source_name: n.source_name, email: { $exists: true }, scrapped: true }, function(err, author) {
          if (author) {
            let name = author.name.split(" ");
            let savedAuthor = {
              First_name: name[0],
              Last_name: name.splice(1, 1).join(" "),
              Domain_name: author.source_name,
              email_address: author.email
            };
            journalistMySqlDatabase.findAndUpdateAuthor(savedAuthor, function(err, result) {
              try {
                if (result) {
                  News.update({ _id: n._id }, { author_email_scraped: true, author_hooty_id: result }, function(err, r) {
                    console.log("UPDATE", n._id, err, r);
                    callback();
                  });
                } else {
                  console.log("ERR", err);
                  callback();
                }
              } catch (e) {
                console.log("EEE", e);
                callback();
              }
            });
          } else {
            console.log("ELSE!!");
            callback();
          }
        });
      });
    });
    async.series(functions, function(err, results) {
      console.log("DONE UPDATING NEWS");
      scheduleUpdateNewsArticles("after 4 hours");
    });
  });
}

module.exports = scheduleUpdateNewsArticles;
