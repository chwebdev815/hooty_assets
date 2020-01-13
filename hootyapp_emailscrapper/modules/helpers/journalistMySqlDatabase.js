var mysql = require("mysql");
var mysqlConnectionOption = {
  host: "157.230.180.198",
  user: "root",
  database: "app_hooty",
  password: "Hu/n9^Y$He2jQXdD"
};
var pool = mysql.createPool(mysqlConnectionOption);
var journalistMySqlDatabase = {};
var async = require("async");

journalistMySqlDatabase.saveAuthor = function(author, callback) {
  pool.getConnection(function(err, connection) {
    if (err) {
      console.log(err);
      callback(true);
      return;
    }
    var sql = `INSERT INTO journalists (First_name, Last_name, Domain_name, email_address) VALUES ('${author.First_name}', '${author.Last_name}', '${author.Domain_name}', '${author.email_address}')`;
    connection.query(sql, function(err, result) {
      console.log("RESULT INSERT", result);
      connection.release(); // always put connection back in pool after last query
      if (err) {
        console.log(err);
        callback(true);
        return;
      }
      callback(false, result.insertId);
    });
  });
};

journalistMySqlDatabase.deleteAuthors = function(News) {
  // console.log(author);
  pool.getConnection(function(err, connection) {
    if (err) {
      console.log(err);
      callback(true);
      return;
    }
    var select_sql = `SELECT * FROM journalists`;
    var functions = [];

    connection.query(select_sql, function(err, findResult) {
      console.log(err);
      if (err) {
        return;
      }
      findResult.forEach(function(journalist) {
        functions.push(function(cb) {
          if (journalist) {
            News.findOne({ author_hooty_id: journalist.id }, function(err, news) {
              if (news) {
                cb();
                console.log("FIRST NAME", journalist.First_name, news.author_name);
              } else {
                console.log("NOT FOUND", journalist.First_name);
                let delete_sql = "DELETE FROM journalists WHERE id=" + journalist.id;
                // console.log(delete_sql)
                connection.query(delete_sql, function(err, findResult) {
                  console.log(err, findResult);
                  cb();
                });
              }
            });
          } else {
            cb();
          }
        });
      });

      async.series(functions, function(err, result) {
        callback();
      });

      if (err) {
        console.log(err);
        connection.release();
        callback(true);
        return;
      }
    });
  });
};

journalistMySqlDatabase.findAndUpdateAuthor = function(author, callback) {
  // console.log(author);
  pool.getConnection(function(err, connection) {
    if (err) {
      console.log(err);
      callback(true);
      return;
    }
    var select_sql = `SELECT * FROM journalists WHERE First_name="${author.First_name}" AND Last_name="${author.Last_name}" AND Domain_name="${author.Domain_name}" `;
    var insert_sql = `INSERT INTO journalists (First_name, Last_name, Domain_name, email_address) VALUES ("${author.First_name}", "${author.Last_name}", "${author.Domain_name}", "${author.email_address}")`;

    // console.log(select_sql, "SELECT SQL!!!");

    connection.query(select_sql, function(err, findResult) {
      if (err) {
        console.log(err);
        connection.release();
        callback(true);
        return;
      }
      if (findResult && findResult.length && findResult[0] && findResult[0].id) {
        connection.release();
        callback(null, findResult[0].id);
        // console.log("FOUND", findResult[0].id);
      } else {
        connection.query(insert_sql, function(err, insertResult) {
          // console.log(insertResult)
          connection.release(); // always put connection back in pool after last query
          if (err) {
            console.log(err);
            callback(true);
            return;
          }
          console.log("INSERTED", insertResult.insertId);
          callback(false, insertResult.insertId);
        });
      }
    });
  });
};

module.exports = journalistMySqlDatabase;
