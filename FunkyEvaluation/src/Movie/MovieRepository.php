<?php

declare(strict_types=1);

namespace src\Movie;

use src\BaseRepository;

class MovieRepository extends BaseRepository
{
    // La requête pour sélectionner toutes les entrées dans la table des films
    public function selectAllMovies(): array
    {
        $sql = "SELECT * FROM `film`"; // La création de la requête
        $stmt = $this->pdo->query($sql); // L'exécution de la requête
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // La récupération des résultats sous forme de tableau de films
    }

    // La requête complexe pour obtenir la liste des films d'un genre spécifique
    public function selectMoviesByGenre(string $genre): array
    {
        // La jointure des tables des films et des genres via une table de liaison
        $sql = "
        SELECT f.*
        FROM film f
        JOIN appartenir a ON f.id_film = a.id_film
        JOIN genre g ON a.id_genre = g.id_genre
        WHERE g.genre = :genre
    ";

        $stmt = $this->pdo->prepare($sql); // La préparation de la requête
        $stmt->bindValue(':genre', $genre, \PDO::PARAM_STR); // La liaison des variables aux paramètres de la requête
        $stmt->execute(); // L'exécution de la requête
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // La récupération des résultats sous forme de tableau de films
    }
}