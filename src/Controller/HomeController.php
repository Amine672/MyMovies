<?php

namespace App\Controller;

use App\Entity\User;
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
    public function movie(Movie $slug): Response {

        $repositoryMovie = $this->getDoctrine()->getRepository(Movie::class);
        $repositoryRateMovie = $this->getDoctrine()->getRepository(RateMovie::class);
        
        $userRate = $repositoryRateMovie->findByUserIdAndMovieId($this->getUser(), $slug);
        
        $rateMovies = $repositoryRateMovie->findBy(['movie' => $slug]);
        $rate = 0;
        if ($rateMovies){
            foreach ($rateMovies as $value){
                $rate += $value->getRate();
            }
            $rate = $rate / count($rateMovies);
        }
        else {
            $rate = "Movie without a rate";
        }
        return $this->render('pages/movie.html.twig', [
            'movie' => $slug,
            'userRate' => $userRate,
            'rate' => $rate
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
     * @Route("/Rate/{note}/{user}/{movie}", name="rateMovie")
     */
    public function rateMovie($note, User $user, Movie $movie) : Response{
        $repositoryRateMovie = $this->getDoctrine()->getRepository(RateMovie::class);
        $em = $this->getDoctrine()->getManager();
        $repositoryRateMovie->findBy(['user' => $user]);
        if($rating = $repositoryRateMovie->findByUserIdAndMovieId($user, $movie)){
            $rating->setRate($note);
        }
        else {
            $rating = new RateMovie();
            $rating->setUser($user);
            $rating->setMovie($movie);
            $rating->setRate($note);
            $em->persist($rating);
        }
        $em->flush();

        $response =  $this->render('pages/rating.html.twig', [
                "userRate" => $rating
            ])->getContent();

        return new Response($response);
    }
}
