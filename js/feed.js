var entryCount = 3;

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
                    rssLink.href = channelLink;
                    rssLink.appendChild(document.createTextNode(channelTitle));
                    var rssTd = document.createElement("td");
                    rssTd.appendChild(rssLink);

                    // date
                    var dateTd = document.createElement("td");
                    pubDate = getViewDate(entry.publishedDate);
                    dateTd.appendChild(document.createTextNode(pubDate));

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

function getViewDate(pDate) {

    var dayArray = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    var d = new Date(pDate);
    var year    = d.getFullYear();
    var month   = d.getMonth()+1;
    var date    = d.getDate();
    var dayNum  = d.getDay();
    var day     = dayArray[dayNum];
    var hours   = ("0"+d.getHours()).slice(-2);
    var minutes = ("0"+d.getMinutes()).slice(-2)

    return year+'/'+month+'/'+date+'('+day+')'+' '+hours+':'+minutes;

}

google.setOnLoadCallback(initialize);
