<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Genre;
use App\Entity\Movie;

use App\Entity\Director;
use App\Entity\RateMovie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function carousel() : Response{
        $repositoryGenre = $this->getDoctrine()->getRepository(Genre::class);
        $genres = $repositoryGenre->findAll();
        return $this->render('home/home.html.twig', [
            'genres' => $genres
        ]);
    }
    /**
    * @Route("/Movie/{slug}", name="Movie")
    */
    public function movie($slug): Response {

        $repositoryMovie = $this->getDoctrine()->getRepository(Movie::class);
        $movie = $repositoryMovie->findBy(['id' => $slug]);
        

        return $this->render('pages/movie.html.twig', [
            'movie' => $movie[0]
        ]);
    }
    /**
    * @Route("/Genre/{slug}", name="Genre")
    */
    public function genre($slug) : Response{

        $repositoryMovies = $this->getDoctrine()->getRepository(Movie::class);
        $repositoryGenre = $this->getDoctrine()->getRepository(Genre::class);
        $genre = $repositoryGenre->findBy(['id' => $slug]);
        $movies = $repositoryMovies->findByGenre($genre);
        
        for ($i = 0; $i <= 19; $i++){
            $y = rand(1, 300);
            $movies_20[] = $movies[$y];
        }
        return $this->render('pages/genre.html.twig', [
            'movies' => $movies_20,
            'genre' => $genre
        ]);
    }

    /**
     * @Route("/ListGenre", name="listgenre")
     */
    public function listgenre() :Response {

        $repositoryGenre = $this->getDoctrine()->getRepository(Genre::class);
        $genres = $repositoryGenre->findAll();

        return $this->render('pages/listgenre.html.twig', [
            'genres' => $genres
        ]);
    }

    /**
     * @Route("/Actor/{slug}", name="Actor")
     */
    public function actor($slug) : Response {

        $repositoryActor = $this->getDoctrine()->getRepository(Actor::class);
        $actors = $repositoryActor->findBy(['id' => $slug]);
        return $this->render('pages/actor.html.twig', [
            'actors' => $actors
        ]);
    }

    /**
     * @Route("/Rate/{note}/{userId}/{movieId}", name="rateMovie")
     */
    public function rateMovie($note, $userId, $movieId) : Response{
        $repositoryRateMovie = $this->getDoctrine()->getRepository(RateMovie::class);

        if ($repositoryRateMovie->findByUserIdAndMovieId($userId, $movieId)){
            $repositoryRateMovie->updateRate($note, $userId, $movieId);
        }
        else {
            $repositoryRateMovie->insertRate($note, $userId, $movieId);
        }

        
        return new Response($note);
    }
}
