import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import InputError from "@/Components/InputError.jsx";
import { useForm } from "@inertiajs/react";

export default function MovieForm({ movie, className, setEditing }) {
    const { data, setData, post, patch, reset, errors, processing } = useForm({
        name: movie?.name,
        surname: movie?.surname,
        favourite: movie?.favourite,
    });

    function update(movie) {
        patch(route("movies.update", movie), {
            onSuccess: () => reset(),
            preserveState: false,
        });
    }

    function handleSubmit(e) {
        e.preventDefault();

        if (movie?.id) {
            update(movie.id);
            return;
        }

        post(route("movies.store"), {
            onSuccess: () => reset(),
            preserveState: false,
        });
    }

    return (
        <form onSubmit={handleSubmit} className={className}>
            <input
                type="text"
                id="name"
                placeholder="Nombre"
                name="name"
                value={data.name}
                onChange={(e) => setData("name", e.target.value)}
                pattern="[a-zA-Z ]{2,30}"
            />
            <InputError message={errors.name} />
            <input
                type="text"
                id="surname"
                placeholder="Apellido"
                name="surname"
                value={data.surname}
                onChange={(e) => setData("surname", e.target.value)}
                pattern="[a-zA-Z ]{2,30}"
            />
            <InputError message={errors.surname} />
            <textarea
                name="favourite"
                id="favourite"
                placeholder="¿Cuáles son tus películas y series favoritas?"
                value={data.favourite}
                onChange={(e) => setData("favourite", e.target.value)}
            ></textarea>
            <InputError message={errors.favourite} />
            <div>{JSON.stringify(errors)}</div>
            <PrimaryButton disabled={processing}>
                {processing ? "Guardando..." : "Guardar"}
            </PrimaryButton>
            {movie?.id && (
                <SecondaryButton
                    onClick={() => setEditing(false)}
                    className="ml-2"
                >
                    Cancel
                </SecondaryButton>
            )}
        </form>
    );
}
