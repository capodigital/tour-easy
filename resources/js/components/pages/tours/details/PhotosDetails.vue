<script>
export default {
    props: {
        tour: Object,
        images: Array,
    }
}
</script>
<template>
    <div class="ia-container">
        <figure>
            <img :src="images.length > 0 ? images[0].url : 'src/image-placeholder.jpg'" />
            <input type="radio" name="radio-set" checked="checked" />
            <figcaption><span>
                    <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                    <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                    <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                </span></figcaption>

            <figure>
                <img :src="images.length > 1 ? images[1].url : 'src/image-placeholder.jpg'" />
                <input type="radio" name="radio-set" />
                <figcaption><span>
                        <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                        <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                        <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                    </span></figcaption>

                <figure>
                    <img :src="images.length > 2 ? images[2].url : 'src/image-placeholder.jpg'" />
                    <input type="radio" name="radio-set" />
                    <figcaption><span>
                            <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                            <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                            <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                        </span></figcaption>

                    <figure>
                        <img :src="images.length > 3 ? images[3].url : 'src/image-placeholder.jpg'" />
                        <input type="radio" name="radio-set" />
                        <figcaption><span>
                                <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                            </span></figcaption>

                        <figure>
                            <img :src="images.length > 4 ? images[4].url : 'src/image-placeholder.jpg'" />
                            <input type="radio" name="radio-set" />
                            <figcaption><span>
                                    <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                    <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                    <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                </span></figcaption>

                            <figure>
                                <img :src="images.length > 5 ? images[5].url : 'src/image-placeholder.jpg'" />
                                <input type="radio" name="radio-set" />
                                <figcaption><span>
                                        <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                        <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                        <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                    </span></figcaption>

                                <figure>
                                    <img :src="images.length > 6 ? images[6].url : 'src/image-placeholder.jpg'" />
                                    <input type="radio" name="radio-set" />
                                    <figcaption><span>
                                            <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                            <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                            <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                        </span></figcaption>

                                    <figure>
                                        <img :src="images.length > 7 ? images[7].url : 'src/image-placeholder.jpg'" />
                                        <input id="ia-selector-last" type="radio" name="radio-set" />
                                        <figcaption><span>
                                                <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                            </span></figcaption>

                                        <figure>
                                            <img :src="images.length > 8 ? images[8].url : 'src/image-placeholder.jpg'" />
                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                            <figcaption><span>
                                                    <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                    <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                    <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}
                                                    </p>
                                                </span></figcaption>

                                            <figure>
                                                <img
                                                    :src="images.length > 9 ? images[9].url : 'src/image-placeholder.jpg'" />
                                                <input id="ia-selector-last" type="radio" name="radio-set" />
                                                <figcaption><span>
                                                        <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                        <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                        <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate
                                                        }}</p>
                                                    </span></figcaption>

                                                <figure>
                                                    <img
                                                        :src="images.length > 10 ? images[10].url : 'src/image-placeholder.jpg'" />
                                                    <input id="ia-selector-last" type="radio" name="radio-set" />
                                                    <figcaption><span>
                                                            <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                            <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                            <p class="text-xs mt-2">{{ tour.startdate }} - {{
                                                                tour.enddate }}</p>
                                                        </span></figcaption>

                                                    <figure>
                                                        <img
                                                            :src="images.length > 11 ? images[11].url : 'src/image-placeholder.jpg'" />
                                                        <input id="ia-selector-last" type="radio" name="radio-set" />
                                                        <figcaption><span>
                                                                <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                                <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                                <p class="text-xs mt-2">{{ tour.startdate }} - {{
                                                                    tour.enddate }}</p>
                                                            </span></figcaption>

                                                        <figure>
                                                            <img
                                                                :src="images.length > 12 ? images[12].url : 'src/image-placeholder.jpg'" />
                                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                                            <figcaption><span>
                                                                    <p class="text-xs md:text-md">{{ tour.tourname }}
                                                                    </p>
                                                                    <p class="text-xs mt-2">{{ tour.artist.stagename }}
                                                                    </p>
                                                                    <p class="text-xs mt-2">{{ tour.startdate }} - {{
                                                                        tour.enddate }}</p>
                                                                </span></figcaption>

                                                            <figure>
                                                                <img
                                                                    :src="images.length > 13 ? images[13].url : 'src/image-placeholder.jpg'" />
                                                                <input id="ia-selector-last" type="radio"
                                                                    name="radio-set" />
                                                                <figcaption><span>{{ tour.tourname }}</span>
                                                                </figcaption>

                                                                <figure>
                                                                    <img
                                                                        :src="images.length > 14 ? images[14].url : 'src/image-placeholder.jpg'" />
                                                                    <input id="ia-selector-last" type="radio"
                                                                        name="radio-set" />
                                                                    <figcaption><span>{{ tour.tourname }}</span>
                                                                    </figcaption>

                                                                    <figure>
                                                                        <img
                                                                            :src="images.length > 15 ? images[15].url : 'src/image-placeholder.jpg'" />
                                                                        <input id="ia-selector-last" type="radio"
                                                                            name="radio-set" />
                                                                        <figcaption><span>{{ tour.tourname }}</span>
                                                                        </figcaption>

                                                                        <figure>
                                                                            <img
                                                                                :src="images.length > 16 ? images[16].url : 'src/image-placeholder.jpg'" />
                                                                            <input id="ia-selector-last" type="radio"
                                                                                name="radio-set" />
                                                                            <figcaption><span>{{ tour.tourname }}</span>
                                                                            </figcaption>

                                                                            <figure>
                                                                                <img
                                                                                    :src="images.length > 17 ? images[17].url : 'src/image-placeholder.jpg'" />
                                                                                <input id="ia-selector-last" type="radio"
                                                                                    name="radio-set" />
                                                                                <figcaption><span>{{ tour.tourname
                                                                                }}</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </figure>
                                                                    </figure>
                                                                </figure>
                                                            </figure>
                                                        </figure>
                                                    </figure>
                                                </figure>
                                            </figure>
                                        </figure>
                                    </figure>

                                </figure>

                            </figure>

                        </figure>

                    </figure>

                </figure>

            </figure>

        </figure>

    </div>
</template>
<style scoped>
.ia-container {
    /*width: calc(100vw - 40px);*/
    margin: 20px auto;
    overflow: hidden;
    box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.08);
    border: 7px solid rgba(255, 255, 255, 0.6);
}

.ia-container figure {
    position: absolute;
    top: 0;
    left: 50px;
    /* width of visible piece */
    width: 335px;
    height: 100%;
    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.6);
    transition: all 0.3s ease-in-out;
}

.ia-container>figure {
    position: relative;
    left: 0 !important;
}

.ia-container img {
    display: block;
    width: 100%;
    height: 100%;
}

.ia-container input {
    position: absolute;
    top: 0;
    left: 0;
    width: 50px;
    /* just cover visible part */
    height: 100%;
    cursor: pointer;
    border: 0;
    padding: 0;
    opacity: 0;
    z-index: 100;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.ia-container input:checked {
    width: 5px;
    left: auto;
    right: 0px;
}

.ia-container input:checked~figure {
    left: 335px;
    transition: all 0.7s ease-in-out;
}

.ia-container figcaption {
    width: 100%;
    height: 100%;
    background: rgba(87, 73, 81, 0.1);
    position: absolute;
    top: 0px;
    transition: all 0.2s linear;
}

.ia-container figcaption span {
    position: absolute;
    top: 10%;
    margin-top: -30px;
    right: 20px;
    left: 20px;
    overflow: hidden;
    text-align: center;
    background: rgba(87, 73, 81, 0.4);
    line-height: 20px;
    font-size: 18px;
    opacity: 0;
    text-transform: uppercase;
    letter-spacing: 4px;
    font-weight: 700;
    padding: 20px;
    color: #fff;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
}

.ia-container input:checked+figcaption,
.ia-container input:checked:hover+figcaption {
    background: rgba(87, 73, 81, 0);
}

.ia-container input:checked+figcaption span {
    transition: all 0.4s ease-in-out 0.5s;
    opacity: 1;
    top: 40%;
}

.ia-container #ia-selector-last:checked+figcaption span {
    transition-delay: 0.3s;
}

.ia-container input:hover+figcaption {
    background: rgba(87, 73, 81, 0.03);
}

.ia-container input:checked~figure input {
    z-index: 1;
}

@media screen and (max-width: 720px) {
    .ia-container {
        width: 540px;
    }

    .ia-container figure {
        left: 40px;
        width: 260px;
    }

    .ia-container input {
        width: 40px;
    }

    .ia-container input:checked~figure {
        left: 260px;
    }

    .ia-container figcaption span {
        font-size: 16px;
    }
}

@media screen and (max-width: 520px) {
    .ia-container {
        width: 320px;
    }

    .ia-container figure {
        left: 20px;
        width: 180px;
    }

    .ia-container input {
        width: 20px;
    }

    .ia-container input:checked~figure {
        left: 180px;
    }

    .ia-container figcaption span {
        font-size: 12px;
        letter-spacing: 2px;
        padding: 10px;
        margin-top: -20px;
    }

}
</style>
