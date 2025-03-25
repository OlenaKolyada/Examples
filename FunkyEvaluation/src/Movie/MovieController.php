<?php

declare(strict_types=1);

namespace src\Movie;

class MovieController
{
    public function __construct(
        private Movie $movie,
        private MovieView $movieView
    ) {
    }

// L'obtention tous les films
    public function getAllMovies(): void
    {
        $movies = $this->movie->fetchAllMovies(); // La requête et la réception du tableau de films depuis le modèle
        $this->renderMovies($movies);
    }

//L'obtention des films du genre sélectionné
    public function getMoviesByGenre(): void
    {
        $genre = $_POST['genreSelect'] ?? ''; // L'extraction du genre à partir du tableau `$_POST`
        $movies = $this->movie->fetchMoviesByGenre($genre); // La requête et la réception du tableau de films depuis le modèle
        $this->renderMovies($movies);
    }

    // La transmission des données à la vue
    public function renderMovies(array $movies): void
    {
        $counter = count($movies); // Le comptage du nombre de films trouvés
        $this->movieView->displayMovies($counter, $movies);
    }

}