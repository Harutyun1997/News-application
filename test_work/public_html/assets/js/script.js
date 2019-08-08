let containerDiv = [];
let gap = 350 * 6;
let height = gap;
let load = 0;
let length = 10;
let day = 0;
let category_id = '';
let button_scrolling = document.getElementById('button_scrolling');
$("#all-container").css("min-height", $(document).height()-180);

async function ajax(data) {
    let response = await $.ajax({
        type: "POST",
        data: data,
        dataType: "html",
        url: "ajax.php",
        cache: false,
    });
    let result = await response;
    let error = result.indexOf('xdebug-error');
    if (error > 0) {
        throw new Error(response);
    }
    return JSON.parse(result);
}

async function loading() {
    let day = 0;
    let category_id = '';
    if (localStorage) {
        if (localStorage.getItem('day')) {
            day = Number(localStorage.getItem('day'));
        } else if (localStorage.getItem('category_id')) {
            category_id = localStorage.getItem('category_id');
        }
    }
    let data = {loading: 'loading', day: day, category_id: category_id};
    let result = await ajax(data);
    drawNavBar(result['categories']);
    drawDiv(result);
}

$(function () {
    loading();
    button_scrolling.style.opacity = "0";
});

async function getAllPage(object) {
    window.scrollTo(0, 0);
    $('#container').empty();
    let result = await  ajax(object);
    drawDiv(result);
}

async function getPosts(object) {
    let result = await  ajax(object);
    let contents = containerDiv.slice(object.start, object.start + length);
    drawNews(result['data'], contents);
}

window.onscroll = function () {
    let scrolled = window.pageYOffset || document.documentElement.scrollTop;
    if (scrolled > 9) {
        button_scrolling.style.opacity = "1";
    }
    else {
        button_scrolling.style.opacity = "0";
    }

    if (scrolled > height) {
        if (containerDiv.length >= load) {
            if (scrolled - height > gap) {
                let countLoad = Math.ceil(((scrolled - height) / gap)) / 2;
                let count = 0;
                let intervalId = setInterval(function () {

                    if (count === countLoad) {
                        clearInterval(intervalId);
                    }
                    count++;
                    load += length;
                    getPosts({start: load, day: day, category_id: category_id});
                }, 200);
            }
            height = scrolled + gap;
            load += length;
            getPosts({start: load, day: day, category_id: category_id});
        }
    }
};

async function getNewsDate(e) {
    switch (e.innerText) {
        case 'За сегодня':
            day = 1;
            break;
        case 'За 3 дня':
            day = 3;
            break;
        case 'За неделю':
            day = 7;
            break;
        case 'За месяц':
            day = 30;
            break;
    }
    $('#v-pills-tab a').removeAttr('class');
    $('#v-pills-tab a').attr('class', 'nav-link menu-categories');
    height = gap;
    load = 0;
    category_id = '';
    localStorage.clear();
    localStorage.setItem('day', day);
    getAllPage({day: day});
}

async function searchNewsCategory(element) {
    let category_id = element.getAttribute('data-id-category');
    day = 0;
    height = gap;
    load = 0;
    localStorage.clear();
    localStorage.setItem('category_id', category_id);
    getAllPage({category_id: category_id});
}

drawNavBar = (data) => {
    for (let i = 0; i < data.length; i++) {
        let element = document.getElementById("v-pills-tab");
        let container = document.createElement("a");
        container.setAttribute("class", "nav-link menu-categories");
        container.setAttribute("href", "#");
        container.setAttribute("data-toggle", "pill");
        container.setAttribute("role", "tab");
        container.setAttribute("data-id-category", data[i][0]);
        container.addEventListener('click', function () {
            searchNewsCategory(container)
        });
        let text = document.createTextNode(data[i][1]);
        container.appendChild(text);
        element.appendChild(container);
    }
};

drawDiv = (data) => {
    containerDiv = [];
    for (let i = 0; i < data['count']; i++) {
        let element = document.getElementById("container");
        let container = document.createElement("div");
        container.setAttribute("class", "news row mt-2");
        element.appendChild(container);
        containerDiv.push(container);
    }
    let contents = containerDiv.slice(0, length);
    drawNews(data['data'], contents);
};

$('.date-news').bind('click', function () {
    getNewsDate(this)
});