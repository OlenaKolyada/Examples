<?php

declare(strict_types=1);

namespace src\Movie;

class MovieView
{
    // L'affichage de la liste des films
    public function displayMovies(int $counter, array $movies): void
    {
        $content = dirname(__DIR__) . '/../templates/movie_list.html'; // Un template partiel
        $title = 'Movie List'; // Le titre de la page
        include dirname(__DIR__) . '/../templates/layout.html'; // L'inclusion du template principal
    }
}