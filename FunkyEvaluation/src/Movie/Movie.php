<?php

declare(strict_types=1);

namespace src\Movie;

class Movie
{
    public function __construct(
        private MovieRepository $movieRepository
    ) {
    }

    // La requête et la réception de tous les films
    public function fetchAllMovies(): array
    {
        return $this->movieRepository->selectAllMovies();
    }

    // La requête et la réception des films du genre sélectionné
    public function fetchMoviesByGenre(string $genre): array
    {
        return $this->movieRepository->selectMoviesByGenre($genre);
    }
}