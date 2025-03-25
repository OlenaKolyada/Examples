document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('genre');
    const form = document.getElementById('search_form');

    const rootUrl = window.location.origin;
    const currentUrl = window.location.href;

    const homePagePath = '/FunkyEvaluation/public/';
    const homePageUrl = `${rootUrl}${homePagePath}`;

    if (currentUrl === homePageUrl || currentUrl === `${homePageUrl}index.php`) {
        localStorage.removeItem('selectedGenre');
        selectElement.value = '';
        form.action = "?c=MovieController&m=getAllMovies";
    } else {
        const savedGenre = localStorage.getItem('selectedGenre');
        if (savedGenre) {
            selectElement.value = savedGenre;
        } else {
            selectElement.value = '';
        }
        form.action = selectElement.value === "" ? "?c=MovieController&m=getAllMovies" : "?c=MovieController&m=getMoviesByGenre";
    }

    selectElement.addEventListener('change', function() {
        const genreSelect = this.value;

        try {
            localStorage.setItem('selectedGenre', genreSelect);
        } catch (e) {
            console.error('Failed to save genre to localStorage:', e);
        }

        form.action = genreSelect === "" ? "?c=MovieController&m=getAllMovies" : "?c=MovieController&m=getMoviesByGenre";
    });
});
