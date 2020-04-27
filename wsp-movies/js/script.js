function movieSearch() {
    // let movie = $('#search-input').val();

    $('#movie-list').html('');

    $.ajax({
        url: 'http://www.omdbapi.com/',
        type: 'get',
        dataType: 'json',
        data: {
            apikey: '3b6d046',
            s: $('#search-input').val()
        },
        success: function (result) {
            console.log(result);
            if (result.Response === 'True') {

                let movie = result.Search;

                $.each(movie, function (i, data) {
                    $('#movie-list').append(`
                        <div class='col mb-4'>
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="` + data.Poster + `" alt="Card image cap">
                                <div class="card-body">
                                <h5 class="card-title">` + data.Title + `</h5>
                                <h6 class="card-subtitle mb-2 text-muted">` + data.Year + `</h6>
                               
                                <a href="#" class="card-link see-detail" data-toggle="modal" data-target="#exampleModal" data-id="` + data.imdbID + `">Detail</a>
                                </div>
                            </div>
                        </div>
                    `);
                })

            } else {
                $('#movie-list').html(`
                    <div class="col">
                        <h2 class='text-center'>` + result.Error + `</h2>                
                    </div>
                `);
            }
        }
    });
}

$('#search-button').on('click', function () {
    movieSearch();
});

$('#search-input').on('keyup', function (e) {
    if (e.keyCode === 13) {
        movieSearch();
    }
});

$('#movie-list').on('click', '.see-detail', function () {
    let id = $(this).data('id');

    // $('.modal-body').html(`
    //     <h1>test</h1>
    // `);

    $.ajax({
        url: 'http://www.omdbapi.com/',
        type: 'get',
        dataType: 'json',
        data: {
            apikey: '3b6d046',
            i: id
        },
        success: function (movie) {
            if (movie.Response === 'True') {
                $('.modal-body').html(`
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="` + movie.Poster + `" width="250">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group">
                                    <li class="list-group-item">Title : ` + movie.Title + `</li>
                                    <li class="list-group-item">Year : ` + movie.Year + `</li>
                                    <li class="list-group-item">Released : ` + movie.Released + `</li>
                                    <li class="list-group-item">Actors : ` + movie.Actors + `</li>
                                    <li class="list-group-item">Plot : ` + movie.Plot + `</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `);
            }
        }
    });

})