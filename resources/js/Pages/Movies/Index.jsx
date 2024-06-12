import MovieForm from "@/Components/MovieForm.jsx";
import MovieItem from "@/Components/MovieItem.jsx";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Index({ auth, movies }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Recomendaciones
                </h2>
            }
        >
            <Head title="Friendflix">
                <meta
                    name="description"
                    content="Descubre las películas y series que ven tus amigos"
                />
            </Head>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            Aquí se mostrarán las recomendaciones de tus amigos
                            de películas y series
                            <MovieForm />
                        </div>
                    </div>

                    <div className="mt-6 bg-white shadow-md rounded-lg divide-y">
                        {movies.map((movie) => (
                            <MovieItem
                                key={`movie-${movie.id}`}
                                movie={movie}
                            />
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
