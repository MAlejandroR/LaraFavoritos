import Dropdown from "@/Components/Dropdown.jsx";
import MovieForm from "@/Components/MovieForm.jsx";
import { useState } from "react";
import { usePage } from "@inertiajs/react";

export default function MovieItem({ movie }) {
    const [editing, setEditing] = useState(false);

    const { auth } = usePage().props;

    return (
        <div className="flex space-x-2 p6">
            <svg
                className="h-6 w-6 text-gray-600"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                aria-hidden="true"
            >
                <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
                <path d="M16 3 21 8M8 3l4 5m-8-5 4 5m2-5h5M8 8h13"></path>
            </svg>

            <div className="flex-1">
                <div className="flex items-center justify-between">
                    <div>
                        <span className="text-gray-800">{movie.user.name}</span>

                        <small className="ml-2 text-sm text-gray-600">
                            {movie.createdAt}
                        </small>
                        {movie.edited && (
                            <small className="ml-1 text-sm text-gray-600">
                                &middot; editado
                            </small>
                        )}
                    </div>
                </div>
                {editing ? (
                    <MovieForm
                        movie={movie}
                        className="mt-2"
                        setEditing={setEditing}
                    />
                ) : (
                    <p className="mt-4 text-lg text-gray-900">
                        {movie.favourite}
                    </p>
                )}
            </div>
            {movie.user.id === auth.user.id && (
                <Dropdown>
                    <Dropdown.Trigger>
                        <button>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="24"
                                height="24"
                                fill="currentColor"
                            >
                                <circle cx="5" cy="12" r="2"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                                <circle cx="19" cy="12" r="2"></circle>
                            </svg>
                        </button>
                    </Dropdown.Trigger>
                    <Dropdown.Content>
                        <Dropdown.Button onClick={() => setEditing(true)}>
                            Editar
                        </Dropdown.Button>
                        <Dropdown.Link
                            as="button"
                            href={route("movies.destroy", movie.id)}
                            method="delete"
                        >
                            Borrar
                        </Dropdown.Link>
                    </Dropdown.Content>
                </Dropdown>
            )}
        </div>
    );
}
