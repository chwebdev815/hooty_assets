var request = require("request");
var cheerio = require("cheerio");
var url = require("url");
var proxy = require("./proxy");
var async = require("async");
var isUrl = require("is-url");

var hosts = [
  {
    lang: "hl",
    lang_default: "en",
    query: "q",
    url: "www.google.com/search",
    linkSelector: "a"
  },
  {
    lang: "hl",
    query: "q",
    url: "www.bing.com/search",
    linkSelector: "#b_results a"
  },
  {
    lang: "hl",
    query: "q",
    url: "duckduckgo.com/html/",
    linkSelector: "#links a.result__a"
  }
];

var session = request.defaults({ jar: true });

function prepareParams(options, host) {
  var url = host.url;
  var params = {};

  for (var key in options) {
    if (host[key]) {
      params[host[key]] = options[key] || host[key + "_default"];
    }
  }

  var requestTemplate = {
    uri: "https://" + url,
    qs: params,
    followRedirect: false,
    // URL of Scrapoxy
    proxy: "http://sp70cb7d78:Delta$50@gate.smartproxy.com:7000",
    // HTTPS over HTTP
    tunnel: false
  };

  return requestTemplate;
}

function getPage(params) {
  return new Promise(function(resolve, reject) {
    session.get(params, function(err, res) {
      if (err) return reject(err);
      console.log(params.uri, res.statusCode);
      if (res.statusCode !== 200) {
        //   proxy.removeInstance(res.headers["x-cache-proxyname"]);
        let err = { code: res.statusCode };
        return reject(err);
      }

      resolve(res.body);
    });
  });
}

function passAsUrl(url) {
  let exclusions = ["google.com", "bing.com", "duckduckgo.com"];
  let pass = true;
  exclusions.forEach(function(text) {
    if (url.indexOf(text) > -1) pass = false;
  });
  return pass;
}

function extractResults(body, linkSelector) {
  var results = [];
  var $ = cheerio.load(body);

  $(linkSelector).each(function(i, elem) {
    var item = {};
    item["url"] = elem.attribs.href;
    // console.log(item);
    item.url = item.url.replace("/url?q=", "");
    if (passAsUrl(item.url)) results.push(item);
  });

  return results;
}

async function getUrls(options, index = 0) {
  try {
    let host = hosts[index];

    if (host) {
      var params = prepareParams(options, host);

      var body = await getPage(params);

      var results = extractResults(body, host.linkSelector);

      var urls = results.reduce(function(filtered, result) {
        if (result.url && result.url !== "#" && isUrl(result.url)) {
          filtered.push(result.url);
        }
        return filtered;
      }, []);

      console.log(urls);

      return urls;
    } else {
      return;
    }
  } catch (e) {
    console.log("EEEE", e);
    var i = index + 1;
    return getUrls(options, i);
  }
}

async function search(options, callback) {
  let urls = await getUrls(options);
  if (urls) {
    callback(null, urls);
  } else {
    callback({ message: "ERROR!" });
  }
}

module.exports.search = search;
