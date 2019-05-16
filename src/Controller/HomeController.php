<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Actor;
use App\Entity\Genre;

use App\Entity\Movie;
use App\Entity\Director;
use App\Entity\RateMovie;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Driver\Connection;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Home(Connection $conn) : Response{
        $repositoryGenre = $this->getDoctrine()->getRepository(Genre::class);
        $repositoryMovie = $this->getDoctrine()->getRepository(Movie::class);
        $genres = $repositoryGenre->findAll();
        $movie = $repositoryMovie->movieRandom($conn);
        dump($movie);
        $array_img = array(
            "https://i.ytimg.com/vi/2b4ByQzq3Yk/maxresdefault.jpg",
            "https://i.ytimg.com/vi/6mrUQz294Do/maxresdefault.jpg",
            "https://www.cartoonbrew.com/wp-content/uploads/2014/11/minions-2015-1280x600.jpg",
            "https://cdn3.movieweb.com/i/movie/WKbzuC1S26KSPhzAnIgC80tgBT2N1A/384:50/Lincoln.jpg",
            "https://s3-us-west-2.amazonaws.com/flx-editorial-wordpress/wp-content/uploads/2018/09/05162332/600Comedies2.jpg",
            "https://theplaylist.net/wp-content/uploads/2017/06/The-50-Best-Crime-Movies-Of-The-21st-Century-So-Far.jpg",
            "https://greennews.ie/wp3/wp-content/uploads/2016/08/the-atlantic.jpg",
            "https://goodmovieslist.com/article-images/best-drama-movies.jpg",
            "http://www.geekbinge.com/wp-content/uploads/2014/03/FP-1991-Addams.jpg",
            "https://www.femalefirst.co.uk/image-library/land/1000/t/the-lord-of-the-rings-feature-poster.jpg",
            "https://orion-uploads.openroadmedia.com/md_47a5788588fb-modern-film-noir_featured.jpg",
            "https://wallpapercave.com/wp/wp3610594.jpg",
            "https://cdn3.movieweb.com/i/article/qiZa5MwNmZn251aa0rOFPBtaPZ4RGL/798:50/Horror-Movies-2019-Most-Anticipated.jpg",
            "https://www.netflix-news.com/wp-content/uploads/2018/06/Jamie-Foxx-Ray-jamie-foxx-490853_1280_1024.jpg",
            "https://cdn3.movieweb.com/i/movie/1vf613jMI8Ni7ceCPolymZecDPhwVR/384:50/The-Greatest-Showman.jpg",
            "https://dz7u9q3vpd4eo.cloudfront.net/wp-content/legacy/posts/85b834b9-bfe7-4d9e-85c6-1fa69fc2dbf4.jpg",
            "http://www.dvdpascher.net/screen/dvd/1/1830_image4_big.jpg",
            "http://fonds-ecran.widewallpapershd.info/file/12216/728x410/16:9/interstellar-movie-2014_1486271744.jpg",
            "http://www.danielsnaddon.com/wp-content/uploads/2016/05/60_002_O-Ring_Cover_Saturation-guide.jpg",
            "https://imagesvc.timeincapp.com/v3/fan/image?url=https%3A%2F%2Fnetflixlife.com%2Ffiles%2F2016%2F06%2FAli-movie.jpg&c=sc&w=850&h=560",
            "https://i.ytimg.com/vi/M0HvPP55RtY/maxresdefault.jpg",
            "http://www.listingmaniac.com/wp-content/uploads/2017/12/CRIME-THRILLER-MOVIE.jpg",
            "https://usercontent2.hubstatic.com/13333069.jpg",
            "https://cdn.shopify.com/s/files/1/0969/9128/products/Movie_Poster_-_The_Good_The_Bad_And_The_Ugly_-_Hollywood_Collection_0d65da66-17cf-4c7f-b060-222527898241.jpg?v=1481897750",
            "https://cdn.shopify.com/s/files/1/0674/8835/files/logo.png?v=1469683823",
            "https://www.libe.ma/photo/art/grande/27798741-27798783.jpg?v=1542545414",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwVDyyxYK2N5UWlqolmdDUaHEi5xv9lau6g5C9Z8fCVVCjEBPGcA"
        );

        
        return $this->render('home/home.html.twig', [
            'genres' => $genres,
            'images' => $array_img,
            'movies' => $movie
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
            $rate = $rate.'/10';
        }
        else {
            $rate = "Still not rate";
        }
        return $this->render('pages/movie.html.twig', [
            'movie' => $slug,
            'userRate' => $userRate,
            'rate' => $rate 
        ]);
    }
    /**
     * @Route("/AverageRate/{slug}", name="average")
     */
    public function average($slug){

        $repositoryRateMovie = $this->getDoctrine()->getRepository(RateMovie::class);
        $rateMovies = $repositoryRateMovie->findBy(['movie' => $slug]);
        $rate = 0;
        if ($rateMovies){
            foreach ($rateMovies as $value){
                $rate += $value->getRate();
            }
            $rate = $rate / count($rateMovies);
        }
        $average = json_encode($rate);

        return new JsonResponse($average, 200);

    }
    /**
    * @Route("/Genre/{slug}", name="Genre")
    */
    public function genre($slug, PaginatorInterface $paginator, Request $request) : Response{

        $repositoryMovies = $this->getDoctrine()->getRepository(Movie::class);
        $repositoryGenre = $this->getDoctrine()->getRepository(Genre::class);
        $genre = $repositoryGenre->findBy(['id' => $slug]);
        // $movies = $repositoryMovies->findByGenre($genre);
        
        $movies = $paginator->paginate(
            $repositoryMovies->findByGenre($genre),
            $request->query->getInt('page', 1),
            20
        );

        // for ($i = 0; $i <= 19; $i++){
        //     $y = rand(1, 300);
        //     $movies_20[] = $movies[$y];
        // }
        return $this->render('pages/genre.html.twig', [
            // 'movies' => $movies_20,
            'genre' => $genre,
            'movies' => $movies
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
    /**
     * @Route("/search_movie", name="search_movie") 
     */
    public function search(Request $req) : Response{
        $em = $this->getDoctrine()->getManager();
        $key = $req->get('searchBar');
        $repositoryMovie = $this->getDoctrine()->getRepository(Movie::class);
        
        $rep = $repositoryMovie->searchBar($key);

        $response =  $this->render('pages/searchResult.html.twig', [
            "results" => $rep
        ])->getContent();

        return new Response($response);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(){

        $repositoryRateMovie = $this->getDoctrine()->getRepository(RateMovie::class);
        $userMovie = $repositoryRateMovie->findBy(['user' => $this->getUser()]);
        $rated = count($userMovie);
        return $this->render('pages/profil.html.twig', [
            'userMovie' => $userMovie,
            'rated' => $rated
        ]);
    }
}
