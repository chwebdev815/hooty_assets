var News = require('../models/news');
var async = require('async');
var saveAuthor = require('./saveAuthor');

function saveNews(articles) {
    return new Promise(function(resolve, reject) {
        try {
            let functions = [];
            let newsOutput = []
                // console.log(articles.length);
            articles.forEach(function(article) {
                functions.push(function(callback) {
                    News.findOne({ title: article.title, source_id: article.source_id }, function(err, news) {

                        console.log(article.source_id + ' - News Saved');
                        if (!news) {
                            let savedNews = new News(article);
                            savedNews.save(function(err, nws) {
                                console.log(err, article.source_id + ' - News Saved');
                                newsOutput.push(nws);
                                callback();
                            });
                        } else {
                            callback();
                        }
                    });
                })
            })

            async.series(functions, function(err, result) {
                resolve(newsOutput)
            })
        } catch (e) {
            console.log(e);
        }

    })

}

async function iterateNews(response) {

    var articles = response.map((article) => {
        let author_name = article.author_name ? article.author_name : article.author;
        return {
            title: article.title,
            image: article.image ? article.image : article.urlToImage,
            content: article.content,
            date: article.date ? article.date : article.publishedAt,
            url: article.url,
            source_name: article.source_name ? article.source_name : article.source.name,
            source_id: article.source_id ? article.source_id : article.source.id,
            author_name: author_name ? author_name.replace(/^\s+|\s+$/g, "") : null
        }
    });

    articles = articles.filter((article) => {
        return article.author_name !== null && article.author_name !== undefined;
    })

    try {
        let savedNews = await saveNews(articles);
        let savedAuthors = saveAuthor(savedNews);
    } catch (e) {
        console.log(e);
    }

    return;

}


module.exports = iterateNews;