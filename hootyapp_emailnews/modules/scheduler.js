var later = require("later");
require("dotenv").config();
var ses = require("node-ses");
var client = ses.createClient({ key: process.env.SES_KEY, secret: process.env.SES_SECRET, amazon: "https://email.us-west-2.amazonaws.com" });
var emailParser = require("./emailParser");
var Subscriptions = require("../models/subscriptions");
var EmailHistory = require("../models/emailHistory");
var News = require("../models/news");
var moment = require("moment");
var async = require("async");
var request = require("request");

function scheduler(text) {
  if (!text) {
    sendEmail();
  } else {
    var s = later.parse.text(text);
    later.setInterval(sendEmail, s);
    var occurrences = later.schedule(s).next(10);
  }
}

function getNews(data) {
  return new Promise(async function(resolve, reject) {
    try {
      var limit = 10;
      var dateQuery = {
        $gte: moment()
          .subtract(5, "days")
          .startOf("day")
          .toDate(),
        $lte: moment()
          .subtract(1, "days")
          .endOf("day")
          .toDate()
      };
      let history = await EmailHistory.find({ newsDate: dateQuery, email: data.email });

      let newsIds = history.map(function(h) {
        return h.newsId;
      });

      var query = { _id: { $nin: newsIds }, $text: { $search: data.phrases }, date: dateQuery };

      if (data.outlets && data.outlets.length) {
        query.source_id = { $in: data.outlets };
      }

      query.author_email_scraped = true;

      console.log("QUERY", query);

      News.find(query)
        .limit(10)
        .exec(function(err, docs) {
          if (docs && docs.length) {
            docs.forEach(function(doc) {
              let emailHistory = new EmailHistory({
                newsId: doc._id,
                email: data.email,
                newsDate: doc.date,
                date: new Date()
              });
              emailHistory.save(function(err, eH) {});
            });
            resolve(docs);
          } else {
            reject();
          }
        });
    } catch (e) {
      console.log(e);
      reject(e);
    }
  });
}

function sendEmail() {
  Subscriptions.find(function(err, subscriptions) {
    let functions = [];
    subscriptions.forEach(function(subscription) {
      functions.push(function(callback) {
        getNews(subscription)
          .then(async function(docs) {
            console.log("DOCS", docs);
            let html = await emailParser(docs, subscription);
            client.sendEmail(
              {
                to: subscription.email,
                from: "Hooty<hi@hooty.co>",
                subject: "News jacking alerts for you to pitch -" + subscription.phrases,
                message: html,
                altText: "Click link"
              },
              function(err, data, res) {
                // console.log(err, data, res);
                request.post({ url: process.env.HOOTY_URL + "/news-alerts/last-alert", json: { id: subscription.hooty_id, date: new Date() } }, function(err, httpResponse, body) {
                  console.log(err, httpResponse, body);
                });
                callback();
              }
            );
          })
          .catch(function(err) {
            console.log("ERROR", err);
            callback();
          });
      });
    });
    async.series(functions, function() {
      console.log("DONE SENDING EMAILS!!");
    });
  });
}

module.exports = scheduler;
