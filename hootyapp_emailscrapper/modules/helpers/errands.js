var Authors = require("../../models/authors");
var News = require("../../models/news");
var request = require("request");
var async = require("async");
var _ = require("underscore");
var journalistMySqlDatabase = require("./journalistMySqlDatabase");

var mysqlConnectionOption = {
  host: "192.186.198.224",
  user: "app_hooty",
  database: "app_hooty",
  password: "default@123"
};
var mysql = require("mysql");
var csv = require("csvtojson");
var pool = mysql.createPool(mysqlConnectionOption);
// var csvFilePath = require('../../csv/')
// '../../csv/first_import.csv'
// console.log();
var csvFilePath = __dirname + "/../../csv/first_import.csv";

function errands() {
  let functions = [];
  // News.find({ author_email_scraped: false }, function(err, news) {
  //   let length = news.length;
  //   news.forEach(n => {
  //     functions.push(function(callback) {
  //       console.log({ name: n.author_name, source_name: n.source_name, email: { $exists: true }, scrapped: true }, "NEWS ID>>", n._id, length--);
  //       Authors.findOne({ name: n.author_name, source_name: n.source_name, email: { $exists: true }, scrapped: true }, function(err, author) {
  //         console.log("AUTHOR", author && author._id);
  //         if (author) {
  //           let name = author.name.split(" ");
  //           let savedAuthor = {
  //             First_name: name[0],
  //             Last_name: name.splice(1, 1).join(" "),
  //             Domain_name: author.source_name,
  //             email_address: author.email
  //           };
  //           journalistMySqlDatabase.findAndUpdateAuthor(savedAuthor, function(err, result) {
  //             // console.log("RESULT >>>", result);
  //             try {
  //               if (result) {
  //                 console.log("RESULT JOURNALIST", result);
  //                 console.log({ author_name: author.name, outlet: author.source_name }, result);
  //                 News.update({ _id: n._id }, { author_email_scraped: true, author_hooty_id: result }, function(err, r) {
  //                   console.log("UPDATE", err, r);
  //                   callback();
  //                 });
  //               } else {
  //                 console.log("ERR", err);
  //                 callback();
  //               }
  //             } catch (e) {
  //               console.log("EEE", e);
  //               callback();
  //             }
  //           });
  //         } else {
  //           console.log("ELSE!!");
  //           callback();
  //         }
  //       });
  //     });
  //   });
  //   async.series(functions, function(err, results) {
  //     console.log("DONE!!");
  //   });
  // });

  // Authors.find()
  // journalistMySqlDatabase.findAndUpdateAuthor

  News.find({ author_email_scraped: false, author_hooty_id: { $exists: false } }, function(err, news) {
    let newsCount = news.length;
    console.log(newsCount);
    news.forEach(function(n) {
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
              if (err) {
                callback();
              } else {
                News.updateOne({ _id: n._id }, { author_email_scraped: true, author_hooty_id: result }, function(err, r) {
                  console.log("RESULT", n._id, result, r);
                  callback();
                });
              }
            });
          } else {
            console.log("NO AUTHOR!");
            callback();
          }
        });
      });
    });
    async.series(functions, function(err, results) {});
  });
  // Authors.find({ scrapped: true, email: { $exists: true } }, function(err, authors) {
  //   authors.forEach(function(author) {
  //     News.updateMany(
  //       {
  //         author_email_scraped: false,
  //         author_name: author.name,
  //         source_id: author.source_id
  //       },
  //       {
  //         $set: {
  //           author_email_scraped: true
  //         }
  //       },
  //       function(err, result) {
  //         console.log(err, result);
  //       }
  //     );
  //   });
  // });

  // csv()
  //     .fromFile(csvFilePath).then((data) => {
  //         pool.getConnection(function(err, connection) {
  //             data.forEach(function(post) {
  //                 // console.log(post);
  //                 connection.query('SELECT * FROM journalists WHERE email_address="' + post.email_address + '" AND First_name="' + post.First_name + '" AND Last_name="' + post.Last_name + '"', function(err, result) {
  //                     if (!result) {
  //                         var query = connection.query('INSERT INTO journalists SET ?', post, function(error, results, fields) {
  //                             console.log(results);
  //                         });
  //                     }
  //                 })

  //             })
  //         });

  //     })

  // Authors.find({ scrapped: true, email:{$exists:true} }, function(err, authors) {
  //     // console.log(authors)
  //     authors.forEach(function(author) {
  //         functions.push(function(callback) {
  //             // console.log(author.scrapped);
  //             let name = author.name.split(' ');

  //             let savedAuthor = {
  //                 First_name: name[0],
  //                 Last_name: name.splice(1, 1).join(' '),
  //                 Domain_name: author.source_name,
  //                 email_address: author.email
  //             }

  //             request.post({ url: 'http://staging.hooty.co/save-journalist', json: savedAuthor }, function(err, httpResponse, body) {
  //                 console.log(body, err);
  //                 if (body) {
  //                     News.updateMany({ author_id: author._id }, { author_email_scraped: true, author_hooty_id: body.id }, function() {
  //                         setTimeout(function() {
  //                             callback();
  //                         }, 15000)
  //                     });
  //                 } else {
  //                     callback();
  //                 }
  //             })

  //         })
  //     })

  //     async.series(functions, function() {
  //         console.log('DONE!!!');
  //     })
  // })
  // try {

  // var obj = [
  //     { _id: 'aa', author_id: 'bbb', source_id: 'ccc' },
  //     { _id: 'xx', author_id: 'bbb', source_id: 'ccc' },
  //     { _id: 'yy', author_id: 'ddd', source_id: 'xxx' },
  //     { _id: 'zz', author_id: 'AAA', source_id: 'xxx' },
  // ]

  // console.log(_.uniq(obj, function(o) {
  //     return o.author_id && o.source_id;
  // }))

  // Authors.find({ scrapped: true, email: { $exists: true } }, function(err, authors) {
  //     authors.forEach(function(author) {
  //         News.updateMany({ author_name: author.name, source_id: author.source_id }, { $set: { author_email_scraped: true } }, function(err, news) {
  //             console.log(author.name, err, news);
  //         })
  //     })
  // })

  // News.find({author_id:{$exists:false}}, function(err, news) {
  //     try{
  //     // console.log(news);
  //     news.forEach(function(n) {
  //         // console.log(n.author_name, n.source_id);

  //         // console.log(n.author_name);

  //         Authors.findOne({ name: n.author_name, source_id: n.source_id }, function(err, author) {
  //             if(author){
  //                 if(n.author_email_scraped){
  //                     Authors.findOneAndUpdate({_id:author._id},{$set:{scrapped:true}}, function(err, result){
  //                         // console.log(err, result)
  //                     })
  //                 }

  //                 News.findOneAndUpdate({_id:n._id},{$set:{author_id: author._id}}, function(err, result){
  //                     // console.log(err, result)
  //                 });
  //             }
  //             // if (author) {
  //             //     News.update({ _id: n._id }, { $set: { author_id: author._id } }, function(err, result) {
  //             //         console.log(result);
  //             //     });
  //             // } else {

  //             //     let newAuthor = new Authors({
  //             //         name: n.author_name,
  //             //         source_id: n.source_id,
  //             //         source_name: n.source_name
  //             //     });

  //             //     newAuthor.save(function(err, athr) {
  //             //         News.update({ _id: n._id }, { $set: { author_id: athr._id } }, function(err, result) {
  //             //             console.log(result);
  //             //         });
  //             //     });

  //             // }
  //         })
  //     })
  // }catch(E){
  //     console.log(E);
  // }
  // })

  // journalistMySqlDatabase.deleteAuthors(News);

  // News.find({ author_email_scraped: true, author_hooty_id: { $exists: false } }, function(err, news) {
  //     // console.log(news);
  //     news.forEach(function(news) {
  //         functions.push(function(callback) {
  //             News.findOne({ _id: news._id }, function(err, news) {
  //                 if (news.author_email_scraped && news.author_hooty_id) {
  //                     return callback();
  //                 }
  //                 Authors.findOne({ name: news.author_name, source_id: news.source_id }, function(err, author) {
  //                     if (author) {
  //                         let name = author.name.split(' ');
  //                         let savedAuthor = {
  //                             First_name: name[0],
  //                             Last_name: name.splice(1, 1).join(' '),
  //                             Domain_name: author.source_name,
  //                             email_address: author.email
  //                         }
  //                         journalistMySqlDatabase.findAndUpdateAuthor(savedAuthor, function(err, author_hooty_id) {
  //                             News.updateMany({ _id: news._id }, { $set: { author_email_scraped: true, author_hooty_id: author_hooty_id } }, function(err, result) {
  //                                 callback();
  //                             });
  //                         })
  //                     } else {
  //                         callback()
  //                     }
  //                 })
  //             })
  //         })
  //     })

  //     async.series(functions, function() {
  //         console.log('DONE!!!');
  //         journalistMySqlDatabase.deleteAuthors(News);
  //     })
  // });
}

module.exports = errands;
