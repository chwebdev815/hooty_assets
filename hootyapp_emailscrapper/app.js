var createError = require("http-errors");
var express = require("express");
var path = require("path");
var cookieParser = require("cookie-parser");
var logger = require("morgan");
const mongoose = require("mongoose");
var async = require("async");
var scheduleScraping = require("./modules/helpers/scheduler");
var updateNewsArticles = require("./modules/helpers/updateNewsArticles");
var errands = require("./modules/helpers/errands");
require("dotenv").config();

var app = express();
// view engine setup

app.use(logger("dev"));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.set("port", process.env.PORT);

app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

mongoose.Promise = global.Promise;

mongoose
  .connect(process.env.DB_HOST)
  .then(function() {
    console.log("CONNECTED!!");
    scheduleScraping();
    updateNewsArticles();
    // scheduleScraping('every 1 minute');
    // console.log("CONNECTED TO DB!!");
    // errands();
  })
  .catch(err => {
    console.log(err);
  });

const request = require("request");

//SCRAPPER

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get("env") === "development" ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render("error");
});

module.exports = app;
