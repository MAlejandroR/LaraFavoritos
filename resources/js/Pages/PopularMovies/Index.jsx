import {Link} from "@inertiajs/react";
import {Inertia} from "@inertiajs/inertia";
import {useState, useEffect} from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {CiHeart} from "react-icons/ci";
import {FaHeart} from "react-icons/fa";
import {usePage} from "@inertiajs/react";

const MovieCard = ({film, isFavorite, handleFavouriteChange}) => {

    //User connect
    const user_id = usePage().props.auth.user.id
    console.log(`PopularMovie@Index.jxs. user_id =-${user_id}-`)

    return (
        <div className="movie-container">
            <div className="movie-card">
                <img
                    src={`https://image.tmdb.org/t/p/w200${film.poster_path}`}
                    alt={film.title}
                    className="poster-image"
                />
                <div className="overlay">
                    <img
                        src={`https://image.tmdb.org/t/p/original${film.backdrop_path}`}
                        alt={`${film.title} backdrop`}
                        className="backdrop-image"
                    />
                    <div className="movie-details">
                        <p>{film.overview}</p>
                    </div>
                </div>
            </div>
            <button onClick={(e) => handleFavouriteChange(e, film.id)}>
                {isFavorite ? <FaHeart/> : <CiHeart/>}
            </button>

            <h3 className="title">{film.title}</h3>
        </div>
    );
};

const PopularMovies = ({auth, films}) => {
    const filmsResults = films?.results || [];
    const totalPages = films ? films.total_pages : 1;
    const currentPage = films ? films.page : 1;

    const [favorites, setFavorites] = useState([]);

    //Esta función es la que más cambia
    //Obtenemos todos los favoritos del usuario conectado
    useEffect(() => {
        axios.get(`/favorites/${auth.user.id}`)
            .then(response => {
                setFavorites(response.data)
            })
            .catch(error => {
                console.error("Error fetching favorites", error);
            });
    }, [auth.user.id]);

    const handleFavouriteChange = (event, movie_id) => {
        console.log(`handleFavourteChange -${movie_id}-`);
        event.stopPropagation();
        const isCurrentFavorite = favorites.includes(movie_id);
        if (isCurrentFavorite) {
            axios.get(`/delFavorite/${auth.user.id}/${movie_id}`)
                .then(() => {
                    setFavorites(favorites.filter(id => id !== movie_id));
                })
                .catch(error => {
                    console.error("Error removing favorite", error);

                });
        } else {
            // Add to favorites
            axios.get(`/addFavorite/${auth.user.id}/${movie_id}`)
                .then(() => {
                    setFavorites([...favorites, movie_id]);
                })
                .catch(error => {
                    console.error("Error adding favorite " + error);
                });
        }


    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Películas
                </h2>
            }
        >
            <div className="movies-grid">
                {filmsResults.map((film) => (
                    <MovieCard
                        key={film.id}
                        film={film}
                        isFavorite={favorites.includes(film.id)}
                        handleFavouriteChange={handleFavouriteChange}
                    />
                ))}
            </div>
            <div className="pagination">
                {currentPage > 1 && (
                    <Link href={`/peliculas?page=${currentPage - 1}`}>
                        &laquo; Previous
                    </Link>
                )}
                {currentPage < totalPages && (
                    <Link href={`/peliculas?page=${currentPage + 1}`}>
                        Next &raquo;
                    </Link>
                )}
            </div>
        </AuthenticatedLayout>
    );
};

export default PopularMovies;
