let proxy = {};

var request = require("request");

proxy.test = function() {
  console.log("TESTING PROXY!!!");
  return new Promise(function(resolve, reject) {
    try {
      request(
        {
          uri: "http://google.com/search/q=test",
          followRedirect: false,
          proxy: "http://sp70cb7d78:Delta$50@gate.smartproxy.com:7000",
          tunnel: false
        },
        function(err, res) {
          console.log(err);
          if (err) {
            reject();
            return;
          }

          console.log("PROXY TEST STATUS >> ", res.statusCode);

          // console.log(res.statusCode);
          if (res.statusCode !== 301) {
            reject();
          } else {
            resolve();
          }
        }
      );
    } catch (e) {
      console.log(e);
    }
  });
};

proxy.removeAllInstances = function() {
  const opts = {
    method: "GET",
    url: "http://localhost:8889/api/instances",
    headers: {
      Authorization: new Buffer(process.env.COMMANDER_PASSWORD).toString("base64")
    }
  };

  request(opts, (err, res, body) => {
    if (err) return console.log("Error: ", err);

    console.log("Status: %d\n\n", res.statusCode);

    const instances = JSON.parse(body);

    instances.forEach(function(instance) {
      proxy.removeInstance(instance.name);
    });
  });
};

proxy.removeInstance = function(instanceName) {
  return new Promise(function(resolve, reject) {
    const opts = {
      method: "POST",
      url: "http://localhost:8889/api/instances/stop",
      json: {
        name: instanceName
      },
      headers: {
        Authorization: new Buffer(process.env.COMMANDER_PASSWORD).toString("base64")
      }
    };

    request(opts, (err, res, body) => {
      if (err) return console.log("Error: ", err);

      console.log("Status: %d\n\n", res.statusCode);

      console.log(body);
      resolve(body);
    });
  });
};

module.exports = proxy;
