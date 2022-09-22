import React from 'react';
import MovieItem from "./movieItem";
import MovieFilter from "./movieFilter";
import { CRow, CCol, CContainer } from '@coreui/react'

export default class MovieList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            page: 1,
            totalItems: 0,
            movies: [],
            filters: []
        };
        this.getMovies();
        this.filterHandler = this.filterHandler.bind(this)
    }

    async getMovies() {
        const queryFilter = this.generateFilterQuery();

        const response = await fetch(this.props.moviesUrl + '?page=' + this.state.page + queryFilter)
        const data = await response.json()
        this.setState({
            movies: await data['hydra:member'],
            totalItems: await data['hydra:totalItems'],
        })
    }

    filterHandler(data) {
        this.setState({filters: data}, this.getMovies);
    }

    generateFilterQuery() {
        let query = '';
        console.log(this.state.filters?.genders);
        if (this.state.filters?.genders) {
            query += this.state.filters?.genders?.reduce((acc, curr) => acc + '&gender[]=' + curr, '')
        }
        return query
    }

    render() {
        return (
            <CContainer>
                <CRow className="align-items-start">
                    <CCol md={4}>
                        <MovieFilter gendersUrl={this.props.gendersUrl} handler={(data) => this.filterHandler(data)}/>
                    </CCol>
                    <CCol md={8}>
                            {this.state.totalItems} film(s) trouvé(s)
                            {this.state.movies.map((item, index) => (
                                <MovieItem key={item.id} item={item}/>
                            ))}
                    </CCol>
                </CRow>
            </CContainer>
        )
    }
}
