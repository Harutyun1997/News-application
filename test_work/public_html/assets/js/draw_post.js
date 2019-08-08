debugger;
let pathname = window.location.pathname;
let start = pathname.indexOf('New/') + 4;
let id = pathname.slice(start);
console.log(id);
$.ajax({
    type: "POST",
    data: {post_id: id},
    dataType: "html",
    url: "draw_new.php",
    cache: false,
    success: function (response) {
        let end = response.indexOf('<!DOCTYPE html>');
        response = response.slice(0, end);
        let data = JSON.parse(response);
        let container = document.getElementById("container");
        let title = document.createElement("span");
        title.setAttribute("class", "h4 col-11 title");
        let text = document.createTextNode(data[0][1]);
        title.appendChild(text);
        let date = document.createElement("span");
        date.setAttribute("class", "col-12 date");
        text = document.createTextNode(data[0][4]);
        date.appendChild(text);
        let content = document.createElement("p");
        content.setAttribute("class", "mt-4");
        content.innerHTML = data[0][2];
        container.appendChild(title);
        container.appendChild(date);
        container.appendChild(content);
    }
});