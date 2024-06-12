import React from "react";
import { Carousel as ReactCarousel } from "react-responsive-carousel";
import "react-responsive-carousel/lib/styles/carousel.min.css";

const Carousel = () => (
    <div className="react-carousel-card">
        <ReactCarousel
            className="react-carousel"
            showArrows={false}
            showStatus={false}
            showThumbs={false}
            swipeable={true}
            emulateTouch={true}
            autoPlay={true}
            interval={4000}
            infiniteLoop={true}
        >
            <div className="react-carousel-slide">
                <div className="image-wrapper">
                    <img
                        src="/images/Logo-Friendflix.webp"
                        alt="Logo Friendflix'"
                    />
                </div>
            </div>
            <div className="react-carousel-slide">
                <div className="image-wrapper">
                    <img
                        src="/images/Principal-1.webp"
                        alt="Frase 'Descubre'"
                    />
                </div>
            </div>
            <div className="react-carousel-slide">
                <div className="image-wrapper">
                    <img
                        src="/images/Principal-2.webp"
                        alt="Frase 'Comparte'"
                    />
                </div>
            </div>
            <div className="react-carousel-slide">
                <div className="image-wrapper">
                    <img
                        src="/images/Principal-3.webp"
                        alt="Frase 'y Decide'"
                    />
                </div>
            </div>
        </ReactCarousel>
    </div>
);

export default Carousel;
