drawNews = (data, element) => {
    for (let i = 0; i < data.length; i++) {
        let container = element[i];
        let title = document.createElement("p");
        title.setAttribute("class", "col-11 col-sm-8 h5 title");
        let titleText = document.createTextNode(data[i][6]);
        title.appendChild(titleText);
        let date = document.createElement("span");
        date.setAttribute("class", "news-date col-10 col-sm-3");
        let node = document.createTextNode(data[i][4]);
        date.appendChild(node);
        let div = document.createElement("div");
        div.setAttribute("class", "news-img col-7 col-sm-5 col-lg-3");
        div.innerHTML = data[i]['img'];
        let short_description = document.createElement("p");
        short_description.setAttribute("class", "col-11 col-sm-8 mt-2 mt-lg-0 h6 content");
        let text = document.createTextNode(data[i][1] + '...');
        short_description.appendChild(text);
        let link = document.createElement("a");
        link.setAttribute("href", "New/" + data[i][0]);
        link.setAttribute("class", "nav-link  text-secondary col-8");
        node = document.createTextNode('Read more...');
        link.appendChild(node);
        let span = document.createElement("span");
        span.setAttribute("class", "col-3 views");
        node = document.createTextNode('Views:' + data[i][5]);
        span.appendChild(node);
        container.appendChild(title);
        container.appendChild(date);
        container.appendChild(div);
        container.appendChild(short_description);
        container.appendChild(link);
        container.appendChild(span);
    }
};