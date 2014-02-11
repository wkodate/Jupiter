var entryNum = 5;

google.load("feeds", "1");

function initialize() {
    var rss = rssList;
    var items = new Array();
    var rssCount = 0;

    // rss
    for (var i=0; i<rss.length; i++) {

        var feed = new google.feeds.Feed(rss[i]);
        feed.setNumEntries(entryNum);

        feed.load(function(result) {
            var container = document.getElementById('feed');
            if (!result.error) {
                var channelLink  = result.feed.link;
                var channelTitle = result.feed.title;
                var favicon      = "http://favicon.hatena.ne.jp/?url=" + channelLink;

                // item
                for (var j=0; j<result.feed.entries.length; j++) {
                    var entry = result.feed.entries[j];
                    var entryData = {
                        'itemLink'     : entry.link,
                        'itemTitle'    : entry.title,
                        'itemPubDate'  : entry.publishedDate,
                        'channelLink'  : channelLink,
                        'channelTitle' : channelTitle,
                        'favicon'      : favicon
                    };
                    items.push(entryData);
                }
            }
            rssCount++;

            if (rssCount != rss.length) {
                return;
            }


            // sort
            items.sort(
                function(a,b) {
                    var aDate = parseInt(new Date(a['itemPubDate'])/1000);
                    var bDate = parseInt(new Date(b['itemPubDate'])/1000);
                    if(aDate > bDate) return -1;
                    if(aDate < bDate) return 1;
                    return 0;
                }
            )

            // view
            for (var k=0; k<items.length; k++) {

                // item link
                var link = document.createElement("a");
                link.href = items[k].itemLink;
                link.target = '_brank';
                link.appendChild(document.createTextNode(items[k].itemTitle));
                var linkTd = document.createElement("td");
                linkTd.appendChild(link);

                // channel link
                var rssLink = document.createElement("a");
                rssLink.href = items[k].channelLink;
                rssLink.target = '_brank';
                rssLink.appendChild(document.createTextNode(items[k].channelTitle));
                var rssTd = document.createElement("td");
                rssTd.appendChild(rssLink);

                // date
                var dateTd = document.createElement("td");
                pubDate = getViewDate(items[k].itemPubDate);
                dateTd.appendChild(document.createTextNode(pubDate));

                var tr = document.createElement("tr");
                tr.appendChild(linkTd);
                tr.appendChild(rssTd);
                tr.appendChild(dateTd);
                container.appendChild(tr);

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
