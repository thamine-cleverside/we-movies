import { Controller } from '@hotwired/stimulus';
import ReactDOM from "react-dom";
import MovieList from "../components/movieList";
import React from 'react';

export default class extends Controller {
    static values = {
        moviesUrl: String,
        gendersUrl: String,
    }

    connect() {
        ReactDOM.render(
            <MovieList moviesUrl={this.moviesUrlValue} gendersUrl={this.gendersUrlValue}/>,
            this.element
        )
    }
}
