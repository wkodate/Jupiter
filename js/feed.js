var entryCount = 3;

var rssList = new Array(
    'http://blog.livedoor.jp/yakiusoku/index.rdf',
    'http://absurd.blogo.jp/index.rdf',
    'http://blog.livedoor.jp/nanjstu/index.rdf'
);

google.load("feeds", "1");

function initialize() {
    var rss = rssList;

    for (var i=0; i<rss.length; i++) {
        var feed = new google.feeds.Feed(rss[i]);
        feed.setNumEntries(entryCount);
        feed.load(function(result) {
            if (!result.error) {
                var container = document.getElementById('feed');
                // 取得
                var channelLink = result.feed.link;
                var favicon = "http://favicon.hatena.ne.jp/?url=" + channelLink;
                var channelTitle = result.feed.title;

                for (var i=0; i<result.feed.entries.length; i++) {
                    var entry = result.feed.entries[i];

                    // item link
                    var link = document.createElement("a");
                    link.href = entry.link;
                    link.appendChild(document.createTextNode(entry.title));
                    var linkTd = document.createElement("td");
                    linkTd.appendChild(link);

                    // channel link
                    var rssLink = document.createElement("a");
                    rssLink.appendChild(document.createTextNode(channelTitle));
                    var rssTd = document.createElement("td");
                    rssTd.appendChild(rssLink);

                    // date
                    var dateTd = document.createElement("td");
                    dateTd.appendChild(document.createTextNode(entry.publishedDate));
                    console.log(entry.publishedDate);

                    var tr = document.createElement("tr");
                    tr.appendChild(linkTd);
                    tr.appendChild(rssTd);
                    tr.appendChild(dateTd);

                    container.appendChild(tr);
                }
                
            }
        });
    }

}

google.setOnLoadCallback(initialize);
