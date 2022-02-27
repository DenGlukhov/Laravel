fetch('/api/test') // Запрос через fetch (чистый JS)
    .then(response => response.json())
    .then(users => console.log(users));

    $.ajax({ // Запрос через jquery
        url: 'api/test',
        dataType: 'json',
        data: {
            id: 1
        },
        success: function (user) {
            for (key in user) {
                console.log(key, user[key]);
            }
        }
    })