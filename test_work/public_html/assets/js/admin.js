$('#navbarNav').after(
    '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal" data-whatever="">Create new post</button>'
);

$('#create-new-post').submit(function (e) {
    e.preventDefault();
    save();
});

drawNews = (data, element) => {
    for (let i = 0; i < data.length; i++) {
        let container = element[i];
        let title = document.createElement("p");
        title.setAttribute("class", "col-7 h5 title");
        let titleText = document.createTextNode(data[i][6]);
        title.appendChild(titleText);
        let content = document.createElement('div');
        content.setAttribute('class', 'col-5 row');
        let date = document.createElement("span");
        date.setAttribute("class", "news-date col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4");
        let node = document.createTextNode(data[i][4]);
        date.appendChild(node);
        content.appendChild(date);
        let contentEditRemove = document.createElement('div');
        contentEditRemove.setAttribute('class', 'col-8 col-sm-7 clo-lg-6 p-0');
        let buttonEdit = document.createElement('button');
        buttonEdit.setAttribute('class', 'btn btn-outline-warning btn-sm m-1  col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4');
        buttonEdit.addEventListener('click', function () {
            edit(data[i]);
        });
        let text = document.createTextNode('Edit');
        buttonEdit.appendChild(text);
        contentEditRemove.appendChild(buttonEdit);
        let buttonRemove = document.createElement('button');
        buttonRemove.setAttribute('class', 'btn btn-outline-danger btn-sm m-1 col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4');
        buttonRemove.addEventListener('click', function () {
            remove(data[i][0])
        });
        text = document.createTextNode('X');
        buttonRemove.appendChild(text);
        contentEditRemove.appendChild(buttonRemove);
        content.appendChild(contentEditRemove);
        let div = document.createElement("div");
        div.setAttribute("class", "news-img col-7 col-sm-5 col-lg-3");
        div.innerHTML = data[i]['img'];
        let short_description = document.createElement("p");
        short_description.setAttribute("class", "col-12 col-sm-11 col-md-6 col-lg-5 mt-2 mt-lg-0 h6 content");
        text = document.createTextNode(data[i][1] + '...');
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
        container.appendChild(content);
        container.appendChild(div);
        container.appendChild(short_description);
        container.appendChild(link);
        container.appendChild(span);
    }
};

save = () => {
    let form = document.getElementById('create-new-post');
    let formData = new FormData(form);
    let promise = new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            data: formData,
            dataType: "html",
            processData: false,
            contentType: false,
            url: "ajax.php",
            cache: false,
            success: function (response) {
                debugger;
                response === 'Good' ? resolve() : reject();
            },
            error: function (error) {
                reject(error)
            }
        });
    });
    promise.then(() => {
        height = gap;
        load = 0;
        $('#post-title').val("");
        $('#post-text').val("");
        $('#postModal').modal('hide');
        $('#container').empty();
        getAllPage({day: day, category_id: category_id});
    }).catch((error = 'Incorrectly filled "Content"') => {
        console.info(error);
    })
};

edit = (data) => {

    $('#postModal').modal('toggle');
    $('.modal-title').text('Edit post');
    $('#category').val(data[6]);
    $('#post-title').val(data[1]);
    $('#post-text').val(data[2]);
    $('[name=post_id]').val(data[0]);
};

remove = (id) => {
    let promise = new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            data: {remove: id},
            dataType: "html",
            url: "ajax.php",
            cache: false,
            success: function (response) {
                debugger;
                response === 'Good' ? resolve() : reject();
            },
            error: function (error) {
                reject(error)
            }
        });
    });
    promise.then(() => {
        debugger;
        alert("Successfully deleted");
        height = gap;
        load = 0;
        $('#container').empty();
        getAllPage({day: day, category_id: category_id})
    }).catch(() => {
        alert('Could not delete');
    })

};

$('#postModal').on('show.bs.modal', function () {
    let modal = $(this);
    modal.find('.modal-title').text('Create new post');
    $('[name=post_id]').val('');
    $('#post-title').val("");
    $('#post-text').val("");
    $('#category').val("");
});